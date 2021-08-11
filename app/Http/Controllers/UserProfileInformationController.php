<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;

class UserProfileInformationController extends Controller
{
    public function show(Request $request)
    {
        return view('profile.show', [
            'request' => $request,
            'user' => $request->user(),
            'bank' => Bank::all()->pluck('name', 'id')
        ]);
    }

    public function bankDestroy(Request $request, $id)
    {
        $request->user()->bank_user()->detach($id);

        return back()->with([
            'message' => 'Bank terdaftar berhasil dihapus',
            'success' => true
        ]);
    }
}
