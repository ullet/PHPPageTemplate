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

//* <class name="PageSectionBase" modifiers="public, abstract">
//* Base class for a web page section
//* </class>
abstract class PageSectionBase
{    
    //// private member variables
    //* <property name="_page" modifiers="private" type="&amp;PageBase">
    //* Parent page
    //* </property>
    private $_page;
    //// end private member variables
    
    //// protected accessors
    //* <method name="set_Page" modifiers="protected" returnType="void">
    //* Sets parent page object
    //* <parameter name="$page" type="&amp;PageBase">
    //* Parent page object
    //* </parameter>
    //* </method>
    public function set_Page(PageBase $page)
    {
        $this->_page = $page;
    }
    
    //* <method name="get_Page" modifiers="protected" returnType="&amp;PageBase">
    //* Gets the parent page object 
    //* </method>
    public function get_Page()
    {
        return $this->_page;
    }
    //// end protected accessors
    
    //// public methods
    //* <method name="Render" modifiers="public" returnType="void">
    //* Render page section
    //* </method>
    public function Render()
    {
    }
    
    //* <method name="SetProperty" modifiers="public, abstract" returnType="void">
    //* Set specified property of page section
    //* <parameter name="$key" type="string">
    //* Name of property
    //* </parameter>
    //* <parameter name="$name" type="string">
    //* Value of property
    //* </parameter>
    //* </method>
    public abstract function SetProperty($name, $value);
    //// end public methods
    
    //// protected methods
    //* <method name="_ConvertStringToBool" modifiers="protected" returnType="string">
    //* Convert a string value to a boolean.
    //* <parameter name="$value" type="bool">
    //* Value to convert
    //* </parameter>
    //* </method>
    protected function _ConvertStringToBool($value)
    {
        return ($value=="true" || $value=="on" || $value=="yes" || $value=="1");
    }
    
    //// public methods
    //* <method name="RenderPageSection" modifiers="public" returnType="void">
    //* Render a child page section
    //* </method>
    protected function RenderPageSection($pageSectionName)
    {
        // delegate rendering to parent page.
        $args = func_get_args();
        for ($idx=1; $idx<func_num_args(); $idx++)
        {
            $param = $args[$idx];
        }
        $this->_page->RenderPageSection($pageSectionName, $args);
    }
    //// end protected methods
}
