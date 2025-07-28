<?php

namespace App\Http\Controllers;

use App\Events\OrderCreated;
use App\Models\Address;
use App\Models\AddressUser;
use App\Models\Basket;
use App\Models\BasketStatus;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $basket = Basket::query()
            ->where('user_id', $request->user()->id)
            ->where('basket_status_id', BasketStatus::DRAFT)
            ->first();

        if (!$basket || $basket->basketItems->count() === 0) {
            return redirect()->route('products.index');
        }

        $userAddress = Address::query()
            ->whereHas('users', function ($query) use ($request) {
                $query->where('user_id', $request->user()->id);
            })
            ->first();

        DB::beginTransaction();

        try {
            $basket->basket_status_id = 3;
            $basket->save();

            $order = new Order();
            $order->orderStatus()->associate(OrderStatus::find(3));
            $order->basket()->associate($basket);
            $order->shipping_address_id = $userAddress->id;
            $order->created_at = now();
            $order->updated_at = now();

            $order->save();

            OrderCreated::dispatch($order);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            dd($e->getMessage());
        }

        return redirect()->route('products.index');
    }
}
