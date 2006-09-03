<?php
/*
 *************************************************************************
 * PHPPageTemplate: A PHP4 page templating system.                       *
 * Version 0.0.0 (03 September 2006)                                     *
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
 
include_once("PageBase.php");

//* <class name="PageTemplateBase" modifiers="public, abstract">
//* Base class for a web page template
//* </class>
class PageTemplateBase // abstract
{
    //// private members
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
    //// end
    
    //// public accessors
    //* <method name="get_EncodedTitle" modifiers="public"
    //* returnType="string">
    //* Gets HTML encoded page title 
    //* </method>
    function get_EncodedTitle()
    {
       return htmlentities($this->_title);
    }
    
    //* <method name="get_Title" modifiers="public"
    //* returnType="string">
    //* Gets page title 
    //* </method>
    function get_Title()
    {
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
        $this->_title = trim($title);
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
    //// end
    
    //// public methods
    //* <method name="Render" modifiers="public"
    //* returnType="void">
    //* Renders templated page 
    //* </method>
    function Render() 
    {
        $this->Initialise();
        $this->RenderContent();        
    }
    
    //// abstract public methods
    //* <method name="Initialise" modifiers="public, abstract"
    //* returnType="void">
    //* Initialise template
    //* </method>
    function Initialise() // abstract
    {
    }
    
    //* <method name="RenderContent" modifiers="public, abstract"
    //* returnType="void">
    //* Render templated content
    //* </method>
    function RenderContent() // abstract
    {
    }
    //// end
    //// end
    
    //// protected methods
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
            $functionName = $this->_page->GetFunctionForPlaceHolder($name);
            if ($functionName != "")
            {
                $this->_page->$functionName();
            }
        }
    }
    //// end
}
?>