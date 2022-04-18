<?php

namespace App\Http\Controllers;

use App\Models\Cashout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CashoutController extends Controller
{
    public function index()
    {
        return view('cashout.index');
    }

    public function data(Request $request)
    {
        $query = Cashout::with('campaign','user')
            ->when(auth()->user()->hasRole('donatur'), function ($query) {
                $query->donatur();
            })
            ->when($request->has('status') && $request->status != "", function ($query) use ($request) {
                $query->where('status', $request->status);
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
            ->editColumn('cashout_amount', function ($query) {
                return format_uang($query->cashout_amount);
            })
            ->editColumn('status', function ($query) {
                return '<span class="badge badge-'. $query->statusColor() .'">'. $query->statusText() .'</span>';
            })
            ->editColumn('created_at', function ($query) {
                return tanggal_indonesia($query->created_at);
            })
            ->addColumn('action', function ($query) {
                return '
                    <a href="'. route('cashout.show', $query->id) .'" class="btn btn-link text-dark"><i class="fas fa-search-plus"></i></a>
                    <button class="btn btn-link text-danger" onclick="deleteData(`'. route('cashout.destroy', $query->id) .'`)"><i class="fas fa-trash-alt"></i></button>
                ';
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function show(Request $request, $id)
    {
        $cashout = Cashout::with('campaign', 'user')->findOrFail($id);
        if ($cashout->user_id != auth()->id() && auth()->user()->hasRole('donatur')) {
            abort(404);
        }

        $campaign = $cashout->campaign;
        $bank = $cashout->user->bank_user->find($cashout->bank_id);

        return view('cashout.show', compact('cashout', 'campaign', 'bank'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => ['required', 'string'],
            'reason_rejected' => 'required_if:status,rejected|nullable'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $cashout = Cashout::findOrFail($id);
        $cashout->update([
            'status' => $request->status,
            'reason_rejected' => $request->reason_rejected
        ]);

        $statusText = "";
        if ($request->status == 'success') {
            $statusText = 'dikonfirmasi';
        } elseif ($request->status == 'canceled') {
            $statusText = 'dibatalkan';
        } elseif ($request->status == 'rejected') {
            $statusText = 'ditolak';
        }

        return response()->json(['data' => $cashout, 'message' => 'Pencairan berhasil '. $statusText]);
    }

    public function destroy($id)
    {
        $cashout = Cashout::findOrFail($id);
        $cashout->delete();

        return response()->json(['data' => null, 'message' => 'Pencairan berhasil dihapus']);
    }
}
