<?php

namespace App\Policies;

use App\User;
use App\Device;
use Illuminate\Auth\Access\HandlesAuthorization;

class DevicesPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the device.
     *
     * @param  \App\User  $user
     * @param  \App\Device  $device
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


    public function view(User $user, Device $device)
    {
        if($user->team != ''){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can create devices.
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
     * Determine whether the user can update the device.
     *
     * @param  \App\User  $user
     * @param  \App\Device  $device
     * @return mixed
     */
    public function update(User $user, Device $device)
    {
        if($user->team != ''){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can delete the device.
     *
     * @param  \App\User  $user
     * @param  \App\Device  $device
     * @return mixed
     */
    public function delete(User $user, Device $device)
    {
        if($user->role == 'superAdmin'){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can restore the device.
     *
     * @param  \App\User  $user
     * @param  \App\Device  $device
     * @return mixed
     */
    public function restore(User $user, Device $device)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the device.
     *
     * @param  \App\User  $user
     * @param  \App\Device  $device
     * @return mixed
     */
    public function forceDelete(User $user, Device $device)
    {
        //
    }
}
