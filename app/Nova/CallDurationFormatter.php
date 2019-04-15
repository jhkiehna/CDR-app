<?php

namespace App\Nova;

use Carbon\CarbonInterval;

class CallDurationFormatter
{
    private $totalDurationSeconds;

    public function __construct($totalDurationSeconds)
    {
        $this->totalDurationSeconds = $totalDurationSeconds;
    }

    public function toString() : string
    {
        if ($this->totalDurationSeconds >= 3600) {
            $hours = floor(($this->totalDurationSeconds / 3600));
            $durationSeconds = $this->totalDurationSeconds % 3600;
            $minutes = floor($durationSeconds / 60);
            $seconds = $durationSeconds % 60;

            return CarbonInterval::make(
                CarbonInterval::hours((int) $hours)->minutes((int) $minutes)->seconds((int) $seconds)
            )->forHumans();
        }

        if ($this->totalDurationSeconds >= 60) {
            $minutes = floor($this->totalDurationSeconds / 60);
            $seconds = $this->totalDurationSeconds % 60;

            return CarbonInterval::make(
                CarbonInterval::minutes((int) $minutes)->seconds((int) $seconds)
            )->forHumans();
        }

        return CarbonInterval::make(
            CarbonInterval::seconds((int) $this->totalDurationSeconds)
        )->forHumans();
    }
}
