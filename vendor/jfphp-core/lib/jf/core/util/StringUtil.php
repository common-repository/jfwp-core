<?php

namespace jf\core\util;

/**
 * This file is part of jfPHP.Core
 *
 * Copyright (c) 2010-2011, Jérôme Fath <http://www.jeromefath.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.txt.
 */

/**
 * Static methods for manipulation strings
 * 
 * @category   jf
 * @package    core
 * @subpackage util
 * @author     Jérôme Fath <projects@jeromefath.com>
 * @copyright  Copyright (c) 2010-2011, Jérôme Fath <http://www.jeromefath.com>
 */
final class StringUtil
{
    /**
     * Replaces non-ASCII characters with ASCII characters.
     * Tries to replace some characters like ñ or ç to a similar ASCII character.
     * 
     * @param string $string
     * @return string
     */
    // code from http://sourcecookbook.com/en/recipes/8/function-to-slugify-strings-in-php
    public static function slugify($string)
    {
         // replace non letter or digits by -
          $text = preg_replace('~[^\\pL\d]+~u', '-', $string);
         
          // trim
          $text = trim($text, '-');
         
          // transliterate
          if (function_exists('iconv'))
          {
              $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
          }
         
          // lowercase
          $text = strtolower($text);
         
          // remove unwanted characters
          $text = preg_replace('~[^-\w]+~', '', $text);
         
          if (empty($text))
          {
              return 'n-a';
          }
         
          return $text;
    }
}