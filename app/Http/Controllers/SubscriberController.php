<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('subscriber.index');
    }

    public function data()
    {
        $query = Subscriber::orderBy('created_at');

        return datatables($query)
            ->addIndexColumn()
            ->editColumn('email', function ($query) {
                return '<a href="mailto:'. $query->email .'" target="_blank">'. $query->email .'</a>';
            })
            ->editColumn('created_at', function ($query) {
                return tanggal_indonesia($query->created_at);
            })
            ->addColumn('action', function ($query) {
                return '
                    <button class="btn btn-link text-danger" onclick="deleteData(`'. route('subscriber.destroy', $query->id) .'`)"><i class="fas fa-trash-alt"></i></button>
                ';
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subscriber = Subscriber::findOrFail($id);

        $subscriber->delete();

        return response()->json(['data' => null, 'message' => 'Subscriber berhasil dihapus']);
    }
}
