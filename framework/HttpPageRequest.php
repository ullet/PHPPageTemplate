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

require_once dirname(__FILE__)."/HttpCookieCollection.php";
require_once dirname(__FILE__)."/HttpQueryStringCollection.php";
 
//* <class name="PageRequest" modifiers="public">
//* Page request class
//* </class>
class HttpPageRequest implements PageRequest
{
    private $cookieCollection;
    private $queryStringCollection;
    
    //// public methods
    protected function CookieCollection()
    {
        if (is_null($this->cookieCollection))
        {
            $this->cookieCollection = new HttpCookieCollection();
        }
        return $this->cookieCollection;
    }    
    
    protected function QueryStringCollection()
    {
        if (is_null($this->queryStringCollection))
        {
            $this->queryStringCollection = new HttpQueryStringCollection();            
        }
        return $this->queryStringCollection;
    }
    
    //* <method name="QueryString" modifiers="public" 
    //* returnType="[string=>string]">
    //* Gets querystring parameters as an associative array
    //* </method>
    public function QueryString()
    {
        return $this->QueryStringCollection()->QueryString();
    }
    
    //* <method name="Cookies" modifiers="public" 
    //* returnType="[string=>string]">
    //* Gets cookies as an associative array
    //* </method>
    public function Cookies()
    {
        return $this->CookieCollection()->Cookies();
    }
    
    public function SetCookie($name, $value, $duration, $path="", $domain="", $secure=0)
    {
        $this->CookieCollection()->SetCookie($name, $value, $duration, $path, $domain, $secure);
    }
    //// end public methods
}
?>
