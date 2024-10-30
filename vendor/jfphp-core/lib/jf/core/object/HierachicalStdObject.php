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
 * Manages array or stdClass as an hierachical object
 * 
 * @category   jf
 * @package    core
 * @subpackage object
 * @author     Jérôme Fath <projects@jeromefath.com>
 * @copyright  Copyright (c) 2010-2011, Jérôme Fath <http://www.jeromefath.com>
 */
class HierachicalStdObject extends StdObject implements HierachicalInterface
{
    /**
     * @var Object id is equivalent to an array index
     */
    private $_id;
    
    /**
     * Returns object id
     *
     * @return string
     */
    public function getId()
    {
        return $this->_id;
    }
    
    /**
     * @var SplObjectStorage List of children
     */
    private $_children = null;
    
    /**
     * Constructor
     *
     * @param string $id Object id
     * @param mixed $data Array or StdClass to convert
     * @return void
     */
    public function __construct($id, $data = null)
    {
        $this->_id = (string) $id;
        
        parent::__construct($data);

        $this->createHierachy($this->getStdClass());
    }
    
    /**
     * Adds properties, if the value is an array or stdClass
     * it's automatically converted and added to the hierarchy
     *
     * @param string $property Name of property
     * @param mixed $value Value to assign
     * @return void
     */
    public function __set($property, $value)
    {
        if(is_array($value) || $value instanceof \stdClass)
        {
            $stdClass = $this->convertToObject($value);
            
            $this->createHierachy(array($property => $stdClass));
        }
        else
        {
            parent::__set($property, $value);
        }
    }
    
    /**
     * Adds a child
     *
     * @param HierachicalStdObject $child
     * @return HierachicalStdObject this
     * @throws InvalidArgumentException If the child is not an instance of HierachicalStdObject
     * @throws RuntimeException If two children have the same id
     */
    public function addChild(HierachicalInterface $child)
    {
        if (!($child instanceof HierachicalStdObject)) 
        {
            throw new \InvalidArgumentException('The child is not an instance of HierachicalStdObject');
        }
        
        if(!$this->_children)
        {
            $this->_children = new \SplObjectStorage();
        }
        else
        {
            if($this->getChildById($child->getId()) !== null)
            {
                throw new \RuntimeException(sprintf('A child with id "%s" is existing', $child->getId()));
            }
        }
        
        $this->_children->attach($child);
        
        return $this;
    }
    
    /**
     * Removes a child
     * 
     * @param HierachicalStdObject $child
     * @return HierachicalStdObject this
     */
    public function removeChild(HierachicalInterface $child)
    {
        $this->_children->detach($child);
        
        if($this->hasChildren() == false)
        {
            $this->_children = null;
        }
        
        return $this;
    }
    
    /**
     * Indicates the presence of children
     *
     * @return bool
     */
    public function hasChildren()
    {
        if($this->_children == null)
        {
            return false;
        }
        
        return sizeof($this->_children) > 0 ? true : false;
    }
    
    /**
     * Indicates the presence of a child
     * 
     * @param HierachicalStdObject $child
     * @return void
     */
    public function containsChild(HierachicalInterface $child)
    {
        return $this->_children == null ? false : $this->_children->contains($child);
    }
    
    /**
     * Return children
     *
     * @return array
     */
    public function getChildren()
    {
        $children = array();
        
        if($this->_children)
        {
            foreach($this->_children as $child)
            {
                $children[] = $child;
            }
        }
        
        return $children;
    }
    
 	/**
     * Count children
     *
     * @return int
     */
    public function countChildren()
    {
        return sizeof($this->getChildren());
    }
    
 	/**
     * Returns a child by id, if the child not exist returns null
     *
     * @param string $id Id of the child to return
     * @return mixed
     */
    public function getChildById($id)
    {
        $child = null;
        
        if($this->_children)
        {
            foreach($this->_children as $hierachicalObject)
            {
                if($hierachicalObject->getId() == $id)
                {
                    $child = $hierachicalObject;
                    break;
                }
            }
        }
        
        return $child;
    }

    /**
     * Built a hierarchy of object
     * 
     * @param mixed $data 
     * @return void
     */
    protected function createHierachy($data)
    {
        foreach($data as $key => $value)
        {
            if($value instanceof \stdClass)
            {
                $this->addChild(new self($key, $value));
                
                unset($data->{$key});
            }
        }
    }
}