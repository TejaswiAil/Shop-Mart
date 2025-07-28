<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $categoryId = $request->input('category_id'); //or null
        $subcategories = $request->input('subcategories');; //or [1, 2];
//dd($subcategories);
        $trendingProducts = null;
        $discountedProducts = null;
        $products = null;

        if (!$categoryId) {
            $trendingProducts = Product::query()
                ->with(['images', 'currentPrice'])
                ->whereHas('subcategories', function ($query) {
                    $query->whereIn('subcategory_id', [1, 2, 3, 4]);
                })
                ->get();

            $discountedProducts = Product::query()
                ->with(['images', 'currentPrice', 'currentOffer'])
                ->whereHas('offers', function ($query) {
                    $query->where('discount', '>=', '50')
                        ->active();
                })
                ->get();
        } else {
            $products = Product::query()
                ->with(['images', 'currentPrice'])
                ->when($request->filled('category_id') || $request->filled('subcategories'), function (Builder $query) use ($request) {
                    $query->whereHas('subcategories', function ($subQuery) use ($request) {
                        if ($request->filled('category_id')) {
                            $subQuery->where('category_id', $request->input('category_id'));
                        }

                        if ($request->filled('subcategories')) {
                            $subQuery->whereIn('id', (array)$request->input('subcategories'));
                        }
                    });
                })->paginate(10);
        }

        return Inertia::render('products/Index', [
            "products" => $products,
            "trendingProducts" => $trendingProducts,
            "discountedProducts" => $discountedProducts
        ]);
    }

    public function show(Product $product)
    {
        $product->load(['images', 'currentPrice']);

        $categoryIds = $product->subcategories()->pluck('category_id')->unique();

        $similarProducts = Product::query()
            ->with([
                'images',
                'currentPrice'
            ])
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
