<?php

namespace App\Models;

use CodeIgniter\Model;
use DateTime;

class UmsatzModel extends Model
{
    protected $table = 'umsaetze';
    protected $primaryKey = 'id';
    protected $allowedFields = ['monat', 'jahr', 'umsatz'];
    protected $useTimestamps = false;

    /**
     * Returns the revenue data of the last 12 months (chronological order).
     */
    public function getLast12Months(): array
    {
        $now = new DateTime();
        $start = (clone $now)->modify('-11 months');

        $builder = $this->builder();
        $builder->select('monat, jahr, umsatz');
        $builder->where('jahr >', $start->format('Y') - 1); // safety margin
        $builder->orderBy('jahr', 'ASC')->orderBy('monat', 'ASC');

        $result = $builder->get()->getResultArray();

        // Filter & sort (in case DB returns too much)
        $filtered = array_filter($result, function ($row) use ($start, $now) {
            $date = DateTime::createFromFormat('Y-m', sprintf('%04d-%02d', $row['jahr'], $row['monat']));
            return $date >= $start && $date <= $now;
        });

        usort($filtered, function ($a, $b) {
            return sprintf('%04d%02d', $a['jahr'], $a['monat']) <=> sprintf('%04d%02d', $b['jahr'], $b['monat']);
        });

        return array_values($filtered);
    }

    /**
     * Compares the revenue of the current month with the same month of the previous year.
     * Returns an array: 'monat', 'jahr', 'current_revenue', 'previous_year_revenue'
     */
    public function getCurrentMonthComparison(): array
    {
        $now = new DateTime();
        $month = (int)$now->format('n');
        $year = (int)$now->format('Y');

        $current = $this->where(['monat' => $month, 'jahr' => $year])
            ->first();

        $previous = $this->where(['monat' => $month, 'jahr' => $year - 1])
            ->first();

        return [
            'month' => $month,
            'year' => $year,
            'current_revenue' => $current['umsatz'] ?? 0,
            'previous_year_revenue' => $previous['umsatz'] ?? 0,
        ];
    }
}
