<?php

namespace App\Http\Middleware;

use App\Models\Basket;
use App\Models\BasketStatus;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $loggedData = [];

        if($request->user() != null){
            $basket = Basket::query()
                ->where('user_id', $request->user()->id)
                ->where('basket_status_id', BasketStatus::DRAFT)
                ->first();

            $basketItemQuantity = 0;

            if($basket) {
                $basketItemQuantity = $basket->basketItems
                    ->pluck('quantity')
                    ->sum();
            }

            $loggedData = [
                'categories' => Category::all(),
                'sub_categories' => $request->has('category_id') ? Subcategory::query()
                    ->where('category_id', $request->get('category_id'))
                    ->get() : [],
                'basketItemQuantity' => $basketItemQuantity
            ];
        }

        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'auth' => [
                'user' => $request->user(),
            ],
            'ziggy' => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'sidebarOpen' => ! $request->hasCookie('sidebar_state') || $request->cookie('sidebar_state') === 'true',
            ...$loggedData
        ];
    }
}
