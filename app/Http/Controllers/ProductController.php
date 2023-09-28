<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_code' => ['required'],
            'product_name' => ['required'],
            'product_price' => ['required', 'numeric'],
            'product_image' => ['required'],
            'product_active' => ['integer', 'max:2'],
        ]);

        $user = Auth::user();

        array_push($validated, ['product_created_by' => $user->id]);

        $newProduct = Product::create($validated);

        return $newProduct; 
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'product_name' => ['required'],
            'product_price' => ['required', 'numeric'],
            'product_image' => ['required'],
            'product_active' => ['integer', 'max:2'],
        ]);

        $product = Product::find($id);

        $product->product_name  = $validated["product_name "];
        $product->product_price = $validated["product_price"];
        $product->product_image = $validated["product_image"];
        $product->product_active = $validated["product_active"];
        $product->product_modified_by = Auth::id();

        $product->save();

        return response()->json([
            "data" => $product,
            "message" => "Product modified",
            "response" => "successful"
        ]);
    }

    public function index()
    {
        return response()->json([
            "response" => "successful",
            "data" => Product::all(),
        ]);
    }

    public function show($id)
    {
        $product = Product::find($id);

        if (!isset($product))
        {
            return $this->responseNotFound();
        }

        return response()->json([
            "response" => "successful",
            "data" => $product,
        ]);
    }

    public function drop($id)
    {
        $product = Product::find($id);

        if (!isset($product))
        {
            return $this->responseNotFound();
        }

        $product->delete($id);

        return response()->json([
            "response" => "successful",
            "message" => "product was deleted",
        ]);
    }

    private function responseNotFound()
    {
        return response()->json([
            "response" => "unsuccessful",
            "message" => "User Not Found",    
        ]);
    }
}
