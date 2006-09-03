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

include_once("PageTemplateBase.php");

//* <class name="PageBase" modifiers="public, abstract">
//* Base class for a web page based on a template
//* </class>
class PageBase // abstract
{
    //// private member variables
    //* <property name="_pageTemplate" modifiers="private" 
    //* type="&PageTemplateBase">
    //* Template for Page
    //* </property>
    var $_pageTemplate;   
    //* <property name="_placeHolderfunctions" modifiers="private"
    //* type="[Associative Array]">
    //* Array of functions for place holders
    //* </property>
    var $_placeHolderfunctions;
    //** end
    
    //// protected accessors
    //* <method name="_set_PageTemplate" modifiers="protected"
    //* returnType="void">
    //* Sets page template
    //* <parameter name="$pageTemplate" type="&PageTemplateBase">
    //* Template for page
    //* </parameter>
    //* </method>
    function _set_PageTemplate(&$pageTemplate)
    {
        $this->_pageTemplate =& $pageTemplate;
    }
    //// end
    
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
    
    //* <method name="_Initialise" modfiers="protected" 
    //* returnType="void">
    //* Initialise page
    //* </method>
    function _Initialise()
    {
        $this->_placeHolderfunctions = array();
    }
    //// end
    
    //// public methods
    //* <method name="Render" modfiers="public" 
    //* returnType="void">
    //* Render page
    //* </method>
    function Render()
    {
        $this->_Initialise();
        $this->_pageTemplate->Render();       
    }
    
    //* <method name="GetFunctionForPlaceHolder" modfiers="public" 
    //* returnType="string">
    //* Gets function to be called to fill the specified placeholder
    //* <parameter name="$placeHolderName" type="string">
    //* Name of placeholder
    //* </parameter>
    //* </method>
    function GetFunctionForPlaceHolder($placeHolderName)
    {
        if (!in_array($placeHolderName, 
            array_keys($this->_placeHolderfunctions)))
        {
            return "";
        }
        return $this->_placeHolderfunctions[$placeHolderName];
    }
    //// end
}
?>