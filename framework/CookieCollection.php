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

//* <class name="CookieCollection" modifiers="public">
//* CookieCollection class
//* </class>
class CookieCollection
{
    public function SetCookie($name, $value, $duration, $path="", $domain="", $secure=0)
    {
        setcookie($name, $value, $this->CurrentTime() + $duration, $path, $domain, $secure);
    }
        
    //* <method name="Cookies" modifiers="public" 
    //* returnType="[string=>string]">
    //* Gets cookies as an associative array
    //* </method>
    public function Cookies()
    {
        return $_COOKIE;
    }
    
    //* <method name="CookiesLC" modifiers="public" 
    //* returnType="[string=>string]">
    //* Gets cookies as an associative array with all keys and
    //* values in lower case
    //* </method>
    public function CookiesLC()
    {
        $cookies = $this->Cookies();
        $clc = array();
        foreach (array_keys($cookies) as $key)
        {
            $clc[strtolower($key)] = strtolower($cookies[$key]);
        }
        return $clc;
    }
    
    //* <method name="CookiesLCKeys" modifiers="public" 
    //* returnType="[string=>string]">
    //* Gets cookies as an associative array with all keys in 
    //* lower case
    //* </method>
    public function CookiesLCKeys()
    {
        $cookies = $this->Cookies();
        $clc = array();
        foreach (array_keys($cookies) as $key)
        {
            $clc[strtolower($key)] = $cookies[$key];
        }
        return $clc;
    }
    
    //* <method name="CookiesLCValues" modifiers="public" 
    //* returnType="[string=>string]">
    //* Gets cookies as an associative array with all values in 
    //* lower case
    //* </method>
    public function CookiesLCValues()
    {
        $cookies = $this->Cookies();
        $clc = array();
        foreach (array_keys($cookies) as $key)
        {
            $clc[$key] = strtolower($cookies[$key]);
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
    public function CookiesHash()
    {
        $cookies = $this->Cookies();
        $cookiesHash = array();
        foreach (array_keys($cookies) as $key)
        {
            $cookiesHash[strtolower($key)] = array(
                "actualKey" => $key,
                "value" => $cookies[$key],
                "valueLC" => strtolower($cookies[$key]));
        }
        return $cookiesHash;
    } 
    
    protected function CurrentTime()
    {
        // this method exist purely to make testing easier, can override
        // this method to ensure fixed time to test against
        return time();
    }
}
