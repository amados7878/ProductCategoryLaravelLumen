<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
        /**
     * @OA\Get(
     *      path="/categories",
     *      operationId="getcategoriesList",
     *      tags={"Projects"},
     *      summary="Get list of categories",
     *      description="Returns list of categories",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/categoriesResource")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function __construct()
    {
      //$this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::with('user:id,name')
            ->withCount('products')
            ->latest()
            ->paginate(20);

        //$categories = Category::all();
        return response()->json(['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        $category = new Category;
        $category->name = $request->name;
        $category->description = $request->description;

        auth()->user()->categories()->save($category);
        return response()->json(['message' => 'Category Added', 'category' => $category]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $category->load(['products' => function ($query) {
            $query->latest();
        }, 'user']);
        return response()->json(['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        if (auth()->user()->id !== $category->user_id) {
            return response()->json(['message' => 'Action Forbidden']);
        }
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        return response()->json(['message' => 'Category Updated', 'category' => $category]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if (auth()->user()->id !== $category->user_id) {
            return response()->json(['message' => 'Action Forbidden']);
        }
        $category->delete();
        return response()->json(null, 204);
    }
}