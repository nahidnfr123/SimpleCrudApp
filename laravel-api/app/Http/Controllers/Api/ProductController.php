<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index']]);
    }*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $products = Product::all();
        return ProductResource::collection($products)->response();
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
     * @param \Illuminate\Http\Request $request
     * @return ProductResource
     */
    public function store(CreateProductRequest $request)
    {
        $product = new Product();
        if ($request->file()) {
            $file_name = time() . '_' . $request->file->getClientOriginalName();
            $file_path = $request->file('file')->storeAs('uploads', $file_name, 'public');
            $product->image = '/storage/' . $file_path;
        }
        $product->name = $request->name;
        $product->status = $request->status;
        $product->user_id = auth()->id();
        $product->total_stock = $request->total_stock;
        $product->price = $request->price;
        $product->description = $request->description;

        abort_unless($product->save(), 500, 'Failed to save products!');
        if ($request->category) {
            foreach ($request->category as $categoryId) {
                $product->productCategory()->attach($categoryId);
            }
        }
        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return ProductResource
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        if (!empty($product)) {
            if ($request->file()) {
                $file_name = time() . '_' . $request->file->getClientOriginalName();
                $file_path = $request->file('file')->storeAs('uploads', $file_name, 'public');
                $product->image = '/storage/' . $file_path;
            }
            $product->name = $request->name;
            $product->status = $request->status;
            $product->user_id = auth()->id();
            $product->total_stock = $request->total_stock;
            $product->price = $request->price;
            $product->description = $request->description;

            abort_unless($product->save(), 500, 'Failed to save products!');

            if ($request->category) {
                $product->productCategory()->detach();
                foreach ($request->category as $categoryId) {
                    $product->productCategory()->attach($categoryId);
                }
            }
            return new ProductResource($product);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return ProductResource
     */
    public function destroy($id): ProductResource
    {
        $product = Product::findOrFail($id);
        abort_unless($product && $product->forceDelete(), 500, 'Unable to delete product!');
        return new ProductResource($product);
    }
}
