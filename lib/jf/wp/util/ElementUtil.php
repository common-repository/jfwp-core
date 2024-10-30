<?php

namespace jf\wp\util;

/**
 * This file is part of jfWP.Core
 *
 * Copyright (c) 2010-2011, Jérôme Fath <http://www.jeromefath.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.txt.
 */

/**
 * Static methods for manipulation elements (posts, pages, terms,..)
 * 
 * @category   jf
 * @package    wp
 * @subpackage util
 * @author     Jérôme Fath <projects@jeromefath.com>
 * @copyright  Copyright (c) 2010-2011, Jérôme Fath <http://www.jeromefath.com>
 */
class ElementUtil
{
    /**
     * Creates the hierarchy of elements
     *
     * @param array $elements List of elements
     * @param string $attributeId Id attribute elements
     * @param string $attributeIdParent IdParent attribute elements
     * @return array Returns hierary of elements
     * @throws RuntimeException If the element isn't an object or not contains attributes
     */
    public static function hierarchy(array $elements, $attributeId, $attributeIdParent)
    {
        $hierarchy = array();
        
        $newElements = array();
        foreach($elements as $element)
        {
            if(!isset($element->{$attributeId}) || !isset($element->{$attributeIdParent}))
            {
                throw new \RuntimeException(sprintf('Unable to create the hierarchy, the element isn\'t an object or not contains attributes "%s", "%s"', 
                                                    $attributeId, $attributeIdParent));
            }
            
            $newElements[] = clone $element;
        }
        
        foreach($newElements as $element)
        {
            if($element->{$attributeIdParent} == 0)
            {
                $hierarchy[$element->{$attributeId}] = $element;
            }
            else
            {
                $elementParent = self::getParent($newElements, $attributeId, $element->{$attributeIdParent});

                if($elementParent)
                {
                    $elementParent->{$element->{$attributeId}} = $element;
                }
            }
        }
        
        return $hierarchy;
    }
    
    /**
     * Returns the parent element
     *
     * @param array $elements List of elements
     * @param string $attributeId Id attribute elements
     * @param string $idParent
     * @return stdClass
     */
    private function getParent(array $elements, $attributeId, $idParent)
    {
        $elementParent = null;
        
        foreach($elements as $element)
        {
            if($element->{$attributeId} == $idParent)
            {
                $elementParent = $element;
                break;
            }
        }
        
        return $elementParent;
    }
}