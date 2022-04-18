<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('contact.index');
    }

    public function data(Request $request)
    {
        $query = Contact::when($request->has('date') && $request->date != "", function ($query) use ($request) {
                $query->whereDate('created_at', $request->date);
            })
            ->orderBy('name');

        return datatables($query)
            ->addIndexColumn()
            ->editColumn('name', function ($query) {
                return $query->name .'<br><a href="mailto:'. $query->email .'" target="_blank">'. $query->email .'</a>';
            })
            ->editColumn('created_at', function ($query) {
                return tanggal_indonesia($query->created_at);
            })
            ->addColumn('action', function ($query) {
                return '
                    <button class="btn btn-link text-danger" onclick="deleteData(`'. route('contact.destroy', $query->id) .'`)"><i class="fas fa-trash-alt"></i></button>
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
        $contact = Contact::findOrFail($id);

        $contact->delete();

        return response()->json(['data' => null, 'message' => 'Kontak masuk berhasil dihapus']);
    }
}
