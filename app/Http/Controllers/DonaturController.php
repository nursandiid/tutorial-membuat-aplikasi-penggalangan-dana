<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DonaturController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('donatur.index');
    }

    public function data(Request $request)
    {
        $query = User::with('role')
            ->withCount('campaigns')
            ->withSum([
                'donations' => function ($query) {
                    $query->where('status', 'confirmed');
                }
            ], 'nominal')
            ->donatur()
            ->when($request->has('email') && $request->email != "", function ($query) use ($request) {
                $query->where('email', $request->email);
            })
            ->orderBy('name');

        return datatables($query)
            ->addIndexColumn()
            ->editColumn('name', function ($query) {
                return $query->name . '<br><a target="_blank" href="mailto:'. $query->email .'">'. $query->email .'</a>';
            })
            ->editColumn('path_image', function ($query) {
                if (Storage::disk('public')->exists($query->path_image)) {
                    return '<img src="'. Storage::disk('public')->url($query->path_image) .'" class="img-thumbnail">';
                } else {
                    return '<img src="'. asset('AdminLTE/dist/img/user1-128x128.jpg') .'" class="img-thumbnail">';
                }
            })
            ->editColumn('campaigns_count', function ($query) {
                return format_uang($query->campaigns_count);
            })
            ->editColumn('donations_sum_nominal', function ($query) {
                return format_uang($query->donations_sum_nominal);
            })
            ->editColumn('created_at', function ($query) {
                return tanggal_indonesia($query->created_at);
            })
            ->addColumn('action', function ($query) {
                return '
                    <button onclick="editForm(`'. route('donatur.show', $query->id) .'`)" class="btn btn-link text-primary"><i class="fas fa-pencil-alt"></i></button>
                    <button class="btn btn-link text-danger" onclick="deleteData(`'. route('donatur.destroy', $query->id) .'`)"><i class="fas fa-trash-alt"></i></button>
                ';
            })
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
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $donatur = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => 2
        ]);

        return response()->json(['data' => $donatur, 'message' => 'Donatur berhasil ditambahkan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $donatur = User::findOrFail($id);

        return response()->json(['data' => $donatur]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,id,'. $id],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $donatur = User::findOrFail($id);
        $donatur->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->has('password') ? bcrypt($request->password) : $donatur->password,
        ]);

        return response()->json(['data' => $donatur, 'message' => 'Donatur berhasil diperbarui']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $donatur = User::findOrFail($id);

        if (Storage::disk('public')->exists($donatur->path_image)) {
            Storage::disk('public')->delete($donatur->path_image);
        }

        $donatur->delete();

        return response()->json(['data' => null, 'message' => 'Donatur berhasil dihapus']);
    }
}
