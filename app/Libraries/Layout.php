<?php

/**
 * Add Layouts, CSS and JS file to views via the controller.
 * @author Saish
 */

namespace App\Libraries;

class Layout 
{
    static private $jsFiles = [];
    static private $cssFiles = [];

    static private $jsTemplate = '<script src="{file}" {loadType}></script>';
    static private $cssTemplate = '<link href="{file}" rel="stylesheet">';

    public function __construct() 
    {
        
    }

    public function addJS(array $jsFiles) 
    {
        self::$jsFiles = array_merge(self::$jsFiles, $jsFiles);
    }

    public function addCSS(array $cssFiles) 
    {
        self::$cssFiles = array_merge(self::$cssFiles, $cssFiles);
    }

    public static function addJSToView() 
    {
        if (self::$jsFiles) {
            foreach (self::$jsFiles as $file) {
                if (!is_array($file)) {
                    $jsHtml = str_replace("{file}", asset('public/' . $file), self::$jsTemplate);
                    echo str_replace("{loadType}", "defer", $jsHtml);
                } else {
                    $jsHtml = str_replace("{file}", asset('public/' . $file[0]), self::$jsTemplate);
                    echo str_replace("{loadType}", "", $jsHtml);
                }
            }
        }
    }

    public static function addCSSToView() 
    {
        if (self::$cssFiles) {
            foreach (self::$cssFiles as $file) {
                echo str_replace("{file}", asset('public/' . $file), self::$cssTemplate);
            }
        }
        
    }

}