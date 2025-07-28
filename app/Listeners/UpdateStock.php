<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\BasketItem;
use App\Models\Stock;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateStock implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {
      $order = $event->order;
      $basketItems = $order->basket->basketItems;

      foreach ($basketItems as $item) {
          $productId = $item->product_id;
          $orderedQty = $item->quantity;
          $stock = Stock::where('product_id', $productId)->first();

          if($stock) {
              $stock->quantity = max(0, $stock->quantity - $orderedQty);
              $stock->save();
          }
      }

    }
}
