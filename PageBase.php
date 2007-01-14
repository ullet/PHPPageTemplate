<?php
/*
 *************************************************************************
 * PHPPageTemplate: A PHP4 page templating system.                       *
 * Version 0.2.0 (14 January 2007)                                       *
 * Copyright (C) 2006-2007 Trevor Barnett                                *
 *                                                                       *
 * This program is free software; you can redistribute it and/or modify  *
 * it under the terms of the GNU General Public License as published by  *
 * the Free Software Foundation; either version 2 of the License, or     *
 * (at your option) any later version.                                   *
 *                                                                       *
 * This program is distributed in the hope that it will be useful,       *
 * but WITHOUT ANY WARRANTY; without even the implied warranty of        *
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the         *
 * GNU General Public License for more details.                          *
 *                                                                       *
 * You should have received a copy of the GNU General Public License     *
 * along with this program; if not, write to the Free Software           *
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  *
 * USA                                                                   *
 *************************************************************************
 */

require_once "PageCache.php";

//* <class name="PageBase" modifiers="public, abstract">
//* Base class for a web page based on a template and a template page
//* </class>
// NB. A template page is just a page with place holders.
class PageBase
{
    //// private member variables
    //* <property name="_pageTemplate" modifiers="private" type="&amp;PageBase">
    //* Template for Page
    //* </property>
    var $_pageTemplate;   
    //* <property name="_placeHolderfunctions" modifiers="private" type="[string,string]">
    //* Array of functions for place holders
    //* </property>
    var $_placeHolderfunctions;
    //* <property name="_page" modifiers="private" 
    //* type="&amp;PageBase">
    //* Reference to page using template
    //* </property>
    var $_page;
    //* <property name="_title" modifiers="private" type="string">
    //* Title of page for display in browser title bar
    //* </property>
    var $_title = "Untitled page";
    //* <property name="_enablePageCaching" modifiers="private" type="bool">
    //* Flag setting page output caching enabled/disabled
    //* </property>
    var $_enablePageCaching = false;
    //* <property name="_enablePageBuffering" modifiers="private" type="bool">
    //* Flag setting page output buffering enabled/disabled.
    //* Buffering must be enabled to enable page caching.
    //* </property>    
    var $_enablePageBuffering = true;
    //* <property name="_pageCache" modifiers="private" type="&amp;PageCache">
    //* PageCache for caching page.
    //* </property>
    var $_pageCache = false;
    //// end private member variables
    
    //// constructors
    //* <constructor modifiers="protected">
    //* Create PageBase object.
    //* </constructor>
    function PageBase()
    {
        $this->_placeHolderfunctions = array();
    }
    //// end constructors
    
    //// public accessors
    //* <method name="get_EncodedTitle" modifiers="public" returnType="string">
    //* Gets HTML encoded page title 
    //* </method>
    function get_EncodedTitle()
    {
       return htmlentities($this->get_Title());
    }
    
    //* <method name="get_Title" modifiers="public" returnType="string">
    //* Gets page title 
    //* </method>
    function get_Title()
    {
        if ($this->_page)
        {
            return $this->_page->get_Title();
        }        
        return $this->_title;
    }
    
    //* <method name="set_Title" modifiers="public" returnType="void">
    //* Sets page title
    //* <parameter name="$title" type="string">
    //* Title of page
    //* </parameter>
    //* </method>
    function set_Title($title)
    {
        if ($this->_page)
        {
            $this->_page->set_Title($title);
        }
        else
        {
            $this->_title = trim($title);
        }
    }
    
    //* <method name="get_Page" modifiers="public" returnType="&amp;PageBase">
    //* Gets page using template 
    //* </method>
    function &get_Page()
    {
        return $this->_page;
    }
    
    //* <method name="set_Page" modifiers="public" returnType="void">
    //* Sets page using template
    //* <parameter name="$page" type="&amp;PageBase">
    //* Page using template
    //* </parameter>
    //* </method>
    function set_Page(&$page)
    {
        $this->_page =& $page;
    }
    
    //* <method name="get_PageUrl" modifiers="public" returnType="string">
    //* Gets the URL of the currently executing page.
    //* </method>
    function get_PageUrl()
    {
        $host = $_SERVER['HTTP_HOST'];
        $page = $this->get_PageName();        
        
        return "http://".$host.$page;
    }
    
