<?php

namespace jf\core\iterator;

/**
 * This file is part of jfPHP.Core
 *
 * Copyright (c) 2010-2011, Jérôme Fath <http://www.jeromefath.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.txt.
 */

use jf\core\object\HierachicalInterface;

/**
 * Browse children of an object implementing HierachicalInterface recursively
 * 
 * @category   jf
 * @package    core
 * @subpackage iterator 
 * @author     Jérôme Fath <projects@jeromefath.com>
 * @copyright  Copyright (c) 2010-2011, Jérôme Fath <http://www.jeromefath.com>
 */
class HierachicalIterator implements \RecursiveIterator
{
    /**
     * @var array List of children
     */
    private $_children = array();
    
    
    /**
     * Constructor, gets the children to browse
     * 
     * @param HierachicalInterface $hierachicalObject
     * @return void
     */
    public function __construct(HierachicalInterface $hierachicalObject)
    {
       $this->_children = $hierachicalObject->getChildren();
    }
    
    public function current()    
    {        
        return current($this->_children);    
    }
    
    public function key()    
    {        
        return key($this->_children);    
    }
    
    public function next()    
    {        
        return next($this->_children);    
    }
    
    public function rewind()    
    {        
        reset($this->_children);    
    }
    
    public function valid()    
    {        
        return array_key_exists($this->key(), $this->_children);    
    }
    
    public function hasChildren()    
    {
        return $this->current()->hasChildren();
    }
    
    public function getChildren()    
    {
        return new self($this->current());
    }
}