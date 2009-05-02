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

require_once dirname(__FILE__)."/CookieCollection.php";
require_once dirname(__FILE__)."/QueryStringCollection.php";
 
//* <class name="PageRequest" modifiers="public">
//* Page request class
//* </class>
class HttpPageRequest implements PageRequest
{
    private $cookieCollection = false;
    private $queryStringCollection = false;
    
    //// public methods
    public function get_CookieCollection()
    {
        if (!$this->cookieCollection)
        {
            $this->cookieCollection = new CookieCollection();
        }
        return $this->cookieCollection;
    }    
    
    public function get_QueryStringCollection()
    {
        if (!$this->queryStringCollection)
        {
            $this->queryStringCollection = new QueryStringCollection();
        }
        return $this->queryStringCollection;
    }
    
    //* <method name="QueryString" modifiers="public" 
    //* returnType="[string=>string]">
    //* Gets querystring parameters as an associative array
    //* </method>
    public function QueryString()
    {
        return $this->get_QueryStringCollection()->QueryString();
    }
    
    //* <method name="QueryStringLC" modifiers="public" 
    //* returnType="[string=>string]">
    //* Gets querystring parameters as an associative array with all keys and
    //* values in lower case
    //* </method>
    public function QueryStringLC()
    {
        return $this->get_QueryStringCollection()->QueryStringLC();
    }
    
    //* <method name="QueryStringLCKeys" modifiers="public" 
    //* returnType="[string=>string]">
    //* Gets querystring parameters as an associative array with all keys in 
    //* lower case
    //* </method>
    public function QueryStringLCKeys()
    {
        return $this->get_QueryStringCollection()->QueryStringLCKeys();
    }
    
    //* <method name="QueryStringLCValues" modifiers="public" 
    //* returnType="[string=>string]">
    //* Gets querystring parameters as an associative array with all values in 
    //* lower case
    //* </method>
    public function QueryStringLCValues()
    {
        return $this->get_QueryStringCollection()->QueryStringLCValues();
    }
    
    //* <method name="QueryStringHash" modifiers="public" 
    //* returnType="[string=>[string=>string]]">
    //* Gets querystring parameters as an associative array with all keys in
    //* lower case.  Array value is an associative array containing original
    //* key (actualKey), value of parameter (value) and 
    //* lower case value (valueLC).
    //* </method>
    public function QueryStringHash()
    {
        return $this->get_QueryStringCollection()->QueryStringHash();
    }
    
    //* <method name="Cookies" modifiers="public" 
    //* returnType="[string=>string]">
    //* Gets cookies as an associative array
    //* </method>
    public function Cookies()
    {
        return $this->get_CookieCollection()->Cookies();
    }
    
    //* <method name="CookiesLC" modifiers="public" 
    //* returnType="[string=>string]">
    //* Gets cookies as an associative array with all keys and
    //* values in lower case
    //* </method>
    public function CookiesLC()
    {
        return $this->get_CookieCollection()->CookiesLC();
    }
    
    //* <method name="CookiesLCKeys" modifiers="public" 
    //* returnType="[string=>string]">
    //* Gets cookies as an associative array with all keys in 
    //* lower case
    //* </method>
    public function CookiesLCKeys()
    {
        return $this->get_CookieCollection()->CookiesLCKeys();
    }
    
    //* <method name="CookiesLCValues" modifiers="public" 
    //* returnType="[string=>string]">
    //* Gets cookies as an associative array with all values in 
    //* lower case
    //* </method>
    public function CookiesLCValues()
    {
        return $this->get_CookieCollection()->CookiesLCValues();
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
        return $this->get_CookieCollection()->CookiesHash();
    }    
    //// end public methods
    
    protected function set_CookieCollection(CookieCollection $cookieCollection)
    {
        $this->cookieCollection = $cookieCollection;
    }
    
    protected function set_QueryStringCollection(QueryStringCollection $queryStringCollection)
    {
        $this->queryStringCollection = $queryStringCollection;
    }
}
?>