    //* <method name="get_PageName" modifiers="public" returnType="string">
    //* Gets the name of the currently executing page.
    //* </method>
    function get_PageName()
    {
        // for some reason $_SERVER['SCRIPT_NAME'] doesn't work right
        return $_SERVER['PHP_SELF'];
    }
    
    //* <method name="set_EnablePageCaching" modifiers="public" returnType="void">
    //* Set flag indicating if page caching is enabled.    
    //* <parameter name="$enabled" type="bool">
    //* Boolean flag
    //* </parameter>
    //* </method>
    function set_EnablePageCaching($enabled)
    {
        $this->_enablePageCaching = $enabled;
    }
    
    //* <method name="get_EnablePageCaching" modifiers="public" returnType="bool">
    //* Get flag indicating if page caching is enabled.
    //* </method>
    function get_EnablePageCaching()
    {
        return $this->_enablePageBuffering && $this->_enablePageCaching;
    }
    
    //* <method name="set_EnablePageBuffering" modifiers="public" returnType="void">
    //* Set flag indicating if page buffering is enabled.    
    //* <parameter name="$enabled" type="bool">
    //* Boolean flag
    //* </parameter>
    //* </method>
    function set_EnablePageBuffering($enabled)
    {
        $this->_enablePageBuffering = $enabled;
    }
    
    //* <method name="get_EnablePageBuffering" modifiers="public" returnType="bool">
    //* Get flag indicating if page buffering is enabled.
    //* </method>
    function get_EnablePageBuffering()
    {
        return $this->_enablePageBuffering;
    }
    
    //* <method name="set_CacheDuration" modifiers="public" returnType="void">
    //* Set duration to cache page.    
    //* <parameter name="$duration" type="int">
    //* Duration to cache page.
    //* </parameter>
    //* </method>
    function set_CacheDuration($duration)
    {
        $pageCache =& $this->_get_PageCache();
        $pageCache->_cacheDuration = $duration;
    }
    
    //* <method name="get_CacheDuration" modifiers="public" returnType="int">
    //* Get duration to cache page
    //* </method>
    function get_CacheDuration()
    {
        $pageCache =& $this->_get_PageCache();
        return $pageCache->set_CacheDuration;
    }
    
    //* <method name="set_CacheParameters" modifiers="public" returnType="void">
    //* Set querysting parameters to vary cache.    
    //* <parameter name="$parameters" type="string">
    //* Querysting parameters to vary cache.
    //* </parameter>
    //* </method>
    function set_CacheParameters($parameters)
    {
        $pageCache =& $this->_get_PageCache();
        $pageCache->set_CacheParameters($parameters);
    }
    
    //* <method name="get_CacheParameters" modifiers="public" returnType="string">
    //* Get querysting parameters to vary cache
    //* </method>
    function get_CacheParameters()
    {
        $pageCache =& $this->_get_PageCache();
        return $pageCache->_cacheParameters;
    }
    //// end public accessors
    
    //// public methods
    //* <method name="RenderPageSection" modifiers="public" returnType="void">
    //* Render specified page section
    //* <parameter name="$pageSectionName" type="string">
    //* Name of page section to render
    //* </parameter>
    //* </method>
    function RenderPageSection($pageSectionName)
    {
        $pageSection =& new $pageSectionName();
        for ($idx=1; $idx<func_num_args(); $idx++)
        {
            $param = func_get_arg($idx);
            $keyValue = split("=",$param);
            if (count($keyValue) > 1)
            {
                $key = $keyValue[0];
                if (count($keyValue) > 2)
                {
                    // value contained 1 or more "=" so need to join value
                    // back together
                    $value = join("=", array_slice($keyValue, 1));
                }
                else
                {
                    $value = $keyValue[1];
                }
                $pageSection->SetProperty(strtolower($key), $value);
            }
        }
        $pageSection->Render();
    }
    
    //* <method name="Render" modifiers="public" returnType="void">
    //* Render page
    //* </method>
    function Render()
    {
        $this->PreRender();
        
        $outputFromCache = false;
        $pageCache = false;
        if ($this->get_EnablePageBuffering())
        {
            ob_start();
        }
        if ($this->get_EnablePageCaching())
        {
            $pageCache = $this->_get_PageCache();
            $contents = $pageCache->GetCachedPage();
            if ($contents)
            {
                echo $contents;
                $outputFromCache = true;
            }
        }
        if (!$outputFromCache)
        {
            $this->DoRender();
            if ($this->get_EnablePageCaching())
            {
                $pageCache = $this->_get_PageCache();
                $pageCache->CachePage();
            }
        }
        if ($this->get_EnablePageBuffering())
        {
            ob_end_flush();
        }
    }
    
