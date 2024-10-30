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
 * HierachicalInterface
 * 
 * @category   jf
 * @package    core
 * @subpackage object
 * @author     Jérôme Fath <projects@jeromefath.com>
 * @copyright  Copyright (c) 2010-2011, Jérôme Fath <http://www.jeromefath.com>
 */
interface HierachicalInterface
{
    /**
     * Adds a child
     *
     * @param HierachicalInterface $child
     * @return void
     */
    public function addChild(HierachicalInterface $child);
    
    /**
     * Removes a child
     * 
     * @param HierachicalInterface $child
     * @return void
     */
    public function removeChild(HierachicalInterface $child);
    
    /**
     * Indicates the presence of children
     *
     * @return bool
     */
    public function hasChildren();

    /**
     * Indicates the presence of a child
     * 
     * @param HierachicalInterface $child
     * @return void
     */
    public function containsChild(HierachicalInterface $child);
    
    /**
     * Return children
     *
     * @return array
     */
    public function getChildren();
    
      
 	/**
     * Count children
     *
     * @return int
     */
    public function countChildren();
}