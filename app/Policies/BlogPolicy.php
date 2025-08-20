<?php

namespace Deschool\Policies;

use Deschool\Model\Blog;
use Deschool\Models\Corox_model;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \Deschool\Models\Corox_model  $user
     * @return mixed
     */
    public function viewAny(Corox_model $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Deschool\Models\Corox_model  $user
     * @param  \Deschool\Models\Blog  $blog
     * @return mixed
     */
    public function view(Corox_model $user, Blog $blog)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \Deschool\Models\Corox_model  $user
     * @return mixed
     */
    public function create(Corox_model $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Deschool\Models\Corox_model  $user
     * @param  \Deschool\Models\Blog  $blog
     * @return mixed
     */
    public function update(Corox_model $user, Blog $blog)
    {
        return ($user->isAdmin() === true && $user->id === $blog->user_id) ? Response::allow()
        : Response::deny('You are not allowed to update this property.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Deschool\Models\Corox_model  $user
     * @param  \Deschool\Models\Blog  $blog
     * @return mixed
     */
    public function delete(Corox_model $user, Blog $blog)
    {
        return $user->isAdmin() == true            
        ? Response::allow()
        : Response::deny('You are not allowed to delete this blog post');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Deschool\Models\Corox_model  $user
     * @param  \Deschool\Models\Blog  $blog
     * @return mixed
     */
    public function restore(Corox_model $user, Blog $blog)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Deschool\Models\Corox_model  $user
     * @param  \Deschool\Models\Blog  $blog
     * @return mixed
     */
    public function forceDelete(Corox_model $user, Blog $blog)
    {
        //
    }
}
