<?php

namespace jf\wp\widget;

/**
 * This file is part of jfWP.Core
 *
 * Copyright (c) 2010-2011, Jérôme Fath <http://www.jeromefath.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.txt.
 */

use jf\wp\widget\field\Field;

/**
 * Manages the widgets developed with namespaces
 * 
 * @category   jf
 * @package    wp
 * @subpackage widget
 * @author     Jérôme Fath <projects@jeromefath.com>
 * @copyright  Copyright (c) 2010-2011, Jérôme Fath <http://www.jeromefath.com>
 */

abstract class Widget extends \WP_Widget
{
    /**
     * @var array Form fields
     */
    private $_fields = array();
    
    /**
     * Returns a field from its name
     *
     * @param string $name 
     * @return Field
     */
    public function getField($name)
    {
        return isset($this->_fields[$name]) ? $this->_fields[$name] : null;
    }
    
    /**
     * Sets a field to the form and initializing
     * 
     * <code>
     * $this->setField('taxonomy', new TextField())
     * //It's a shortcut to do
     * $textField = new TextField();
     * $textField->initialize($this, 'taxonomy');
     * </code>
     * 
     * The field value can be retrieved in $instance['taxonomy']
     *
     * @param string $name 
     * @param Field $field
     * @return void
     */
    public function setField($name, Field $field)
    {
        $this->_fields[$name] = $field;
        
        $field->initialize($this, $name);
    }
    
    /**
     * Returns fields
     *
     * @return array
     */
    public function getFields()
    {
        return $this->_fields;
    }
    
    /**
     * Sets fields
     * 
     * <code>
     * $this->setFields(array('taxonomy' =>  new TextField(),
     * 						  'arguments' => new TextField() ));
     * </code>
     * 
     * Field values ​​can be retrieved in 
     * $instance['taxonomy'] and $instance['arguments']
     *
     * @param array $fields 
     * @return void
     */
    public function setFields(array $fields)
    {
        foreach ($fields as $name => $field)
        {
            $this->setField($name, $field);
        }
    }
    
    /**
     * Abstract method for implementing the function the_widget()
     *
     * @param array $instance The widget's instance settings
     * @param array $args The widget's sidebar args 
     * @return void
     */
    abstract public static function display($instance = null, $args = null);
    
    /**
	 * Constructor
	 *
	 * @param string $id_base Optional Base ID for the widget
	 * @param string $name Name for the widget displayed on the configuration page.
	 * @param array $widget_options Optional Passed to wp_register_sidebar_widget()
	 * @param array $control_options Optional Passed to wp_register_widget_control()
	 */
    public function __construct( $id_base = false, $name, $widget_options = array(), $control_options = array() )
    {
        if(!empty($id_base))
        {
            $id_base = str_replace('\\', '-', $id_base);
        }

        parent::__construct($id_base, $name, $widget_options, $control_options);
    }
    
    /**
     * Displays the fields using current settings
     *
     * @param array $instance Current settings
     * @param array $default Default settings
     * @return void
     */
    protected function displayFields(array $instance, array $default = array())
    {
        $instance = array_merge( $default, $instance );
        
        foreach ($this->_fields as $name => $field) 
        {
            echo $field->render($instance[$name]);
        }
    }
}