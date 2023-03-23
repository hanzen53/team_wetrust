<?php

namespace App\Policies;

use App\User;
use App\DLTCustomer;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomersPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the d l t customer.
     *
     * @param  \App\User  $user
     * @param  \App\DLTCustomer  $dLTCustomer
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

    public function view(User $user, DLTCustomer $dLTCustomer)
    {
        if($user->team != ''){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can create d l t customers.
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
     * Determine whether the user can update the d l t customer.
     *
     * @param  \App\User  $user
     * @param  \App\DLTCustomer  $dLTCustomer
     * @return mixed
     */
    public function update(User $user, DLTCustomer $dLTCustomer)
    {
        if($user->team != ''){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can delete the d l t customer.
     *
     * @param  \App\User  $user
     * @param  \App\DLTCustomer  $dLTCustomer
     * @return mixed
     */
    public function delete(User $user, DLTCustomer $dLTCustomer)
    {
        if($user->role == 'superAdmin'){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can restore the d l t customer.
     *
     * @param  \App\User  $user
     * @param  \App\DLTCustomer  $dLTCustomer
     * @return mixed
     */
    public function restore(User $user, DLTCustomer $dLTCustomer)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the d l t customer.
     *
     * @param  \App\User  $user
     * @param  \App\DLTCustomer  $dLTCustomer
     * @return mixed
     */
    public function forceDelete(User $user, DLTCustomer $dLTCustomer)
    {
        //
    }
}
