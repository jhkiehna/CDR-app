<?php

namespace App\Nova\Metrics;

use App\NexusCall;
use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Value;
use App\Nova\CallDurationFormatter;

class TotalAverageCallTimeValue extends Value
{
    public $name = 'Average Call Duration in Seconds';

    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        return $this->average($request, NexusCall::class, 'duration');

        // return (new CallDurationFormatter($durationSeconds))->toString();
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            1 => 'Today',
            7 => 'Past Week',
            30 => 'Past Month',
            365 => 'Past Year',
            'MTD' => 'Month To Date',
            'QTD' => 'Quarter To Date',
            'YTD' => 'Year To Date',
        ];
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        return now()->addMinutes(15);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'total-average-call-time-value';
    }
}
