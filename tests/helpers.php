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
 * @return App\Staff
 */
function setActiveStaff($attributes = [])
{
    $staff = factory('App\Staff')->create($attributes);
    $staff->user->setActive();
    return $staff;
}

/**
 * @param array $attributes
 * @return App\Worker
 */
function setActiveWorker($attributes = [])
{
    $worker = factory('App\Worker')->create($attributes);
    $worker->user->setActive();
    return $worker;
}