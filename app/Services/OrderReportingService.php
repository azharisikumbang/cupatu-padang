<?php

namespace App\Services;

use App\Models\Order;

class OrderReportingService
{
    public function generateDoneAncCancelOrderMonthly(int $year): array
    {
        if ($this->isHigherThanCurrentYear($year)) return [];

        return (new Order)->countOrderDoneAndCancelListMonthly($year)->toArray();
    }

    private function isHigherThanCurrentYear(int $year) : bool
    {
        return ($year > date('Y'));
    }
}