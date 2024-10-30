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
class PasswordField extends Field
{
    public function renderField($value = null, array $attributes = array())
    {
        return $this->renderTag('input', array_merge($this->getAttributes(), $attributes, array('type' => 'password', 'value' => $value)));
    }
}