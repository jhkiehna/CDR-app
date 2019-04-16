<?php

namespace App\Nova;

use App\Nova\NexusCall;
use App\Nova\NexusMessage;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\HasMany;
use App\Nova\Metrics\UserCallsValue;
use App\Nova\Metrics\TotalCallsValue;
use App\Nova\Metrics\UserCallTimeValue;
use App\Nova\Metrics\TotalCallTimeValue;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Nova\Metrics\TotalInboundCallsValue;
use App\Nova\Metrics\TotalOutboundCallsValue;
use App\Nova\Metrics\UserAverageCallTimeValue;

class NexusUser extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\NexusUser';

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
    public static $title = 'email';

    /**
     * The relationships that should be eager loaded on index queries.
     *
     * @var array
     */
    public static $with = [
        'calls',
        'messages',
    ];

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'walter_id',
        'first_name',
        'last_name',
        'email',
    ];

    public static function label()
    {
        return 'Users';
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
            ID::make('Walter ID', 'walter_id')->readonly(true)->sortable(),
            ID::make('Intranet ID', 'intranet_id')->readonly(true)->sortable(),

            Text::make('Email', 'email')->readonly(true)->sortable(),
            Text::make('Name', function () {
                return $this->last_name. ', ' .$this->first_name;
            })->readonly(true)->sortable(),

            HasMany::make('Calls', 'calls', NexusCall::class),
            HasMany::make('Messages', 'messages', NexusMessage::class),
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
        return [
            (new TotalCallsValue)->width('1/2'),
            (new TotalCallTimeValue)->width('1/2'),
            (new TotalInboundCallsValue)->width('1/2'),
            (new TotalOutboundCallsValue)->width('1/2'),

            (new UserCallsValue)->onlyOnDetail(),
            (new UserCallTimeValue)->onlyOnDetail(),
            (new UserAverageCallTimeValue)->onlyOnDetail(),
        ];
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
}
