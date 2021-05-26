<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
     // $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        $product = new Product;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->user_id = auth()->user()->id;

        $category->products()->save($product);
        $product->categories()->attach($category->category_id);
        return response()->json(['message' => 'Product Added', 'product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category, Product $product)
    {
        if (auth()->user()->id !== $product->user_id) {
            return response()->json(['message' => 'Action Forbidden']);
        }
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        $product->name = $request->name;
        $product->description = $request->description;
        $product->save();

        return response()->json(['message' => 'Product Updated', 'product' => $product]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category, Product $product)
    {
        if (auth()->user()->id !== $product->user_id) {
            return response()->json(['message' => 'Action Forbidden']);
        }
        $product->categories()->detach($category->category_id);
        $product->delete();
        return response()->json(null, 204);
    }
}