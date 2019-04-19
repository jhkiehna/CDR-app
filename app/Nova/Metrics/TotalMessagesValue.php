<?php

namespace App\Nova\Metrics;

use App\NexusMessage;
use App\NexusConversation;
use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Value;

class TotalMessagesValue extends Value
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
        if ($request->user()->isRoot()) {
            return $this->count($request, NexusMessage::class);
        }

        $conversationIds = NexusConversation::whereIn('user_id', config('cj-users.ids'))->get()->map->id;

        return $this->count($request, NexusMessage::whereIn('conversation_id', $conversationIds));
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
        return 'total-messages-value';
    }
}
