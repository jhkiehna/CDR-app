<?php

namespace App\Nova\Metrics;

use App\NexusMessage;
use App\NexusConversation;
use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Value;

class UserMessagesSentValue extends Value
{
    public $name = 'Total Sent Messages (This User)';

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
            NexusMessage::whereIn('conversation_id', $conversationIds->toArray())->where('type', 'OutgoingMessage')
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

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'user-messages-sent-value';
    }
}
