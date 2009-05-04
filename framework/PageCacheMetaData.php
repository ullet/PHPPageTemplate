<?php
/*
 ***************************************************************************************************
 * PHPPageTemplate: A PHP page templating system.                                                  *
 * Version 0.4 (04 May 2009)                                                                       *
 * Copyright (C) 2009 Trevor Barnett                                                               *
 *                                                                                                 *
 * This file is part of PHPPageTemplate.                                                           *                                                      *
 *                                                                                                 *
 * PHPPageTemplate is free software: you can redistribute it and/or modify it under the terms of   *
 * the GNU General Public License as published by the Free Software Foundation, either version 3   *
 * of the License, or (at your option) any later version.                                          *
 *                                                                                                 *
 * PHPPageTemplate is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;    *
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See  *
 * the GNU General Public License for more details.                                                *                          *
 *                                                                                                 *
 * You should have received a copy of the GNU General Public License along with PHPPageTemplate.   *
 * If not, see <http://www.gnu.org/licenses/>.                                                     *
 ***************************************************************************************************
 */

//* <class name="PageCacheMetaData" modifiers="public">
//* Class to hold meta data for a cached page
//* </class>
class PageCacheMetaData
{
    //// private member variables
    //* <property name="_pageName" modifiers="private" type="string">
    //* Name of page.
    //* </property>
    private $_pageName = "";
    //* <property name="_expiration" modifiers="private" type="int">
    //* Time of page expiration.
    //* </property>
    private $_expiration = 0;
    //* <property name="_parameterValues" modifiers="private" 
    //* type="string[string]">
    //* Hash array of parameters.
    //* </property>    
    private $_parameterValues = false;
    //* <property name="_cacheFilePath" modifiers="private" type="string">
    //* Path of cache file.
    //* </property>
    private $_cacheFilePath = "";    
    //// end private member variables
    
    //// public accessor methods
    //* <method name="set_PageName" modifiers="public" 
    //* returnType="void">
    //* Set name of page.
    //* <parameter name="$pageName" type="string">
    //* Name of page.
    //* </parameter>
    //* </method>
    public function set_PageName($pageName)
    {
        $this->_pageName = $pageName;
    }
    
    //* <method name="get_PageName" modifiers="public"
    //* returnType="string">
    //* Gets name of page. 
    //* </method>
    public function get_PageName()
    {
        return $this->_pageName;
    }
    
    //* <method name="set_PageName" modifiers="public" 
    //* returnType="void">
    //* Set expiration time of page.
    //* <parameter name="$expiration" type="int">
    //* Expiration time of page.
    //* </parameter>
    //* </method>
    public function set_Expiration($expiration)
    {
        $this->_expiration = $expiration;
    }
    
    //* <method name="get_Expiration" modifiers="public"
    //* returnType="int">
    //* Gets expiration time of page. 
    //* </method>
    public function get_Expiration()
    {
        return $this->_expiration;
    }
    
    //* <method name="set_CacheFilePath" modifiers="public" 
    //* returnType="void">
    //* Set cache file path.
    //* <parameter name="$cacheFilePath" type="int">
    //* Cache file path.
    //* </parameter>
    //* </method>
    public function set_CacheFilePath($cacheFilePath)
    {
        $this->_cacheFilePath = $cacheFilePath;
    }
    
    //* <method name="get_CacheFilePath" modifiers="public"
    //* returnType="string">
    //* Gets cache file path. 
    //* </method>
    public function get_CacheFilePath()
    {
        return $this->_cacheFilePath;
    }
    
    //* <method name="set_Parameters" modifiers="public" 
    //* returnType="void">
    //* Set parameters hash array.
    //* <parameter name="$parameters" type="string[string]">
    //* Parameters hash array.
    //* </parameter>
    //* </method>
    public function set_Parameters($parameters)
    {
        $this->_parameterValues = $parameters;
    }    
    
    //* <method name="get_Parameters" modifiers="public"
    //* returnType="string[string]">
    //* Gets parameters hash array. 
    //* </method>
    public function get_Parameters()
    {
        return $this->_parameterValues;        
    }
}
?>
