<?php

namespace App\Nova\Metrics;

use App\NexusMessage;
use App\NexusConversation;
use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Value;

class UserMessagesValue extends Value
{
    public $name = 'Total Messages';

    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        $conversationIds = NexusConversation::where('user_id', $request->resourceId)->get()->map->id;

        return $this->count(
            $request,
            NexusMessage::whereIn('conversation_id', $conversationIds->toArray())
        );
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
        return now();
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'user-messages-value';
    }
}
