<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportOrderInvoicePdfController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Order $order)
    {
        if (false === $order->isOrderIsOwnByAuthenticatedUser(auth()->user())) return abort(404);

        $pdf = Pdf::loadView('export.order-invoice', ['order' => $order->load('details')->toArray()]);
        
        return $pdf->stream('invoice.pdf'); 
    }
}
