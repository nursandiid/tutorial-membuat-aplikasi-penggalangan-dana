<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Category;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('/campaign/create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::orderBy('name')->get()->pluck('name', 'id');

        return view('front.campaign.index', compact('category'));
    }

    /**
     * Show edit form
     * 
     * @param int $id.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::orderBy('name')->get()->pluck('name', 'id');
        $campaign = Campaign::findOrFail($id);

        return view('front.campaign.index', compact('category', 'campaign'));
    }
}
