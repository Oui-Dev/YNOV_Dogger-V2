<?php

namespace App\Traits;
use DateInterval;
use DatePeriod;

trait StatsTrait {
    /**
     *  Generates a date range from now to $nbDays ago
     *
     *  @param int $nbDays
     *
     *  @return DatePeriod
     */
    public function generateDateRange(int $nbDays): DatePeriod
    {
        $endDate = now()->addDay();
        $startDate = now()->subDays($nbDays - 1);
        $interval = new DateInterval('P1D');
        return new DatePeriod($startDate, $interval, $endDate);
    }

    /**
     *  Adds missing days to an array of dates
     *
     *  @param array $array
     *  @param string $dataKey
     *  @param DatePeriod $dateRange
     *
     *  @return array
     */
    public function addMissingDays(array $array, string $dataKey, DatePeriod $dateRange): array
    {
        foreach ($dateRange as $date) {
            $dateString = $date->format("d-m-Y");
            if (!isset($array[$dataKey][$dateString])) {
                $array[$dataKey][$dateString] = 0;
            }
        }
        ksort($array[$dataKey]);

        return $array;
    }
}
