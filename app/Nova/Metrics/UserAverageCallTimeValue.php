<?php

namespace App\Nova\Metrics;

use App\NexusCall;
use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Value;

class UserAverageCallTimeValue extends Value
{
    public $name = 'Average Call Duration';

    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        return $this->average(
            $request,
            NexusCall::where('user_id', $request->resourceId)->where('duration', '>', 0),
            'duration'
        )->format('00:00:00');
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

    protected function getCacheKey(\Laravel\Nova\Http\Requests\NovaRequest $request)
    {
        return parent::getCacheKey($request) . $request->resourceId;
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        return now()->addMinutes(10);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'user-average-call-time-value';
    }
}
