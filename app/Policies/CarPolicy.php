<?php

namespace App\Policies;

use App\User;
use App\DLTCar;
use Illuminate\Auth\Access\HandlesAuthorization;

class CarPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the d l t car.
     *
     * @param  \App\User  $user
     * @param  \App\DLTCar  $dLTCar
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

    public function view(User $user, DLTCar $dLTCar)
    {
        if($user->team != ''){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can create d l t cars.
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
     * Determine whether the user can update the d l t car.
     *
     * @param  \App\User  $user
     * @param  \App\DLTCar  $dLTCar
     * @return mixed
     */
    public function update(User $user, DLTCar $dLTCar)
    {
        if($user->team != ''){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can delete the d l t car.
     *
     * @param  \App\User  $user
     * @param  \App\DLTCar  $dLTCar
     * @return mixed
     */
    public function delete(User $user, DLTCar $dLTCar)
    {
        if($user->role == 'superAdmin'){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can restore the d l t car.
     *
     * @param  \App\User  $user
     * @param  \App\DLTCar  $dLTCar
     * @return mixed
     */
    public function restore(User $user, DLTCar $dLTCar)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the d l t car.
     *
     * @param  \App\User  $user
     * @param  \App\DLTCar  $dLTCar
     * @return mixed
     */
    public function forceDelete(User $user, DLTCar $dLTCar)
    {
        //
    }
}
