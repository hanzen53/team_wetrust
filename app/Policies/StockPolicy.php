<?php

namespace App\Policies;

use App\User;
use App\DeviceStock;
use Illuminate\Auth\Access\HandlesAuthorization;

class StockPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the device stock.
     *
     * @param  \App\User  $user
     * @param  \App\DeviceStock  $deviceStock
     * @return mixed
     */

    public function viewAny(User $user)
    {
        if($user->team != ''){
            return true;
        }else{
            return false;
        }
    }

    public function view(User $user, DeviceStock $deviceStock)
    {
        if($user->team != ''){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can create device stocks.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if($user->team != ''){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can update the device stock.
     *
     * @param  \App\User  $user
     * @param  \App\DeviceStock  $deviceStock
     * @return mixed
     */
    public function update(User $user, DeviceStock $deviceStock)
    {
        if($user->team != ''){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can delete the device stock.
     *
     * @param  \App\User  $user
     * @param  \App\DeviceStock  $deviceStock
     * @return mixed
     */
    public function delete(User $user, DeviceStock $deviceStock)
    {
        if($user->role == 'superAdmin'){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can restore the device stock.
     *
     * @param  \App\User  $user
     * @param  \App\DeviceStock  $deviceStock
     * @return mixed
     */
    public function restore(User $user, DeviceStock $deviceStock)
    {
        if($user->role == 'superAdmin'){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can permanently delete the device stock.
     *
     * @param  \App\User  $user
     * @param  \App\DeviceStock  $deviceStock
     * @return mixed
     */
    public function forceDelete(User $user, DeviceStock $deviceStock)
    {
        if($user->role == 'superAdmin'){
            return true;
        }else{
            return false;
        }
    }
}
