<?php

spl_autoload_register('autoload');

function autoload($class)
{
    @include dirname(__FILE__).'/../lib/'.str_replace('\\', '/', $class).'.php';
}