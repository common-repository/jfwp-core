<?php

namespace jf\wp\helper;

/**
 * This file is part of jfWP.Core
 *
 * Copyright (c) 2010-2011, Jérôme Fath <http://www.jeromefath.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.txt.
 */

/**
 * Creates a list of html links
 * 
 * @category   jf
 * @package    wp
 * @subpackage helper
 * @author     Jérôme Fath <projects@jeromefath.com>
 * @copyright  Copyright (c) 2010-2011, Jérôme Fath <http://www.jeromefath.com>
 */
final class ListHelper
{
    /**
     * Returns a list of html links for categories
     * 
     * <code>
     * $args['use_title'] //Uses or not the title attribute
     * $args['use_desc_for_title'] //Uses the description as a title
     * $args['use_nofollow']
     * $args['echo'] //Displays or not the list of html links
     * </code>
     * 
     * @param array $categories
     * @param string $before 
     * @param string $sep
     * @param string $after
     * @param array $args 
     * @return string
     */
    public static function category($categories, 
                                    $before = '<ul><li>', 
                                    $sep = '</li><li>', 
                                    $after = '</li></ul>', 
                                    $args = null)
    {
        return self::term($categories, 'category', $before, $sep, $after, $args);
    }
    
    /**
     * Returns a list of html links for tags
     * 
     * <code>
     * $args['use_title'] //Uses or not the title attribute
     * $args['use_desc_for_title'] //Uses the description as a title
     * $args['use_nofollow']
     * $args['echo'] //Displays or not the list of html links
     * </code>
     * 
     * @param array $tags
     * @param string $before 
     * @param string $sep
     * @param string $after
     * @param array $args 
     * @return string
     */
    public static function tag($tags,
                               $before = '<ul><li>', 
                               $sep = '</li><li>', 
                               $after = '</li></ul>', 
                               $args = null)
    {
        return self::term($tags, 'post_tag', $before, $sep, $after, $args);
    }
    
    /**
     * Returns a list of html links for terms
     * 
     * <code>
     * $args['use_title'] //Uses or not the title attribute
     * $args['use_desc_for_title'] //Uses the description as a title
     * $args['use_nofollow']
     * $args['echo'] //Displays or not the list of html links
     * </code>
     * 
     * @param array $terms
     * @param string $taxonomie
     * @param string $before 
     * @param string $sep
     * @param string $after
     * @param array $args 
     * @return string
     */
    public static function term($terms, $taxonomie,
                                $before = '<ul><li>', 
                                $sep = '</li><li>', 
                                $after = '</li></ul>', 
                                $args = null)
    {
        $html = '';
        
        $use_title = $args == null || !isset($args['use_title']) ? true : (bool) $args['use_title'];
        $use_desc_for_title = $args == null || !isset($args['use_desc_for_title']) ? true : (bool) $args['use_desc_for_title'];
        $use_nofollow = $args == null || !isset($args['use_nofollow']) ? false : (bool) $args['use_nofollow'];
        $echo = $args == null || !isset($args['echo']) ? true : (bool) $args['echo'];
    
        $count = count($terms);
        $i = 0;
        
        foreach ($terms as $term)
        {
            $i ++;
            
            $html .= '<a href="'.get_term_link( $term, $taxonomie).'"';
            
            if($use_title)
            {
                $title = $use_desc_for_title == true ? $term->description : $term->name;
                
                $html .= ' title="'.$title.'" ';
            }
            
            if($use_nofollow)
            {
                 $html .= ' rel="nofollow" ';
            }
            
            $html .= '>'.$term->name.'</a>';
            
            if($i < $count)
            {
                $html .= $sep;
            }
        } 
        
        $html = $before.$html.$after;
        
        if($echo == true)
        {
            echo $html;
        }
        
        return $html;
    }
}