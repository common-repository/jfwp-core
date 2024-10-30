<?php

namespace jf\wp\widget\field;

/**
 * This file is part of jfWP.Core
 *
 * Copyright (c) 2010-2011, Jérôme Fath <http://www.jeromefath.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.txt.
 */

/**
 * 
 * @category   jf
 * @package    wp
 * @subpackage widget\field
 * @author     Jérôme Fath <projects@jeromefath.com>
 * @copyright  Copyright (c) 2010-2011, Jérôme Fath <http://www.jeromefath.com>
 */
class CheckboxField extends Field
{
    public function __construct(array $options = array(), 
                                array $attributes = array())
    {
        $this->setOption('after_label', '');
        
        parent::__construct($options, $attributes);
    }
    
    public function renderField($value = null, array $attributes = array())
    {
        if (null !== $value && $value !== false)
        {
            $attributes['checked'] = 'checked';
        }
    
        return $this->renderTag('input', array_merge($this->getAttributes(), $attributes, array('type' => 'checkbox', 'value' => $value)));
    }
}