<?php

/**
 * @param       $class
 * @param array $attributes
 * @param null  $count
 * @return Illuminate\Database\Eloquent\Model
 */
function create($class, $attributes = [], $count = null)
{
    return factory($class, $count)->create($attributes);
}

/**
 * @param       $class
 * @param array $attributes
 * @param null  $count
 * @return Illuminate\Database\Eloquent\Model
 */
function make($class, $attributes = [], $count = null)
{
    return factory($class, $count)->make($attributes);
}

/**
 * @param       $class
 * @param array $attributes
 * @param null  $count
 * @return array
 */
function raw($class, $attributes = [], $count = null)
{
    return factory($class, $count)->raw($attributes);
}

/**
 * @param array $attributes
 * @return App\User
 */
function setActiveStaff($attributes = [])
{
    $attributes['role_id'] = 1;
    return factory('App\User')->create($attributes)->setActive()->user;
}

/**
 * @param array $attributes
 * @return App\User
 */
function setActiveWorker($attributes = [])
{
    $attributes['role_id'] = 2;
    return factory('App\User')->create($attributes)->setActive()->user;
}