<?php

function create($class, $attributes = [], $count = null)
{
    return factory($class, $count)->create($attributes);
}

function make($class, $attributes = [], $count = null)
{
    return factory($class, $count)->make($attributes);
}

function raw($class, $attributes = [], $count = null)
{
    return factory($class, $count)->raw($attributes);
}

function setActiveStaff($attributes = [])
{
    $attributes['role_id'] = 1;
    return factory('App\User')->create($attributes)->setActive();
}

function setActiveWorker($attributes = [])
{
    $attributes['role_id'] = 2;
    return factory('App\User')->create($attributes)->setActive();
}