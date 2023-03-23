<?php

namespace App\Nova\Actions;

use App\Agent;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Koss\LaravelNovaSelect2\Select2;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AssignStockToAgent extends Action
{

    use InteractsWithQueue, Queueable, SerializesModels;

    public $name = 'โยน IMEI ให้ ตัวแทน';

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $agent = Agent::find($fields->agent_id);

        foreach ($models as $model) {

            $model->update([
                'agent_use' => 1,
                'agent_id' => $fields->agent_id,
                'agent_name' => $agent->agent_name,
                'assign_agent_date' => Carbon::now()->format('Y-m-d'),
            ]);
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        $agents = Agent::all()->pluck('agent_name','id');
        return [
            Select2::make('ตัวแทน', 'agent_id')
                ->options($agents)
                /**
                 * Documentation
                 * https://select2.org/configuration/options-api
                 */
                ->configuration([
                    'placeholder'             => __('เลือกตัวแทน'),
                    'allowClear'              => true,
                    'minimumResultsForSearch' => 1
                ])
                ->showAsLink(),//Show as link to resource in Index and Detail page
        ];
    }
}
