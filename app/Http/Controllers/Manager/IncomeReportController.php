<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Services\IncomeReportingService;
use Illuminate\Http\Request;

class IncomeReportController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, IncomeReportingService $incomeReportingService)
    {
        $selectedYear = $request->input('tahun', date('Y'));
        $selectedMonth = $request->input('bulan', date('m'));

        return view("manager.income-report.index", [
            'data' => $incomeReportingService->generateReportByYearAndMonth($selectedYear, $selectedMonth)
        ]);
    }
}
