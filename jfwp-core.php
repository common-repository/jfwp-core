<?php

/*
Plugin Name: jfWP.Core
Plugin URI: http://projects.jeromefath.com
Author: Jérôme Fath
Author URI: http://www.jeromefath.com
Description: Adds an object oriented API to Wordpress. Requires PHP 5.3 to be installed.
Version: 0.2.1
*/

use jf\core\reflection\ClosureReflection;

add_action('plugins_loaded', 'jfwp_core_init', 5);
function jfwp_core_init()
{
    $path = dirname(__FILE__).'/vendor';
    
    set_include_path(dirname(__FILE__).'/lib'
    			     .PATH_SEPARATOR.
                     $path.'/jfphp-core/lib'
                     .PATH_SEPARATOR.
                     $path.'/zend/library');
    
    require_once $path.'/zend/library/Zend/Loader/Autoloader.php';
    
    Zend_Loader_Autoloader::getInstance()->registerNamespace('jf'); 
}

/*
add_action('plugins_loaded', 'jfwp_core_closures');
function jfwp_core_closures()
{
    $classesReflection = array('jf\core\util\StringUtil',
                               'jf\wp\helper\ListHelper');
    
    foreach ($classesReflection as $classReflection)
    {
        try {
            $closureReflection = new ClosureReflection($classReflection);
            $closureReflection->reflect(array('prefix'=>'jf'));
        }
        catch (ReflectionException $e) {
            //echo $e->getMessage();
        }
        
        foreach ($closureReflection as $name => $closure)
        {
           global ${$name};
           ${$name} = $closure;
        }
    }
}
*/