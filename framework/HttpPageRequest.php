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
