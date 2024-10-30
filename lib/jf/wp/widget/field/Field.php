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
abstract class Field
{
    /**
     * @var WP_Widget
     */
    protected $widget = null;
    
    /**
     * 
     * @var string Name of the field 
     */
    protected $name = null;
    
    /**
     * @var array
     */
    private $_options = array('label' => '',
                              'before_label' => '',
                              'after_label' => '<br />');
    
    /**
     * Returns options
     * 
     * @return array
     */
    public function getOptions()
    {
        return $this->_options;
    }
    
    /**
     * Returns an option
     * 
     * @param string $name
     * @return mixed
     */
    public function getOption($name)
    {
        return isset($this->_options[$name]) ? $this->_options[$name] : null;
    }
    
    /**
     * Sets an option
     * 
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function setOption($name, $value)
    {
        $this->_options[$name] = $value;
    }
    
    /**
     * @var array
     */
    private $_attributes = array();
    
    /**
     * Returns attributes of field
     * 
     * @return array
     */
    public function getAttributes()
    {
        return $this->_attributes;
    }
    
    /**
     * Returns an attribute of field
     * 
     * @param string $name
     * @return mixed
     */
    public function getAttribute($name)
    {
        return isset($this->_attributes[$name]) ? $this->_attributes[$name] : null;
    }
    
    /**
     * Sets an attribute of field
     * 
     * @param string $name
     * @param mixed $value
     * @return void
     * @throws InvalidArgumentException
     */
    public function setAttribute($name, $value)
    {
        if(in_array($value, array('id', 'name'))) 
        {
            throw new InvalidArgumentException(sprintf('The attribute "%s" is not allowed to be updated', $name));
        }
        
        $this->_attributes[$name] = $value;
    }
    
    /**
     * Abstract method to render the html field (input, select, textarea)
     *
     * @param mixed $value 
     * @param array $attributes 
     * @return string
     */
    abstract public function renderField($value = null, array $attributes = array());
    
    /**
     * Constructor
     * 
     * @param array $options
     * @param array $attributes
     * @return void
     */
    public function __construct(array $options = array(), 
                                array $attributes = array())
    {
        foreach ($options as $name => $valuealue)
        {
            $this->setOption($name, $valuealue);
        }
        
        foreach ($attributes as $name => $valuealue)
        {
            $this->setAttribute($name, $valuealue);
        }
    }
    
    /**
     * Initializes object
     * 
     * @param WP_Widget $options
     * @param string $name
     * @return void
     */
    public function initialize(\WP_Widget $widget, $name)
    {
        $this->widget = $widget;
        $this->name = $name;

        $this->_attributes['id'] =  $this->widget->get_field_id($this->name);
        $this->_attributes['name'] = $this->widget->get_field_name($this->name);
    }
    
    /**
     * Renders html
     * 
     * @param mixed $value Value field
     * @param array $attributes Attributes field 
     * @return string
     */
    public function render($value = null, array $attributes = array())
    {
        return sprintf('<p>%s%s</p>', $this->renderLabel(), $this->renderField($value, $attributes) );
    }
    
    /**
     * Renders html tag "label"
     * 
     * @return string
     */
    public function renderLabel()
    {
        $label = $this->getOption('label');
        
        if (empty($label))
        {
            return '';
        }
        
        $tag = $this->renderContentTag('label', $label, array('for' => $this->getAttribute('name')));
        
        return sprintf('%s%s%s', $this->getOption('before_label'), $tag, $this->getOption('after_label'));
    }
    
    /**
     * Renders a html tag
     * 
     * @param string $tag
     * @param array $attributes
     * @return string
     */
    public function renderTag($tag, $attributes = array())
    {
        if (empty($tag))
        {
            return '';
        }
        
        return sprintf('<%s%s/>', $tag, $this->attributesToHtml($attributes), $tag);
    }
    
    /**
     * Renders a html content tag
     * 
     * @param string $tag
     * @param string $content
     * @param array $attributes
     * @return string
     */
    public function renderContentTag($tag, $content, $attributes = array())
    {
        if (empty($tag))
        {
            return '';
        }
    
        return sprintf('<%s%s>%s</%s>', $tag, $this->attributesToHtml($attributes), $content, $tag);
    }
    
    /**
     * Converts an array of attributes for html representation
     *
     * @param array $attributes
     * @return string
     */
    // code from http://www.symfony-project.org
    public function attributesToHtml($attributes)
    {
        return implode('', array_map(array($this, 'attributesToHtmlCallback'), array_keys($attributes), array_values($attributes)));
    }
    
    /**
     * Prepares an attribute key and value for html representation
     * 
     * @param string $key
     * @param mixed $value
     * @return string
     */
    // code from http://www.symfony-project.org
    protected function attributesToHtmlCallback($key, $value)
    {
        return false === $value || null === $value || ('' === $value && 'value' != $key) ? '' : sprintf(' %s="%s"', $key, esc_attr($value));
    }
}