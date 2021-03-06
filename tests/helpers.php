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
 * @return App\Staff
 */
function loginStaff()
{
    $user = create('App\User');
    $staff = create('App\Staff', ['user_id' => $user->id]);
    $user->login();
    return $staff;
}

/**
 * @return App\Worker
 */
function loginWorker()
{
    $user = create('App\User');
    $worker = create('App\Worker', ['user_id' => $user->id]);
    $user->login();
    return $worker;
}
