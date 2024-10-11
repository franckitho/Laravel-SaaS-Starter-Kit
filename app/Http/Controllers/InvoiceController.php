<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $invoiceId)
    {
        return $request->user()->downloadInvoice($invoiceId, [
            'vendor'    => config('cashier.invoices.information.vendor'),
            'product'   => config('cashier.invoices.information.product'),
            'street'    => config('cashier.invoices.information.street'),
            'location'  => config('cashier.invoices.information.location'),
            'phone'     => config('cashier.invoices.information.phone'),
            'email'     => config('cashier.invoices.information.email'),
            'url'       => config('cashier.invoices.information.url'),
            'vendorVat' => config('cashier.invoices.information.vendorVat'),
        ]);
    }
}
