<?php

namespace jf\core\object;

/**
 * This file is part of jfPHP.Core
 *
 * Copyright (c) 2010-2011, Jérôme Fath <http://www.jeromefath.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.txt.
 */

/**
 * Manages array as an object and adds features stdClass object
 *
 * @category   jf
 * @package    core 
 * @subpackage object
 * @author     Jérôme Fath <projects@jeromefath.com>
 * @copyright  Copyright (c) 2010-2011, Jérôme Fath <http://www.jeromefath.com>
 */
class StdObject implements \Iterator
{
    /**
     * @var stdClass
     */
    private $_object; 
    
	/**
     * Returns stdClass 
     * 
     * @return stdClass
     */
    public function getStdClass()
    {
        return $this->_object;
    }

    /**
     * Constructor
     *
     * @param mixed $data Array or StdClass to convert
     * @return void
     * @throws InvalidArgumentException When the parameter is not supported
     */
    public function __construct($data = null)
    {
        $this->_object = new \StdClass();
        
        if($data != null)
        {
            if(is_array($data) || $data instanceof \stdClass)
            {
                $this->_object = $this->convertToObject($data);
            }
            else
            {
                throw new \InvalidArgumentException('This parameter type is not supported');
            }
        }
    }
    
    /**
     * Returns value of property
     *
     * @param string $property Name of property
     * @return mixed Value of property
     * @throws LogicException If the requested property not exist
     */
    public function __get($property)
    {
        if(!isset( $this->getStdClass()->{$property}))
        {
            throw new \LogicException('Undefined property');
        }
        
        return $this->getStdClass()->{$property};
    }
    
    /**
     * Adds properties, if the value is an array or stdClass
     * it's automatically converted
     * 
     * @param string $property Name of property
     * @param mixed $value Value to assign
     * @return void
     */
    public function __set($property, $value)
    {
        $this->getStdClass()->{$property} = is_array($value) || $value instanceof \stdClass ? $this->convertToObject($value) : $value;
    }
    
    /**
     * Determines whether a property is defined
     *
     * @param $property Name of property
     * @return bool
     */
    public function __isset($property) 
    {
        return isset($this->getStdClass()->{$property});
    }
    
    /**
     * Destroyed a property
     * 
     * @param $property Name of property
     * @return void
     */
    public function __unset($property)
    {
        unset($this->getStdClass()->{$property});
    }
    
    /**
     * Returns the current element
     * 
     * @return mixed
     */
    public function current()    
    {        
        return current( $this->getStdClass());    
    }
    
    /**
     * Returns the property object of the current element
     * 
     * @return mixed
     */
    public function key()    
    {        
        return key($this->getStdClass());    
    }
    
    /**
     * Advance the internal object pointer
     * 
     * @return mixed
     */
    public function next()    
    {        
        return next($this->getStdClass());    
    }
    
    /**
     * Rewind the internal object pointer
     * 
     * @return bool
     */
    public function rewind()    
    {        
        reset($this->getStdClass());    
    }
    
    /**
     * Validates the existence of the object property
     *
     * @return bool
     */
    public function valid()    
    {        
        return array_key_exists($this->key(),  $this->getStdClass());    
    }
    
    /**
     * Converted to stdClass object
     *
     * @param mixed $data
     * @return stdClass
     */
    protected function convertToObject($data)
    {
       $object = new \stdClass();
        
       foreach($data as $key => $value)
       {
            if(is_array($value))
            {
                $object->$key = $this->convertToObject($value);
            }
            else
            {
                $object->$key = $value;
            }
       }
       
       return $object ;
    }
}
