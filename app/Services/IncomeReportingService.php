<?php

namespace App\Services;

use App\Models\Order;


class IncomeReportingService
{
    public function generateReportByYearAndMonth(int $year, int $month): array
    {
        if (false === $this->filterValidYearAndMonth($year, $month)) return [];

        return (new Order)->countIncomeByYearAndMonth($year, $month)->toArray();
    }

    private function filterValidYearAndMonth(int $year, int $month): bool
    {
        if ($year > date('Y')) return false;

        if ($month < 1 OR $month > 12) return false;

        return true;
    }
}