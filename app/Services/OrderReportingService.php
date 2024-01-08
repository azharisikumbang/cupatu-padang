<?php

namespace App\Services;

use App\Models\Order;

class OrderReportingService
{
    public function generateDoneAncCancelOrderMonthly(int $year): array
    {
        if ($year > date('Y')) return [];

        return (new Order)->countOrderDoneAndCancelListMonthly($year)->toArray();
    }

    private function isValidMonthNumber($month) : bool
    {
        return ($month > 0 || $month <= 12);
    }
}