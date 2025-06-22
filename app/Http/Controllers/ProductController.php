<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categoryId = null; //or null
        $subcategories = []; //or [1, 2];

        $trendingProducts = null;
        $discountedProducts = null;
        $products = null;

        if (!$categoryId) {
            $trendingProducts = Product::query()
                ->with(['images', 'prices'])
                ->whereHas('subcategories', function ($query) {
                    $query->whereIn('subcategory_id', [1, 2, 3, 4]);
                })
                ->get();

            $discountedProducts = Product::query()
                ->with(['images', 'prices'])
                ->whereHas('offers', function ($query) {
                    $query->where('discount', '>=', '50');
                })
                ->get();
        } else {
            $products = Product::query()
                ->with(['images', 'prices'])
                ->when($request->has("category_id"), function (Builder $query) use ($request) {
                    $query->whereHas('subcategories', function ($query) use ($request) {
                        $query->where("category_id", $request->has("category_id"));
                    });
                })
                ->paginate(10);
        }

        return Inertia::render('products/Index', [
            "products" => $products,
            "trendingProducts" => $trendingProducts,
            "discountedProducts" => $discountedProducts
        ]);
    }

    public function show(Product $product)
    {
        $product->load(['images', 'prices']);

        $categoryIds = $product->subcategories()->pluck('category_id')->unique();

        $similarProducts = Product::query()
            ->with(['images', 'prices'])
            ->whereHas('subcategories', function ($query) use ($categoryIds) {
                $query->whereIn('category_id', $categoryIds);
            })
            ->limit(4)
            ->inRandomOrder()
            ->get();

        return Inertia::render('products/Show', [
            "product" => $product,
            "similarProducts" => $similarProducts,
        ]);
    }
}
