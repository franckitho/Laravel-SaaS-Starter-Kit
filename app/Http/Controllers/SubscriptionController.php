<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Filament\Product;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProcessPaymentRequest;

class SubscriptionController extends Controller
{
    public function create()
    {
        return Inertia::render('Subscription/Create', [
            'plans' => Product::all(),
            'intent' => auth()->user()->createSetupIntent(),
            'stripe_public_key' => config('cashier.key')
        ]);
    }

    public function store(ProcessPaymentRequest $request)
    {
        $validated = $request->validated();

        $selectedProduct = Product::find($validated['plan_id']);

        auth()->user()->newSubscription(
            'default', $selectedProduct->stripe_product_id
        )->create($validated['payment_method']);

        return Redirect::route('dashboard');
    }

    public function cancel()
    {
        auth()->user()->subscription()->cancel();

        return Redirect::route('dashboard');
    }

    public function resume()
    {
        auth()->user()->subscription()->resume();

        return Redirect::route('dashboard');
    }
}
