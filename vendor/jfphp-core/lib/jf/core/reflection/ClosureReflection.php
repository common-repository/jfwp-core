<?php

namespace jf\core\reflection;

/**
 * This file is part of jfPHP.Core
 *
 * Copyright (c) 2010-2011, Jérôme Fath <http://www.jeromefath.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.txt.
 */

/**
 * Creates closures for a class or object
 * 
 * @category   jf
 * @package    core
 * @subpackage reflection
 * @author     Jérôme Fath <projects@jeromefath.com>
 * @copyright  Copyright (c) 2010-2011, Jérôme Fath <http://www.jeromefath.com>
 */
class ClosureReflection implements \Iterator, \Countable
{
    /**
     * @var Object Instance to reflect
     */
    private $_instance;
    
    /**
     * @var ReflectionClass
     */
    private $_reflectionClass;
    
    /**
     * @var array Array of closures reflected
     */
    private $_closures;
    
    /**
     * Return a closure by name
     *
     * @param string $name Name of closure
     * @return Closure
     * @throws InvalidArgumentException If the closure isn't available
     */
    public function getClosure($name)
    {
        if(!isset($this->_closures[$name])) 
        {
            throw new \InvalidArgumentException( sprintf('No Closure named "%s" is available',$name) );
        }
        
        return $this->_closures[$name];
    }
    
    /**
     * Return all closures
     *
     * @return array Array of closures reflected
     */
    public function getClosures()
    {
        return $this->_closures;
    }
    
    /**
     * Constructor
     *
     * @param mixed $argument string containing the name of the class to reflect, or object
     * @return void
     */
    public function __construct($argument)
    {
        if(is_object($argument)) 
        {
             $this->_instance = $argument;
        }
        
        $this->_reflectionClass = new \ReflectionClass($argument);
    }
    
 	/**
     * Returns the current closure
     * 
     * @return mixed
     */
    public function current()    
    {        
        return current( $this->_closures );    
    }
    
    /**
     * Returns the name of the current closure
     * 
     * @return mixed
     */
    public function key()    
    {        
        return key( $this->_closures );    
    }
    
    /**
     * Advance the internal object pointer
     * 
     * @return mixed
     */
    public function next()    
    {        
        return next( $this->_closures );    
    }
    
    /**
     * Rewind the internal object pointer
     * 
     * @return bool
     */
    public function rewind()    
    {        
        reset( $this->_closures );    
    }
    
    /**
     * Validates the existence of the object property
     *
     * @return bool
     */
    public function valid()    
    {        
        return array_key_exists($this->key(), $this->_closures);    
    }
    
 	/**
     * Counts the number of closure
     *
     * @return bool
     */
    public function count()    
    {        
        return sizeof($this->_closures);  
    }
    
    /**
     * Starts reflection to create closures
     * 
     * $options['prefix'] Prefix up to the closure
     * 
     * @param array $options 
     * @return ClosureReflection this
     */
    public function reflect(array $options = array('prefix' => null))
    {
        $this->_closures = array();
        
        $methods = $this->_reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC);
        $this->closure($methods, isset($options['prefix']) ? $options['prefix'] : null);
        
        return $this;
    }
    
    /**
     * Instances and stores closures
     *
     * @param array $methods 
     * @param string $prefix
     * @return void
     */
    protected function closure($methods, $prefix)
    {
        $instance = $this->_instance;
        
        foreach ($methods as $method)
        {
            if(($instance == null && $method->isStatic()) || $instance !== null)
            {
                $name = $this->name($method, $prefix);
    
                ${$name} = function () use ($instance, $method)
                {
                   return $method->invokeArgs( $instance, func_get_args() ) ;
                };
                
                $this->_closures[$name] = ${$name};
            }
        }
    }
    
     /**
     * Returns the name of the closure
     *
     * @param ReflectionMethod \$method 
     * @param string $prefix
     * @return string
     */
    protected function name(\ReflectionMethod $method, $prefix)
    {
        $name = '';
            
        if($prefix != null) 
        {
            $name .= $prefix.'_';
        }
        
        $name .= strtolower($this->_reflectionClass->getShortName()).'_';
        $name .= strtolower($method->getName());
        
        return $name;
    }
}