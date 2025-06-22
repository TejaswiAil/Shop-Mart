<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\BasketStatus;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BasketsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'quantity' => 'required|int|min:1',
            'product_id' => ['required', 'int', Rule::exists(Product::class, "id")],
        ]);
        $userId = Auth::id();
        $basket = Basket::firstOrCreate(
            [
                'user_id' => $userId,
                'basket_status_id' => BasketStatus::DRAFT
            ]
        );

        $product = Product::find($validated['product_id']);
        $basketItem = $basket
            ->basketItems
            ->firstWhere('product_id', $validated['product_id']);

        if ($basketItem != null) {
            $basketItem->quantity = $basketItem->quantity > 0 ? $basketItem->quantity + $validated['quantity'] : $validated['quantity'];
            $basketItem->save();
        } else {
            $currentItemPrice = $product->currentPrice->price;
            $discount = $product->currentOffer->discount;

            if($discount) {
                $currentItemPrice =  $currentItemPrice * ($discount/100);
            }

            $basketItem = new BasketItem();
            $basketItem->basket_id = $basket->id;
            $basketItem->product_id = $validated['product_id'];
            $basketItem->quantity = $validated['quantity'];
            $basketItem->item_price = $currentItemPrice;
            $basketItem->offer_id = $product->currentOffer->id;
            $basketItem->price_id = $product->currentPrice->id;
            $basketItem->save();
        }

        return redirect()->route('products.show', ['product' => $product]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
