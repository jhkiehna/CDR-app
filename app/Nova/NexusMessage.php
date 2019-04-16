<?php

namespace App\Nova;

use App\Nova\NexusUser;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;

class NexusMessage extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\NexusMessage';

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
    public static $with = [
        'conversation',
    ];

    public static $globallySearchable = false;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
    ];

    public static function label()
    {
        return 'Messages';
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
            ID::make()->sortable(),

            Text::make('Type', 'type')->sortable(),
            Text::make('Status', function () {
                switch ($this->type) {
                    case "OutgoingMessage":
                        if ($this->status == 0) {
                            return 'Sent';
                        }
                        if ($this->status == 1) {
                            return 'Delivered';
                        }
                        if ($this->status == 2) {
                            return 'Failed';
                        }
                        break;
                    case "IncomingMessage":
                        if ($this->status == 0) {
                            return 'Delivered';
                        }
                        break;
                }
            })->sortable(),

            DateTime::make('Sent At', 'created_at')->readonly(true)->sortable(),

            Text::make('User', function () {
                $user = $this->getUser();
                $element = '<a href="/resources/nexus-users/'.$user->id.'" class="no-underline dim text-primary font-bold">'.$user->email.'</a>';

                return $element;
            })->asHtml(),
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
}
