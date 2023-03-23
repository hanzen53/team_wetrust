<?php

namespace App\Nova\Actions;

use App\User;
use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserDevice extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $name = 'Get Cars';

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
 
        //Log::debug($models);
        foreach ($models as $model) {
            
           // Log::debug($model->id);
            $devices  = User::find($model->id);
        
            //$filename = $devices->id.'_'.$ $devices->name;
            $filename = "Cars.csv";
            $handle = fopen('../storage/app/public/user-device/'. $filename  ,'w');
            fputcsv($handle, [
                "DeviceID",
                "IMEI",
                "Device Name",
                "Install Date",
                ]);

            foreach($devices->devices as $device){
          
                fputcsv($handle, [
                    $device->id,
                    $device->uniqueId,
                    $device->name,
                    $device->install_date,
                    ]);
            }                    
        }
            

        fclose($handle);
        return Action::download(url('/storage/user-device/' . $filename),$filename );
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }
}
