<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\BasketStatus;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    public function __invoke(Request $request)
    {
        $basket = Basket::query()
            ->where('user_id', $request->user()->id)
            ->where('basket_status_id', BasketStatus::DRAFT)
            ->first();

        if(!$basket || $basket->basketItems->count() === 0) {
            return redirect()->route('products.index');
        }

        $basket->load([
            'basketItems' => [
                'product' => [
                    'images',
                    'currentPrice',
                    'currentOffer',
                ]
            ]
        ]);

        return Inertia::render('checkout/Show', [
            'basketItems' => $basket->basketItems,
        ]);
    }
}