    //* <method name="DoRender" modfiers="public" returnType="void">
    //* Do rendering of page
    //* </method>
    function DoRender()
    {
        if ($this->_pageTemplate)
        {
            $this->_pageTemplate->DoRender();       
        }
        $this->RenderContent();
    }
    
    //* <method name="CallFunctionForPlaceHolder" modfiers="public" returnType="void">
    //* Calls function to fill the specified placeholder
    //* <parameter name="$placeHolderName" type="string">
    //* Name of placeholder
    //* </parameter>
    //* </method>
    function CallFunctionForPlaceHolder($placeHolderName)
    {
        if (!in_array($placeHolderName, 
            array_keys($this->_placeHolderfunctions)))
        {
            // recurse down to child
            $this->_RenderPlaceHolder($placeHolderName);
            return;
        }
        $functionName = $this->_placeHolderfunctions[$placeHolderName];
        if ($functionName != "")
        {
            $this->$functionName();
        }
    }
    
    //// abstract public methods
    //* <method name="RenderContent" modifiers="public, abstract" returnType="void">
    //* Render templated content
    //* </method>
    function RenderContent() // abstract
    {
    }
    //// end abstract public methods
    //// end public methods
    
    //// protected accessors
    //* <method name="_set_PageTemplate" modifiers="protected" returnType="void">
    //* Sets page template
    //* <parameter name="$pageTemplate" type="&amp;PageBase">
    //* Template for page
    //* </parameter>
    //* </method>
    function _set_PageTemplate(&$pageTemplate)
    {
        $this->_pageTemplate =& $pageTemplate;
    }
    
    //* <method name="_get_PageTemplate" modifiers="protected" returnType="&amp;PageBase">
    //* Gets page template
    //* </method>
    function &_get_PageTemplate()
    {
        return $this->_pageTemplate;
    }
    
    //* <method name="_get_PageCache" modifiers="protected" returnType="&amp;PageCache">
    //* Gets PageCache
    //* </method>
    function &_get_PageCache()
    {
        if (!$this->_pageCache)
        {
            $this->_pageCache =& new PageCache(
                $this, $this->_get_CacheDirectory());
        }
        return $this->_pageCache;
    }
    
    //* <method name="_get_CacheDirectory" modifiers="protected, abstract" returnType="string">
    //* Get cache directory
    //* </method>
    function _get_CacheDirectory() // abstract
    {
    }
    //// end protected accessors
    
    //// protected methods
    //* <method name="PreRender" modifiers="protected, abstract" returnType="void">
    //*   Execute code required before Render()
    //* </method>
    function PreRender()
    {
    }
    
    //* <method name="_RegisterPlaceHolder" modfiers="protected" returnType="void">
    //* Add function to list of placeholder functions
    //* <parameter name="$placeHolderName" type="string">
    //* Name of placeholder
    //* </parameter>
    //* <parameter name="$placeHolderName" type="string">
    //* Name of function to be called to fill place holder
    //* </parameter>
    //* </method>
    function _RegisterPlaceHolder($placeHolderName, $functionName)
    {
        $this->_placeHolderfunctions[$placeHolderName] = $functionName;
    }
    
    //* <method name="_RenderPlaceHolder" modifiers="protected" returnType="void">
    //* Render the content for the specified placeholder
    //* <parameter name="$name" type="string">
    //* Name of place holder
    //* </parameter>
    //* </method>
    function _RenderPlaceHolder($name)
    {
        if ($this->_page)
        {
            $this->_page->CallFunctionForPlaceHolder($name);
        }
    }
    
    //* <method name="_ConditionalRenderPlaceHolder" modifiers="protected" returnType="void">
    //* Render the content for the specified placeholder if condition is true
    //* <parameter name="$name" type="string">
    //* Name of place holder
    //* </parameter>
    //* <parameter name="$condition" type="bool">
    //* Boolean conditional, only render if true
    //* </parameter>    
    //* </method>
    function _ConditionalRenderPlaceHolder($name, $condition)
    {
        if ($condition)
        {
            $this->_RenderPlaceHolder($name);
        }
    }
    //// end protected methods
}
?>