<?php
/*
 *************************************************************************
 * PHPPageTemplate: A PHP4 page templating system.                       *
 * Version 0.1.0 (13 January 2007)                                       *
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

//* <class name="PageSectionBase" modifiers="public, abstract">
//* Base class for a web page section
//* </class>
class PageSectionBase
{    
    //// public methods
    //* <method name="Render" modifiers="public" 
    //* returnType="void">
    //* Render page section
    //* </method>
    function Render()
    {
    }
    
    //* <method name="SetProperty" modfiers="public, abstract" 
    //* returnType="void">
    //* Set specified property of page section
    //* <parameter name="$key" type="string">
    //* Name of property
    //* </parameter>
    //* <parameter name="$name" type="string">
    //* Value of property
    //* </parameter>
    //* </method>
    function SetProperty($name, $value) // abstract
    {
    }
    //// end public methods
    
    //// protected methods
    //* <method name="_ConvertStringToBool" modfiers="protected" 
    //* returnType="string">
    //* Convert a string value to a boolean.
    //* <parameter name="$value" type="bool">
    //* Value to convert
    //* </parameter>
    //* </method>
    function _ConvertStringToBool($value)
    {
        return ($value=="true" || $value=="on" || $value=="yes" || $value=="1");
    }
    //// end protected methods
}