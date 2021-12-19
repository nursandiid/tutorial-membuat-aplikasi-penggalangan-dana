<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubcriberController extends Controller
{
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'email' => 'required|email|unique:subscribers,email'
        ]);

        if ($validated->fails()) {
            return back()
                ->withInput()
                ->with([
                    'message' => $validated->errors()->first(),
                    'error_msg' => true,
                ]);
        }

        Subscriber::create($request->only('email'));

        return back()
            ->with([
                'message' => 'Subscriber baru berhasil ditambahkan',
                'success' => true,
            ]);
    }
}
