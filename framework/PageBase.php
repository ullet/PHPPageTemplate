<?php
/*
 *************************************************************************
 * PHPPageTemplate: A PHP page templating system.                        *
 * Version 0.3.1 (05 May 2008)                                           *
 * Copyright (C) 2006-2008 Trevor Barnett                                *
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

require_once dirname(__FILE__)."/PageCache.php";
require_once dirname(__FILE__)."/Theme.php";

//* <class name="PageBase" modifiers="public, abstract">
//* Base class for a web page based on a template and a template page
//* </class>
// NB. A template page is just a page with place holders.
abstract class PageBase
{
    //// private member variables
    //* <property name="_pageTemplate" modifiers="private" type="&amp;PageBase">
    //* Template for Page
    //* </property>
    private $_pageTemplate;   
    //* <property name="_placeHolderfunctions" modifiers="private" type="[string,string]">
    //* Array of functions for place holders
    //* </property>
    private $_placeHolderfunctions;
    //* <property name="_page" modifiers="private" 
    //* type="&amp;PageBase">
    //* Reference to page using template
    //* </property>
    private $_page;
    //* <property name="_title" modifiers="private" type="string">
    //* Title of page for display in browser title bar
    //* </property>
    private $_title = "Untitled page";
    //* <property name="_enablePageCaching" modifiers="private" type="bool">
    //* Flag setting page output caching enabled/disabled
    //* </property>
    private $_enablePageCaching = false;
    //* <property name="_enablePageBuffering" modifiers="private" type="bool">
    //* Flag setting page output buffering enabled/disabled.
    //* Buffering must be enabled to enable page caching.
    //* </property>    
    private $_enablePageBuffering = true;
    //* <property name="_pageCache" modifiers="private" type="&amp;PageCache">
    //* PageCache for caching page.
    //* </property>
    private $_pageCache = false;
    //* <property name="_pageSections" modifiers="private" 
    //* type="[string,PageSectionBase]">
    //* Array of PageSections
    //* </property>
    private $_pageSections;
    //* <property name="_theme" modifiers="private" type="&amp;Theme">
    //* Page theme
    //* </property>    
    private $_theme = false;
    //* <property name="_themeList" modifiers="private" type="&amp;ThemeList">
    //* List of page themes
    //* </property>    
    private $_themeList = false;
    //* <property name="_themeListPath" modifiers="private" type="string">
    //* Path of XML document defining themes
    //* </property>    
    private $_themeListPath = false;
    //* <property name="_defaultThemeName" modifiers="private" type="string">
    //* Name of default theme
    //* </property>    
    private $_defaultThemeName = false;
    //// end private member variables
    
    //// constructors
    //* <constructor modifiers="protected">
    //* Create PageBase object.
    //* </constructor>
    public function __construct()
    {
        $this->_placeHolderfunctions = array();
    }
    //// end constructors
    
    //// public accessors
    //* <method name="get_EncodedTitle" modifiers="public" returnType="string">
    //* Gets HTML encoded page title 
    //* </method>
    public function get_EncodedTitle()
    {
       return htmlentities($this->get_Title());
    }
    
    //* <method name="get_Title" modifiers="public" returnType="string">
    //* Gets page title 
    //* </method>
    public function get_Title()
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
    public function set_Title($title)
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
    //* Gets page using template.
    //* <remarks>
    //* Template needs to know the page using it so that can call place-holder methods defined on
    //* the page, place-holders being one of the key benefits of a template.
    //* </method>
    public function get_Page()
    {
        return $this->_page;
    }
    
    //* <method name="set_Page" modifiers="public" returnType="void">
    //* Sets page or template using template.
    //* <parameter name="$page" type="&amp;PageBase">
    //* Page or template using template.
    //* </parameter>
    //* <remarks>
    //* Templates can be nested to reuse common functionality/layout. The 'parent' template is
    //* set, a little unintuitively, using set_Page.
    //* </remarks>
    //* </method>
    public function set_Page(PageBase $page)
    {
        $this->_page = $page;
    }
    
    //* <method name="get_PageUrl" modifiers="public" returnType="string">
    //* Gets the URL of the currently executing page.
    //* </method>
    public function get_PageUrl()
    {
        $host = $_SERVER['HTTP_HOST'];
        $page = $this->get_PageName();        
        
        return "http://".$host.$page;
    }
    
    //* <method name="get_PageName" modifiers="public" returnType="string">
    //* Gets the name of the currently executing page.
    //* </method>
    public function get_PageName()
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
    public function set_EnablePageCaching($enabled)
    {
        $this->_enablePageCaching = $enabled;
    }
    
    //* <method name="get_EnablePageCaching" modifiers="public" returnType="bool">
    //* Get flag indicating if page caching is enabled.
    //* </method>
    public function get_EnablePageCaching()
    {
        return $this->_enablePageBuffering && $this->_enablePageCaching;
    }
    
    //* <method name="set_EnablePageBuffering" modifiers="public" returnType="void">
    //* Set flag indicating if page buffering is enabled.    
    //* <parameter name="$enabled" type="bool">
    //* Boolean flag
    //* </parameter>
    //* </method>
    public function set_EnablePageBuffering($enabled)
    {
        $this->_enablePageBuffering = $enabled;
    }
    
    //* <method name="get_EnablePageBuffering" modifiers="public" returnType="bool">
    //* Get flag indicating if page buffering is enabled.
    //* </method>
    public function get_EnablePageBuffering()
    {
        return $this->_enablePageBuffering;
    }
    
    //* <method name="set_CacheDuration" modifiers="public" returnType="void">
    //* Set duration to cache page.    
    //* <parameter name="$duration" type="int">
    //* Duration to cache page.
    //* </parameter>
    //* </method>
    public function set_CacheDuration($duration)
    {
        $pageCache = $this->_get_PageCache();
        $pageCache->_cacheDuration = $duration;
    }
    
    //* <method name="get_CacheDuration" modifiers="public" returnType="int">
    //* Get duration to cache page
    //* </method>
    public function get_CacheDuration()
    {
        $pageCache = $this->_get_PageCache();
        return $pageCache->set_CacheDuration;
    }
    
    //* <method name="set_CacheParameters" modifiers="public" returnType="void">
    //* Set querysting parameters to vary cache.    
    //* <parameter name="$parameters" type="string">
    //* Querysting parameters to vary cache.
    //* </parameter>
    //* </method>
    public function set_CacheParameters($parameters)
    {
        $pageCache = $this->_get_PageCache();
        $pageCache->set_CacheParameters($parameters);
    }
    
    //* <method name="get_CacheParameters" modifiers="public" returnType="string">
    //* Get querysting parameters to vary cache
    //* </method>
    public function get_CacheParameters()
    {
        $pageCache = $this->_get_PageCache();
        return $pageCache->_cacheParameters;
    }
    
    //* <method name="set_CaseInsensitiveCacheParameters" modifiers="public" 
    //* returnType="void">
    //* Set flag indicating if cache parameters should be case insensitive.
    //* <parameter name="$value" type="boolean">
    //* Boolean.
    //* </parameter>
    //* </method>    
    public function set_CaseInsensitiveCacheParameters($value)
    {
        $pageCache = $this->_get_PageCache();
        $pageCache->set_CaseInsensitiveCacheParameters($value);
    }    
    
    //* <method name="set_CaseInsensitiveCacheParameterKeys" 
    //* modifiers="public" returnType="void">
    //* Set flag indicating if cache parameter keys should be case insensitive.
    //* <parameter name="$value" type="boolean">
    //* Boolean.
    //* </parameter>
    //* </method>    
    public function set_CaseInsensitiveCacheParameterKeys($value)
    {
        $pageCache = $this->_get_PageCache();
        $pageCache->set_CaseInsensitiveCacheParameterKeys($value);
    }   
    
    //* <method name="set_CaseInsensitiveCacheParameterValues" 
    //* modifiers="public" returnType="void">
    //* Set flag indicating if cache parameter values should be case
    //* insensitive.
    //* <parameter name="$value" type="boolean">
    //* Boolean.
    //* </parameter>
    //* </method>    
    public function set_CaseInsensitiveCacheParameterValues($value)
    {
        $pageCache = $this->_get_PageCache();
        $pageCache->set_CaseInsensitiveCacheParameterValues($value);
    }   
    
    public function get_Theme()
    {
        if (!$this->_theme)
        {
            $themeList = $this->get_ThemeList();
            if ($themeList)
            {
                $this->_theme = $themeList->get_SelectedTheme();
            }
        }
        return $this->_theme;
    }
    
    public function set_Theme($theme)
    {
        $this->_theme = $theme;
    }
    
    public function get_ThemeList()
    {
        if (!$this->_themeList && $this->get_ThemeListPath())
        {
            $this->_themeList = new ThemeList(
                $this->get_ThemeListPath(), $this->get_DefaultThemeName());
        }
        return $this->_themeList;
    }
    
    public function set_ThemeList(ThemeList $themeList)
    {
        $this->_themeList = $themeList;
    }
    
    public function set_ThemeListPath($path)
    {
        $this->_themeListPath = $path;
    }
    
    public function get_ThemeListPath()
    {
        return $this->_themeListPath;
    }
    
    public function set_DefaultThemeName($name)
    {
        $this->_defaultThemeName = $name;
    }
    
    public function get_DefaultThemeName()
    {
        return $this->_defaultThemeName;
    }
    //// end public accessors
        
    //// public methods
    //* <method name="RenderPageSection" modifiers="public" returnType="void">
    //* Render specified page section.
    //* <parameter name="$pageSectionName" type="string">
    //* Name of page section to render.
    //* </parameter>
    //* <remarks>
    //* Page Sections are re-usable parameterisable code modules.
    //* </remarks>
    //* </method>
    public function RenderPageSection($pageSectionName)
    {
        $pageSection = new $pageSectionName();
        $pageSection->set_Page($this);
        $this->_pageSections[$pageSectionName] = $pageSection;
        $args = func_get_args();
        $this->_ProcessPageSectionProperties($pageSection, $args);
        $this->PreRenderPageSection($pageSectionName);
        $pageSection->Render();
        $this->PostRenderPageSection($pageSectionName);
    }
    
    public function SetSelectedThemeCookie()
    {
        //if ($this->get_ThemesEnabled() && $this->get_UseCookies())
        //{
            $themeList = $this->get_ThemeList();
            if ($themeList)
            {
                $themeList->SetSelectedThemeCookie();
            }
        //}
    }
    
    public function _ProcessPageSectionProperties(PageSection $pageSection, $args)
    {
        foreach ($args as $param)
        {
            if (is_array($param))
            {
                $this->_ProcessPageSectionProperties($pageSection, $param);                
            }
            else
            {
                $this->_ProcessPageSectionProperty($pageSection, $param);
            }
        }
    }
    
    public function _ProcessPageSectionProperty(PageSection $pageSection, $param)
    {
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
    
    //* <method name="Render" modifiers="public" returnType="void">
    //* Render the page.
    //* <remarks>
    //* Rendering is broken down into four steps, each of which can be controlled via overridden
    //* methods in the derived class.
    //*     PreRender           - Executed first and always executed.
    //*     RenderContent       - Main page rendering, will not be executed if page is already 
    //*                           cached. RenderContent methods of all parent templates will be
    //*                           called before the page method, starting with the 'oldest' 
    //*                           ancestor.
    //*     DoPostProcessOutput - Executed after DoRender or after page retreived from cache.
    //*                           Always executed providing page buffering is enable (default).
    //*                           Can be useful, for example, for "post cache substitution", i.e.
    //*                           replace place holder tokens with 'personal' information that
    //*                           shouldn't be cached.
    //*     PostRender          - Executed last and always executed.
    //* The above are the recommended methods to override in derived classes but other methods can
    //* be overridden to give more control albeit at risk of breaking the rendering model (e.g. can
    //* override DoRender to prevent template RenderContent methods being executed.)
    //* </remarks>
    //* </method>
    public function Render()
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
            $this->PostProcessOutput();
            ob_end_flush();
        }
        
        $this->PostRender();
    }
    
    //* <method name="PostProcessOutput" modifiers="public" returnType="void">
    //* Post-process output before final output is rendered to browser
    //* </method>
    public function PostProcessOutput()
    {
        if ($this->get_EnablePageBuffering())
        {
            $output = $this->DoPostProcessOutput(ob_get_contents());
            // if $output false then no need to do anything as content already in buffer,
            // if not false then need to clear buffer and output new content.
            if ($output)
            {
                ob_clean();
                echo $output;
            }
        }
    }
    
    //* <method name="DoPostProcessOutput" modifiers="public"
    //* returnType="[string,boolean]">
    //* Post-process output before final output is rendered to browser
    //* <remarks>
    //* If no processing performed should return false, otherwise should return processed string. 
    //* Returning original content instead of false will still render correct content but will
    //* hinder performance as buffer will be cleared just to re-output exactly the same content.
    //* </remarks>
    //* </method>
    public function DoPostProcessOutput($output)
    {
        //if ($this->get_ThemesEnabled())
        //{
            return $this->SetThemeParameterPostProcessOutput($output);
        //}
    }
    
    public function SetThemeParameterPostProcessOutput($output)
    {
        if ("" == $output)
        {
            return false;
        }
        
        $themeList = $this->get_ThemeList();
        
        if (!$themeList)
        {
            return false;
        }
        
        if (!$themeList->get_ThemeExplicitlySelected())
        {
            return false;
        }
        
        if ($themeList->get_ThemeInCookie())
        {
            return false;
        }
        
        $theme = $this->get_Theme();
                            
        $procOutput = $output;
        if (preg_match_all('/(<a\s+(?:.*?\s+)?href\s*=\s*\"[^\"#]*)([\"#])/i', $procOutput, $matches))
        {
            $mindex = 0;
            foreach ($matches[1] as $match)
            {
                $string = $match.$matches[2][$mindex];

                if (!preg_match('/^(.*?href\s*=\s*\".*?theme=).*?((?:\?|&(?:amp;)?)?.*?)$/i', $match, $parts))
                {
                    if (preg_match('/href\s*=\s*\".*?\?/i', $match))
                    {
                        $replacement = $match."&amp;";
                    }
                    else
                    {
                        $replacement = $match."?";
                    }
                    $replacement .= "theme=" .
                        $theme->get_Name();
                    $replacement .= $matches[2][$mindex];
                
                    if (!preg_match('/<a\s+(?:.*?\s+)?href\s*=\s*\"\s*[hf]tt?p/i', $match))
                    {
                       $procOutput = str_replace($string, $replacement, $procOutput);
                    }
                }
                $mindex++;
            }
        }
        return $procOutput;
    }
    
    //* <method name="DoRender" modifiers="public" returnType="void">
    //* Do rendering of page. Calls DoRender() on all templates first, starting from the 'top'.
    //* </method>
    public function DoRender()
    {
        if ($this->_pageTemplate)
        {
            $this->_pageTemplate->DoRender();       
        }
        $this->RenderContent();
    }
    
    //* <method name="CallFunctionForPlaceHolder" modifiers="public" returnType="void">
    //* Calls function to fill the specified placeholder
    //* <parameter name="$placeHolderName" type="string">
    //* Name of placeholder
    //* </parameter>
    //* </method>
    public function CallFunctionForPlaceHolder($placeHolderName)
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
    
    //* <method name="RenderContent" modifiers="public" returnType="void">
    //* Render templated content. Should be overridden in the derived class to render page content.
    //* </method>
    public function RenderContent()
    {
    }
    
    //// protected accessors
    //* <method name="_set_PageTemplate" modifiers="protected" returnType="void">
    //* Sets page template
    //* <parameter name="$pageTemplate" type="&amp;PageBase">
    //* Template for page
    //* </parameter>
    //* </method>
    protected function _set_PageTemplate(PageBase $pageTemplate)
    {
        $this->_pageTemplate = $pageTemplate;
    }
    
    //* <method name="_get_PageTemplate" modifiers="protected" returnType="&amp;PageBase">
    //* Gets page template
    //* </method>
    protected function _get_PageTemplate()
    {
        return $this->_pageTemplate;
    }
    
    //* <method name="_get_PageCache" modifiers="protected" returnType="&amp;PageCache">
    //* Gets PageCache
    //* </method>
    protected function _get_PageCache()
    {
        if (!$this->_pageCache)
        {
            $this->_pageCache = new PageCache(
                $this, $this->_get_CacheDirectory());
        }
        return $this->_pageCache;
    }
    
    //* <method name="_get_CacheDirectory" modifiers="protected" returnType="string">
    //* Get cache directory.
    //* </method>
    //* <remarks>
    //* Default of empty string will cause current directory to be used as cache directory, which
    //* probably will work but not very tidy.
    //* </remarks>
    protected function _get_CacheDirectory()
    {
        return "";
    }
    //// end protected accessors
    
    //// protected methods
    //* <method name="PreRender" modifiers="protected" returnType="void">
    //* Execute code required before Render().  Will always be called even if page is cached.
    //* </method>
    protected function PreRender()
    {
    }
    
    //* <method name="PostRender" modifiers="protected" returnType="void">
    //* Execute code required after Render(). Will always be called even if page is cached.
    //* </method>
    protected function PostRender()
    {
    }
    
    //* <method name="PreRenderPageSection" modifiers="protected" returnType="void">
    //* Execute code required before RenderPageSection(). Will always be called even if page is 
    //* cached.
    //* </method>
    protected function PreRenderPageSection($pageSectionName)
    {
    }
    
    //* <method name="PostRenderPageSection" modifiers="protected" returnType="void">
    //* Execute code required after RenderPageSection().
    //* </method>
    protected function PostRenderPageSection($pageSectionName)
    {
    }
    
    //* <method name="PageSectionFromName" modifiers="protected" returnType="object">
    //* Get PageSection object for specified name.
    //* </method>
    protected function PageSectionFromName($pageSectionName)
    {
        return $this->_pageSections[$pageSectionName];
    }
    
    //* <method name="_RegisterPlaceHolder" modifiers="protected" returnType="void">
    //* Add function to list of placeholder functions
    //* <parameter name="$placeHolderName" type="string">
    //* Name of placeholder
    //* </parameter>
    //* <parameter name="$placeHolderName" type="string">
    //* Name of function to be called to fill place holder
    //* </parameter>
    //* </method>
    protected function _RegisterPlaceHolder($placeHolderName, $functionName)
    {
        $this->_placeHolderfunctions[$placeHolderName] = $functionName;
    }
    
    //* <method name="_RenderPlaceHolder" modifiers="protected" returnType="void">
    //* Render the content for the specified placeholder
    //* <parameter name="$name" type="string">
    //* Name of place holder
    //* </parameter>
    //* </method>
    protected function _RenderPlaceHolder($name)
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
    protected function _ConditionalRenderPlaceHolder($name, $condition)
    {
        if ($condition)
        {
            $this->_RenderPlaceHolder($name);
        }
    }
    //// end protected methods
}
?>
