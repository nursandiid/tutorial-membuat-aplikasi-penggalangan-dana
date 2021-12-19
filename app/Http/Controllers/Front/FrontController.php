<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $campaign = Campaign::orderBy('publish_date', 'desc')
            ->limit(6)
            ->get();

        return view('front.welcome', compact('campaign'));
    }
}
