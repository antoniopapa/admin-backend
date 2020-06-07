<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateRequest;
use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * @OA\Get(path="/products",
     *   security={{"bearerAuth":{}}},
     *   tags={"Products"},
     *   @OA\Response(response="200",
     *     description="Product Collection",
     *   )
     * )
     */
    public function index()
    {
        \Gate::authorize('view', 'products');

        $products = Product::paginate();

        return ProductResource::collection($products);
    }

    /**
     * @OA\Get(path="/products/{id}",
     *   security={{"bearerAuth":{}}},
     *   tags={"Products"},
     *   @OA\Response(response="200",
     *     description="User",
     *   ),
     *   @OA\Parameter(
     *     name="id",
     *     description="Product ID",
     *     in="path",
     *     required=true,
     *     @OA\Schema(
     *        type="integer"
     *     )
     *   )
     * )
     */
    public function show($id)
    {
        \Gate::authorize('view', 'products');

        return new ProductResource(Product::find($id));
    }

    /**
     * @OA\Post(
     *   path="/products",
     *   security={{"bearerAuth":{}}},
     *   tags={"Products"},
     *   @OA\Response(response="201",
     *     description="Product Create",
     *   )
     * )
     */
    public function store(ProductCreateRequest $request)
    {
        \Gate::authorize('edit', 'products');

        $product = Product::create($request->only('title', 'description', 'image', 'price'));

        return response($product, Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *   path="/products/{id}",
     *   security={{"bearerAuth":{}}},
     *   tags={"Products"},
     *   @OA\Response(response="202",
     *     description="Product Update",
     *   ),
     *   @OA\Parameter(
     *     name="id",
     *     description="Product ID",
     *     in="path",
     *     required=true,
     *     @OA\Schema(
     *        type="integer"
     *     )
     *   )
     * )
     */
    public function update(Request $request, $id)
    {
        \Gate::authorize('edit', 'products');

        $product = Product::find($id);

        $product->update($request->only('title', 'description', 'image', 'price'));

        return response($product, Response::HTTP_ACCEPTED);
    }

    /**
     * @OA\Delete(path="/products/{id}",
     *   security={{"bearerAuth":{}}},
     *   tags={"Products"},
     *   @OA\Response(response="204",
     *     description="Product Delete",
     *   ),
     *   @OA\Parameter(
     *     name="id",
     *     description="Product ID",
     *     in="path",
     *     required=true,
     *     @OA\Schema(
     *        type="integer"
     *     )
     *   )
     * )
     */
    public function destroy($id)
    {
        \Gate::authorize('edit', 'products');

        Product::destroy($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
