<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DonationController extends Controller
{
    public function index()
    {
        return view('donation.index');
    }

    public function data()
    {
        $query = Donation::with('campaign','user', 'payment')
            ->when(auth()->user()->hasRole('donatur'), function ($query) {
                $query->donatur();
            })
            ->orderBy('created_at');

        return datatables($query)
            ->addIndexColumn()
            ->editColumn('title', function ($query) {
                return $query->campaign->title;
            })
            ->editColumn('name', function ($query) {
                return $query->user->name;
            })
            ->editColumn('nominal', function ($query) {
                return format_uang($query->nominal);
            })
            ->editColumn('status', function ($query) {
                return '<span class="badge badge-'. $query->statusColor() .'">'. $query->statusText() .'</span>';
            })
            ->editColumn('created_at', function ($query) {
                return tanggal_indonesia($query->created_at);
            })
            ->addColumn('action', function ($query) {
                return '
                    <a href="'. route('donation.show', $query->id) .'" class="btn btn-link text-dark"><i class="fas fa-search-plus"></i></a>
                    <button class="btn btn-link text-danger" onclick="deleteData(`'. route('donation.destroy', $query->id) .'`)"><i class="fas fa-trash-alt"></i></button>
                ';
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function show(Request $request, $id)
    {
        $donation = Donation::with('campaign', 'user', 'payment')->findOrFail($id);

        if (! $request->ajax()) {
            return view('donation.show', compact('donation'));
        }

        return response()->json(['data' => $donation]);
    }

    public function update(Request $request, $id) // cancel, confirm
    {
        $validator = Validator::make($request->all(), [
            'status' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $donation = Donation::findOrFail($id);
        $donation->update([
            'status' => $request->status
        ]);

        return response()->json(['data' => $donation, 'message' => 'Donasi berhasil dibatalkan']);
    }

    public function destroy($id)
    {
        $donation = Donation::findOrFail($id);
        $donation->delete();

        return response()->json(['data' => null, 'message' => 'Donasi berhasil dihapus']);
    }
}
