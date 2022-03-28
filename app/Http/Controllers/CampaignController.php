<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Cashout;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::orderBy('name')->get()->pluck('name', 'id');

        return view('campaign.index', compact('category'));
    }

    public function data(Request $request)
    {
        $query = Campaign::when(auth()->user()->hasRole('donatur'), function ($query) {
                $query->donatur();
            })
            ->when($request->has('status') && $request->status != "", function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when(
                $request->has('start_date') && 
                $request->start_date != "" && 
                $request->has('end_date') && 
                $request->end_date != "", 
                function ($query) use ($request) {
                    $query->whereBetween('publish_date', $request->only('start_date', 'end_date'));
                }
            )
            ->orderBy('publish_date', 'desc');

        return datatables($query)
            ->addIndexColumn()
            ->editColumn('short_description', function ($query) {
                return $query->title .'<br><small>'. $query->short_description .'</small>';
            })
            ->editColumn('path_image', function ($query) {
                return '<img src="'. Storage::disk('public')->url($query->path_image) .'" class="img-thumbnail">';
            })
            ->editColumn('status', function ($query) {
                return '<span class="badge badge-'. $query->statusColor() .'">'. $query->status .'</span>';
            })
            ->addColumn('author', function ($query) {
                return $query->user->name;
            })
            ->addColumn('action', function ($query) {
                $text = '
                    <a href="'. route('campaign.show', $query->id) .'" class="btn btn-link text-dark"><i class="fas fa-search-plus"></i></a>
                ';

                if (auth()->user()->hasRole('donatur')) {
                    $text .= '
                        <a href="'. url('/campaign/'. $query->id .'/edit') .'" class="btn btn-link text-primary"><i class="fas fa-pencil-alt"></i></a>
                    ';
                } else {
                    $text .= '
                        <button onclick="editForm(`'. route('campaign.show', $query->id) .'`)" class="btn btn-link text-primary"><i class="fas fa-pencil-alt"></i></button>
                    ';
                }

                $text .= '
                    <button class="btn btn-link text-danger" onclick="deleteData(`'. route('campaign.destroy', $query->id) .'`)"><i class="fas fa-trash-alt"></i></button>
                ';

                return $text;
            })
            ->rawColumns(['short_description', 'path_image', 'status', 'action'])
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|min:8',
            'categories' => 'required|array',
            'short_description' => 'required',
            'body' => 'required|min:8',
            'publish_date' => 'required|date_format:Y-m-d H:i',
            'status' => 'required|in:publish,archived',
            'goal' => 'required|regex:/^[0-9.]+$/|min:7',
            'end_date' => 'required|date_format:Y-m-d H:i',
            'note' => 'nullable',
            'receiver' => 'required',
            'path_image' => 'required|mimes:png,jpg,jpeg|max:2048'
        ];

        if (auth()->user()->hasRole('donatur')) {
            $rules['status'] = 'nullable';
        }

        $validator = Validator::make($request->all(), $rules, [
            'goal.min' => 'Nominal minimal 100.000'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->except('path_image', 'categories');
        $data['slug'] = Str::slug($request->title);
        $data['goal'] = str_replace('.', '', $request->goal);
        $data['path_image'] = upload('campaign', $request->file('path_image'), 'campaign');
        $data['user_id'] = auth()->id();

        $campaign = Campaign::create($data);
        $campaign->category_campaign()->attach($request->categories);

        return response()->json(['data' => $campaign, 'message' => 'Projek berhasil ditambahkan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Campaign $campaign)
    {
        $campaign = $campaign->load('donations');

        if (auth()->user()->hasRole('donatur') && $campaign->user_id != auth()->id()) {
            abort(404);
        }

        if (! $request->ajax()) {
            return view('campaign.show', compact('campaign'));
        }

        $campaign->publish_date = date('Y-m-d H:i', strtotime($campaign->publish_date));
        $campaign->end_date = date('Y-m-d H:i', strtotime($campaign->end_date));
        $campaign->goal = format_uang($campaign->goal);
        $campaign->categories = $campaign->category_campaign;
        $campaign->path_image = Storage::disk('public')->url($campaign->path_image);

        return response()->json(['data' => $campaign]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Campaign $campaign)
    {
        $rules = [
            'title' => 'required|min:8',
            'categories' => 'required|array',
            'short_description' => 'required',
            'body' => 'required|min:8',
            'publish_date' => 'required|date_format:Y-m-d H:i',
            'status' => 'required|in:publish,archived',
            'goal' => 'required|regex:/^[0-9.]+$/|min:7',
            'end_date' => 'required|date_format:Y-m-d H:i',
            'note' => 'nullable',
            'receiver' => 'required',
            'path_image' => 'nullable|mimes:png,jpg,jpeg|max:2048'
        ];

        if (auth()->user()->hasRole('donatur')) {
            $rules['status'] = 'nullable';
        }

        $validator = Validator::make($request->all(), $rules, [
            'goal.min' => 'Nominal minimal 100.000'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->except('path_image', 'categories');
        $data['slug'] = Str::slug($request->title);
        $data['goal'] = str_replace('.', '', $request->goal);

        if ($request->hasFile('path_image')) {
            if (Storage::disk('public')->exists($campaign->path_image)) {
                Storage::disk('public')->delete($campaign->path_image);
            }

            $data['path_image'] = upload('campaign', $request->file('path_image'), 'campaign');
        }

        $campaign->update($data);
        $campaign->category_campaign()->sync($request->categories);

        return response()->json(['data' => $campaign, 'message' => 'Projek berhasil diperbarui']);
    }

    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:publish,archived,pending',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $campaign = Campaign::findOrFail($id);
        $campaign->update($request->only('status'));

        $statusText = "";
        if ($request->status == 'publish') {
            $statusText = 'dikonfirmasi';
        } elseif ($request->status == 'archived') {
            $statusText = 'diarsipkan';
        }

        return response()->json(['data' => $campaign, 'message' => 'Projek berhasil '. $statusText]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign $campaign)
    {
        if (Storage::disk('public')->exists($campaign->path_image)) {
            Storage::disk('public')->delete($campaign->path_image);
        }

        $campaign->delete();

        return response()->json(['data' => null, 'message' => 'Projek berhasil dihapus']);
    }

    public function cashout($id)
    {
        $campaign = Campaign::findOrFail($id)->load('donations', 'cashouts');

        if ($campaign->user_id != auth()->id()) {
            abort(404);
        }

        return view('campaign.cashout', compact('campaign'));
    }

    public function cashoutStore(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'campaign_id' => 'required|exists:campaigns,id',
            'user_id' => 'required|exists:users,id',
            'bank_id' => 'required|exists:bank,id',
            'total' => 'required|integer',
            'cashout_amount' => 'required|regex:/^[0-9.]+$/',
            'cashout_fee' => 'required|regex:/^[0-9.]+$/',
            'amount_received' => 'required|regex:/^[0-9.]+$/',
            'remaining_amount' => 'required|regex:/^[0-9.]+$/'
        ], [
            'bank_id.required' => 'Silahkan lengkapi rekening tujuan terlebih dahulu.'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $attributes = $request->only('campaign_id', 'user_id', 'bank_id', 'total');
        $attributes['status'] = 'pending';
        foreach ($request->only('cashout_amount', 'cashout_fee', 'amount_received', 'remaining_amount') as $key => $value) {
            $attributes[$key] = str_replace('.', '', $value);
        }

        $cashout = Cashout::create($attributes);
        return response()->json([
            'data' => $cashout,
            'message' => 'Cashout berhasil dikirimkan, silahkan konfirmasi Admin untuk segera memproses request Anda.'
        ]);
    }
}
