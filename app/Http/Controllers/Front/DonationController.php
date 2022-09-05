<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\PaymentConfirmation;
use App\Models\Bank;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class DonationController extends Controller
{
    public function index(Request $request)
    {
        $category = Category::orderBy('name')
            ->get()
            ->pluck('name', 'id');
        $campaign = Campaign::when(
            $request->has('categories') && count($request->categories) > 0, 
            function ($query) use($request) {
                $query->whereHas('category_campaign', function ($query) use($request) {
                    $query->whereIn('category_id', $request->categories);
                });
            })
            ->where('status', 'publish')
            ->orderBy('publish_date', 'desc')
            ->paginate(9)
            ->withQueryString();

        return view('front.donation.index', compact('category', 'campaign'));
    }

    public function show($id)
    {
        $campaign = Campaign::findOrFail($id);

        return view('front.donation.show', compact('campaign'));
    }

    public function create($id)
    {
        $campaign = Campaign::findOrFail($id);
        $user = User::whereHas('role', function ($query) {
                $query->where('name', 'donatur');
            })
            ->get();

        return view('front.donation.create', compact('campaign', 'user'));
    }

    public function store(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'nominal' => 'required|regex:/^[0-9.]+$/|min:4',
            'user_id' => 'required|exists:users,id',
            'anonim' => 'nullable|in:1,0',
            'support' => 'nullable',
        ], [
            'nominal.min' => 'Nominal minimal 1.000'
        ]);

        if ($validated->fails()) {
            return back()
                ->withInput()
                ->withErrors($validated->errors());
        }

        $campaign = Campaign::findOrFail($id);
        $donation = Donation::create([
            'campaign_id' => $campaign->id,
            'nominal' => str_replace('.', '', $request->nominal),
            'user_id' => $request->user_id,
            'anonim' => $request->anonim ?? 0,
            'support' => $request->support,
            'order_number' => 'PX'. mt_rand(000000, 999999),
            'status' => 'not confirmed'
        ]);

        $bank = Bank::all();

        Mail::to($donation->user)->send(new PaymentConfirmation($campaign, $donation, $bank));

        return redirect('/donation/'. $campaign->id .'/payment/'. $donation->order_number)
            ->with([
                'message' => 'Donasi baru berhasil disimpan',
                'success' => true,
            ]);
    }
}
