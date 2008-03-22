<?php
/*
 *************************************************************************
 * PHPPageTemplate: A PHP4 page templating system.                       *
 * Version 0.3.0 (11 November 2007)                                      *
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

//* <class name="PageRequest" modifiers="public">
//* Page request class
//* </class>
class PageRequest
{
    //// public methods
    //* <method name="QueryString" modifiers="public" 
    //* returnType="[string=>string]">
    //* Gets querystring parameters as an associative array
    //* </method>
    function &QueryString()
    {
        return $_GET;
    }
    
    //* <method name="QueryStringLC" modifiers="public" 
    //* returnType="[string=>string]">
    //* Gets querystring parameters as an associative array with all keys and
    //* values in lower case
    //* </method>
    function &QueryStringLC()
    {
        $qslc = array();
        foreach (array_keys($_GET) as $key)
        {
            $qslc[strtolower($key)] = strtolower($_GET[$key]);
        }
        return $qslc;
    }
    
    //* <method name="QueryStringLCKeys" modifiers="public" 
    //* returnType="[string=>string]">
    //* Gets querystring parameters as an associative array with all keys in 
    //* lower case
    //* </method>
    function &QueryStringLCKeys()
    {
        $qslc = array();
        foreach (array_keys($_GET) as $key)
        {
            $qslc[strtolower($key)] = $_GET[$key];
        }
        return $qslc;
    }
    
    //* <method name="QueryStringLCValues" modifiers="public" 
    //* returnType="[string=>string]">
    //* Gets querystring parameters as an associative array with all values in 
    //* lower case
    //* </method>
    function &QueryStringLCValues()
    {
        $qslc = array();
        foreach (array_keys($_GET) as $key)
        {
            $qslc[$key] = strtolower($_GET[$key]);
        }
        return $qslc;
    }
    
    //* <method name="QueryStringHash" modifiers="public" 
    //* returnType="[string=>[string=>string]]">
    //* Gets querystring parameters as an associative array with all keys in
    //* lower case.  Array value is an associative array containing original
    //* key (actualKey), value of parameter (value) and 
    //* lower case value (valueLC).
    //* </method>
    function &QueryStringHash()
    {
        $qs = array();
        foreach (array_keys($_GET) as $key)
        {
            $qs[strtolower($key)] = array(
                "actualKey" => $key,
                "value" => $_GET[$key],
                "valueLC" => strtolower($_GET[$key]));
        }
        return $qs;
    }
    
    //* <method name="Cookies" modifiers="public" 
    //* returnType="[string=>string]">
    //* Gets cookies as an associative array
    //* </method>
    function &Cookies()
    {
        return $_COOKIE;
    }
    
    //* <method name="CookiesLC" modifiers="public" 
    //* returnType="[string=>string]">
    //* Gets cookies as an associative array with all keys and
    //* values in lower case
    //* </method>
    function &CookiesLC()
    {
        $clc = array();
        foreach (array_keys($_COOKIE) as $key)
        {
            $clc[strtolower($key)] = strtolower($_COOKIE[$key]);
        }
        return $clc;
    }
    
    //* <method name="CookiesLCKeys" modifiers="public" 
    //* returnType="[string=>string]">
    //* Gets cookies as an associative array with all keys in 
    //* lower case
    //* </method>
    function &CookiesLCKeys()
    {
        $clc = array();
        foreach (array_keys($_COOKIE) as $key)
        {
            $clc[strtolower($key)] = $_COOKIE[$key];
        }
        return $clc;
    }
    
    //* <method name="CookiesLCValues" modifiers="public" 
    //* returnType="[string=>string]">
    //* Gets cookies as an associative array with all values in 
    //* lower case
    //* </method>
    function &CookiesLCValues()
    {
        $clc = array();
        foreach (array_keys($_COOKIE) as $key)
        {
            $clc[$key] = strtolower($_COOKIE[$key]);
        }
        return $clc;
    }
    
    //* <method name="CookiesHash" modifiers="public" 
    //* returnType="[string=>[string=>string]]">
    //* Gets cookies as an associative array with all keys in
    //* lower case.  Array value is an associative array containing original
    //* key (actualKey), value of parameter (value) and 
    //* lower case value (valueLC).
    //* </method>
    function &CookiesHash()
    {
        $cookies = array();
        foreach (array_keys($_COOKIE) as $key)
        {
            $cookies[strtolower($key)] = array(
                "actualKey" => $key,
                "value" => $_COOKIE[$key],
                "valueLC" => strtolower($_COOKIE[$key]));
        }
        return $cookies;
    }    
    //// end public methods
}
