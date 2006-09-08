<?php
/*
 *************************************************************************
 * PHPPageTemplate: A PHP4 page templating system.                       *
 * Version 0.0.1 (08 September 2006)                                     *
 * Copyright (C) 2006 Trevor Barnett                                     *
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

//* <class name="PageBase" modifiers="public, abstract">
//* Base class for a web page based on a template and a template page
//* </class>
// NB. A template page is just a page with place holders.
class PageBase
{
    //// private member variables
    //* <property name="_pageTemplate" modifiers="private" 
    //* type="&PageBase">
    //* Template for Page
    //* </property>
    var $_pageTemplate;   
    //* <property name="_placeHolderfunctions" modifiers="private"
    //* type="[Associative Array]">
    //* Array of functions for place holders
    //* </property>
    var $_placeHolderfunctions;
    //* <property name="_page" modifiers="private" 
    //* type="&PageBase">
    //* Reference to page using template
    //* </property>
    var $_page;
    //* <property name="_title" modifiers="private" 
    //* type="string">
    //* Title of page for display in browser title bar
    //* </property>
    var $_title = "Untitled page";    
    //// end private member variables
    
    function PageBase()
    {
        $this->_placeHolderfunctions = array();
    }
    
    //// protected accessors
    //* <method name="_set_PageTemplate" modifiers="protected"
    //* returnType="void">
    //* Sets page template
    //* <parameter name="$pageTemplate" type="&PageBase">
    //* Template for page
    //* </parameter>
    //* </method>
    function _set_PageTemplate(&$pageTemplate)
    {
        $this->_pageTemplate =& $pageTemplate;
    }
    
    //* <method name="_get_PageTemplate" modifiers="protected"
    //* returnType="&PageBase">
    //* Gets page template
    //* </method>
    function &_get_PageTemplate()
    {
        return $this->_pageTemplate;
    }
    //// end protected accessors
    
    //// public accessors
    //* <method name="get_EncodedTitle" modifiers="public"
    //* returnType="string">
    //* Gets HTML encoded page title 
    //* </method>
    function get_EncodedTitle()
    {
       return htmlentities($this->get_Title());
    }
    
    //* <method name="get_Title" modifiers="public"
    //* returnType="string">
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
    
    //* <method name="set_Title" modifiers="public"
    //* returnType="void">
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
    
    //* <method name="get_Page" modifiers="public"
    //* returnType="&PageBase">
    //* Gets page using template 
    //* </method>
    function &get_Page()
    {
        return $this->_page;
    }
    
    //* <method name="set_Page" modifiers="public"
    //* returnType="void">
    //* Sets page using template
    //* <parameter name="$page" type="&PageBase">
    //* Page using template
    //* </parameter>
    //* </method>
    function set_Page(&$page)
    {
        $this->_page =& $page;
    }
    
    //* <method name="get_PageUrl" modifiers="public"
    //* returnType="string">
    //* Gets the URL of the currently executing page.
    //* </method>
    function get_PageUrl()
    {
        $host = $_SERVER['HTTP_HOST'];
        $page = $_SERVER['PHP_SELF']; 
        // for some reason $_SERVER['SCRIPT_NAME'] doesn't work right
        
        return "http://".$host.$page;
    }
    //// end public accessors
    
    //// protected methods
    //* <method name="_RegisterPlaceHolder" modfiers="protected" 
    //* returnType="void">
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
    
    //* <method name="_RenderPlaceHolder" modifiers="protected"
    //* returnType="void">
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
    
    //* <method name="_ConditionalRenderPlaceHolder" modifiers="protected"
    //* returnType="void">
    //* Render the content for the specified placeholder if condition is true
    //* <parameter name="$name" type="string">
    //* Name of place holder
    //* </parameter>
    //* <parameter name="$condition" type="boolean">
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
    
    //// public methods
    //* <method name="Render" modfiers="public" 
    //* returnType="void">
    //* Render page
    //* </method>
    function Render()
    {
        if ($this->_pageTemplate)
        {
            $this->_pageTemplate->Render();       
        }
        $this->RenderContent();
    }
    
    //* <method name="CallFunctionForPlaceHolder" modfiers="public" 
    //* returnType="void">
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
    //* <method name="RenderContent" modifiers="public, abstract"
    //* returnType="void">
    //* Render templated content
    //* </method>
    function RenderContent() // abstract
    {
    }
    //// end abstract public methods
    //// end public methods
}
?>