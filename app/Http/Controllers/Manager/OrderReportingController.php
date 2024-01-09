<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderReportingService;
use Illuminate\Http\Request;

class OrderReportingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, OrderReportingService $orderReportingService)
    {
        $year = $request->has('tahun') ? $request->get('tahun') : date('Y');

        return view("manager.order-reporting.index", [
            'data' => $orderReportingService->generateDoneAncCancelOrderMonthly($year)
        ]);
    }
}
