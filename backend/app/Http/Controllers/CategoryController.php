<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Kiểm tra tên trùng
        if (Category::where('name', $validatedData['name'])->exists()) {
            return response()->json([
                'message' => 'Tên danh mục đã tồn tại.'
            ], 409);
        }

        $category = Category::create($validatedData);

        return response()->json($category, 201);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Danh mục không tồn tại'], 404);
        }

        return response()->json($category, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Danh mục không tồn tại'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Kiểm tra xem tên danh mục đã tồn tại chưa
        $existingCategory = Category::where('name', $validatedData['name'])->where('id', '!=', $id)->first();

        if ($existingCategory) {
            return response()->json(['message' => 'Tên danh mục đã tồn tại'], 409);
        }

        // Cập nhật danh mục
        $category->update($validatedData);

        return response()->json($category, 200);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::withCount('products')->find($id);

        if (!$category) {
            return response()->json(['message' => 'Danh mục không tồn tại'], 404);
        }

        if ($category->products_count > 0) {
            return response()->json([
                'message' => 'Không thể xóa danh mục vì còn sản phẩm bên trong.'
            ], 400);
        }

        $category->delete();

        return response()->json(['message' => 'Xóa danh mục thành công'], 200);
    }
}
