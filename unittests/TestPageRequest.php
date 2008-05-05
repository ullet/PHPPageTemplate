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
 
 require_once "MockCookieCollection.php";
 require_once "MockQueryStringCollection.php";

// Override certain methods to allow testing.  Due to overriding the
// QueryString and Cookies methods are not testable, but these two methods
// are trivial, simply returning the arrays $_GET and $_COOKIE respectively.
class TestPageRequest extends PageRequest
{
    public function TestPageRequest()
    {
        // set test CookieCollection and test QueryStringCollection as 
        // $_COOKIE and $_GET do not special meaning outside of a web 
        // context
        $this->set_CookieCollection(new MockCookieCollection());
        $this->set_QueryStringCollection(new MockQueryStringCollection());
    }
    
    // methods to allow setting and getting test querystring and cookies
    public function ClearTestQueryString()
    {
        $this->get_QueryStringCollection()->ClearTestQueryString();
    }
    
    public function ClearTestCookies()
    {
        $this->get_CookieCollection()->ClearTestCookies();
    }
    
    public function ClearTestContext()
    {
        $this->ClearTestQueryString();
        $this->ClearTestCookies();
    }
    
    public function AddTestQueryStringParameter($key, $value)
    {
        $this->get_QueryStringCollection()->AddTestQueryStringParameter($key, $value);
    }
    
    public function AddTestCookie($key, $value)
    {
        $this->get_CookieCollection()->AddTestCookie($key, $value);
    }
    
    public function set_CookieCollection_ForTesting($cookieCollection)
    {
        parent::set_CookieCollection($cookieCollection);
    }
    
    public function set_QueryStringCollection_ForTesting($queryStringCollection)
    {
        parent::set_QueryStringCollection($queryStringCollection);
    }
}
?>
