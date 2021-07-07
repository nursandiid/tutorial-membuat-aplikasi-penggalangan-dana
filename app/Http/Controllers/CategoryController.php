<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    protected $paginate = 10;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $category = Category::orderBy('name')
            ->when($request->has('q') && $request->q != "", function ($query) use ($request) {
                $query->where('name', 'LIKE', '%'. $request->q .'%');
            })
            ->paginate($request->rows ?? $this->paginate)
            ->appends($request->only('rows', 'q'));

        return view('category.index', compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories,name'
        ]);

        $data = $request->only('name');
        $data['slug'] = Str::slug($request->name);

        Category::create($data);

        return redirect()->route('category.index')
            ->with([
                'message' => 'Kategori berhasil ditambahkan',
                'success' => true,
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories,name,'. $category->id
        ]);

        $data = $request->only('name');
        $data['slug'] = Str::slug($request->name);

        $category->update($data);

        return redirect()->route('category.index')
            ->with([
                'message' => 'Kategori berhasil diperbarui',
                'success' => true,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('category.index')
            ->with([
                'message' => 'Kategori berhasil dihapus',
                'success' => true,
            ]);
    }
}
