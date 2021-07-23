<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductCategoryResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryController extends Controller
{
    /* public function __construct()
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
        $productCategory = Category::whereNull('parent_id')->get();
        return (CategoryResource::collection($productCategory))->response();
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
     * @return CategoryResource
     */
    public function store(CreateCategoryRequest $request): CategoryResource
    {
        $category = new Category();
        $category->user_id = 1;
        $category->name = $request->name;
        if ($request->parent_id && $request->parent_id != 0) {
            $category->parent_id = $request->parent_id;
        }
        $category->save();
        return new CategoryResource($category);
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return ProductCategoryResource
     */
    public function destroy($id)
    {
        //$category = Category::findOrFail($id);
        $category = Category::where('id', $id)
            ->withCount('products')
            ->with(['children.children' => function ($query) {
                $query->withCount('products');
            }])
            ->get();

        // Check ... Products count for ... selected category
        if ($category->products_count > 0) {
            return response()->json(["errorMsg" => "Cannot delete category! There are products linked to this category!"], 500);
        }
        // Check ... Products count for ... SubCategories of selected category
        $proCounter = 0;
        $proCounter = $this->loopCategories($category, $proCounter);

        if ($proCounter > 0) {
            return response()->json(["errorMsg" => "Cannot delete category! There are products linked to this category or it's subcategories!"], 500);
        }
        abort_unless($category && $category->forceDelete(), 500, 'Unable to delete category!');
        return new ProductCategoryResource($category);
    }

    public function loopCategories($category, $proCounter)
    {
        if (count($category->children) > 0) {
            foreach ($category->children as $child) {
                if ($child->products->count()) {
                    $proCounter += $child->products->count();
                }
                if (count($child->children) > 0) {
                    $proCounter += $this->loopCategories($child, $proCounter);
                }
            }
        }
        return $proCounter;
    }
}
