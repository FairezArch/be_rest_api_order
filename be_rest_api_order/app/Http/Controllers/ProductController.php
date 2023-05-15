<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try {
            //code...
            $lists = Product::paginate(10);
            Log::info('The Product: ', ['product' => $lists]);
            return response()->json([
                'success' => true,
                'message' => __('validation.success_json'),
                'data'    => $lists
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            Log::error('Product error: ', ['product' => $th->getMessage()]);
            return response()->json([
                'success' => false,
                'message'   => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        //
        try {
            //code...
            $product = new Product();
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->quantity = $request->quantity;
            $product->save();
            Log::info('Create Product: ', ['product' => $product]);
            return response()->json([
                'success' => true,
                'message' => __('validation.success_json'),
            ], 201);
        } catch (\Throwable $th) {
            //throw $th;
            Log::error('Product error: ', ['product' => $th->getMessage()]);
            return response()->json([
                'success' => false,
                'message'   => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
        try {
            //code...
            Log::info('Product: ', ['product' => $product]);
            return response()->json([
                'success' => true,
                'message' => __('validation.success_json'),
                'data'    => $product
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            Log::error('Product error: ', ['product' => $th->getMessage()]);
            return response()->json([
                'success' => false,
                'message'   => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        //
        try {
            //code...
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->quantity = $request->quantity;
            $product->save();
            Log::info('Update Product: ', ['product' => $product]);
            return response()->json([
                'success' => true,
                'message' => __('validation.success_json'),
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            Log::error('Product error: ', ['product' => $th->getMessage()]);
            return response()->json([
                'success' => false,
                'message'   => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
        try {
            //code...
            Log::info('Delete Product: ', ['product' => $product]);
            $product->delete();
            return response()->json([], 204);
        } catch (\Throwable $th) {
            //throw $th;
            Log::error('Product error: ', ['product' => $th->getMessage()]);
            return response()->json([
                'success' => false,
                'message'   => $th->getMessage()
            ], 500);
        }
    }
}
