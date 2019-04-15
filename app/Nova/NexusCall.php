<?php

namespace App\Nova;

use App\Nova\NexusUser;
use Carbon\CarbonInterval;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;

class NexusCall extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\NexusCall';

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Nexus';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The relationships that should be eager loaded on index queries.
     *
     * @var array
     */
    public static $with = ['user'];

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'sid',
    ];

    public static function label()
    {
        return 'Calls';
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make('ID', 'id')->readonly(true)->sortable(),

            Text::make('Type', 'type')->readonly(true)->sortable(),
            Number::make('Duration', function () {
                return $this->getCallDuration($this->duration);
            }),
            DateTime::make('Made At', 'created_at')->readonly(true)->sortable(),

            BelongsTo::make('User', 'user', NexusUser::class),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }

    protected function getCallDuration($durationSeconds) : string
    {
        if ($durationSeconds >= 3600) {
            $hours = floor(($durationSeconds / 3600));
            $durationSeconds = $durationSeconds % 3600;
            $minutes = floor($durationSeconds / 60);
            $seconds = $durationSeconds % 60;

            return CarbonInterval::make(CarbonInterval::hours((int) $hours)->minutes((int) $minutes)->seconds((int) $seconds))->forHumans();
        }

        if ($durationSeconds >= 60) {
            $minutes = floor($durationSeconds / 60);
            $seconds = $durationSeconds % 60;

            return CarbonInterval::make(CarbonInterval::minutes((int) $minutes)->seconds((int) $seconds))->forHumans();
        }

        return CarbonInterval::make(CarbonInterval::seconds((int) $durationSeconds))->forHumans();
    }
}
