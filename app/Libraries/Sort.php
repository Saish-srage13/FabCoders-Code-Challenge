<?php

/**
 * Used to assist sorting for backend tables
 * generates the html for the sort columns as well as processes the sort params for the db
 *  
 * @author Saish
 */

namespace App\Libraries;

class Sort
{

    protected $baseUrl;
    protected $sort;
    protected $sort_asc;
    protected $sortParam = 'sort';
    protected $sortAscParam = 'sort_asc';
    protected $template = '<a href="{url}" class="{class}" title="{title}">{heading}<i class="{class_icon} right"></i></a>';
    protected $mapping = [];
    protected $schema = '';
    protected $query = '';
    protected $default = 0;
    protected $route;
    
    public function __construct($baseUrl, $sort = null, $sort_asc = null) 
    {
        $this->baseUrl = $baseUrl;
        $this->sort = $sort;
        $this->sort_asc = $sort_asc;
    }
    
    public function setBaseUrl($baseUrl) 
    {
        $this->baseUrl = $baseUrl;
    }
    
    public function setSort($sort) 
    {
        $this->sort = $sort;
    }
    
    public function setSortAsc($sort_asc) 
    {
        $this->sort_asc = $sort_asc;
    }

    public function setTemplate($template) 
    {
        $this->template = $template;
    }
    
    public function setQuery($query) 
    {
        $this->query = $query;
    }
    
    public function setDefault($default) 
    {
        $this->default = $default;
    }

    public function setMapping($arr) 
    {
        $this->mapping = $arr;
    }
    
    public function setSchema($schema) 
    {
        $this->schema = $schema;
    }

    public function setRoute($route) 
    {
        $this->route = $route;
    }
    
    public function getHtml($headingHtml, $column, $template = null) 
    {    
        if ($this->sort != $column || !is_numeric($this->sort_asc)) $sort_asc = null;
        else $sort_asc = ($this->sort_asc ? 1 : 0);
        
        $default_sort_asc = 1;

        if (isset($this->mapping[$column])) {
            $mapping = $this->mapping[$column];
            if (is_array($mapping)) {
                if (isset($mapping['default_sort_asc'])) $default_sort_asc = $mapping['default_sort_asc'] ? 1 : 0;
            }
        }

        if (!$column) {
            $class_icon = '';
            $title = '';
        }
        else if ($this->sort != $column) {
            $class_icon = 'fa fa-sort';
            $title = 'Click to Sort';
        } else if ($sort_asc || (!is_numeric($sort_asc) && $default_sort_asc)) {
            $class_icon = 'fas fa-sort-amount-up';
            $title = 'Sorting Acsending';
        } else {
            $class_icon = 'fas fa-sort-amount-down';   
            $title = 'Sorting Descending';
        }
        
        $class = " sort-row";

        $sortParams = [$this->sortParam => $column];
        if ($this->sort == $column && (!is_numeric($sort_asc) || $sort_asc == $default_sort_asc)) {
            if (is_numeric($sort_asc)) $sortParams[$this->sortAscParam] = $sort_asc ? 0 : 1;
            else $sortParams[$this->sortAscParam] = $default_sort_asc ? 0 : 1;
        }

        $html = $template ?: $this->template;
        $html = str_ireplace('{url}', route($this->route, $sortParams), $html);
        $html = str_ireplace('{class}', $class, $html);
        $html = str_ireplace('{class_icon}', $class_icon, $html);
        $html = str_ireplace('{heading}', $headingHtml, $html);
        $html = str_ireplace('{title}', $title, $html);
        
        return $html;
    }
    
    public function getSort($schema, $returnStr = false)
    {
        $return = [];
        
        $schema = $schema ?: $this->schema;
        
        $sort = $this->sort;
        $sort_asc = $this->sort_asc;
        $query = $this->query;
        $default = $this->default;
        
        if (isset($this->mapping[$sort])) {
            $mapping = $this->mapping[$sort];
            if (is_array($mapping)) {
                if (isset($mapping['default_sort_asc']) && !is_numeric($sort_asc)) $sort_asc = $mapping['default_sort_asc'];
                if (isset($mapping['schema'])) $schema = $mapping['schema'];
                if (isset($mapping['query'])) $query = $mapping['query'];
                if (isset($mapping['default'])) $default = $mapping['default'];
                unset($mapping['default_sort_asc'], $mapping['schema'], $mapping['schemaPhalconStyle']);
                $sort = (isset($mapping['cols']) ? $mapping['cols'] : $mapping);
            } else $sort = $mapping;
        }
        
        // Extended to support custom orderby queries
        if ($query){
            $return[] = is_array($query) ? ((isset($query[$sort_asc]) && $query[$sort_asc])  ? $query[$sort_asc] : $query[$default]) : $query;
            $sort = false; // Set False to stop execution after custom queries
        }
        
        if ($sort) {
            if (is_array($sort)) {
                $return = [];
                foreach ($sort as $s_name => $s_asc) {
                    if (is_numeric($s_name) && !is_numeric($s_asc)) {
                        $s_name = $s_asc;   // then it was a numeric based array so take name from value and then use default global asc/desc param
                        $s_asc = $sort_asc;
                    }
                    if (strstr($s_name, '.')) $schema = ''; // unset schema if we have a dot since we already specified it (this assumes no dot in col name, if there is then thats your problem and just fully qualify it)
                    $return[$s_name] = ($schema ? "{$schema}." : '') . $s_name;
                    $return[$s_name] .= ("$s_asc" === "0" ? ' DESC' : ' ASC');
                }
            } else {
                if (strstr($sort, '.')) $schema = ''; // unset schema if we have a dot since we already specified it (this assumes no dot in col name, if there is then thats your problem and just fully qualify it)
                $return[$sort] = ($schema ? "{$schema}." : '') . $sort;
                $return[$sort] .= ("$sort_asc" === "0" ? ' DESC' : ' ASC');
            }
        }
        
        return ($returnStr ? implode(', ', $return) : $return);
    }
}