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
 
 require_once "../framework/HttpPageRequest.php";
 require_once "MockCookieCollection.php";
 require_once "MockQueryStringCollection.php";

// Override CookieCollection and QueryStringCollection to use collections that
// are not dependent on being run in a HTTP context.
class HttpPageRequestExposedForTest extends HttpPageRequest
{
    private $cookieCollection;
    private $queryStringCollection;
    
    public function __construct()
    {
        $this->cookieCollection = new MockCookieCollection();
        $this->queryStringCollection = new MockQueryStringCollection();
    }
    
    //// Overidden HttpPageRequest members
    public function CookieCollection()
    {
        return $this->cookieCollection;
    }
    
    public function QueryStringCollection()
    {
        return $this->queryStringCollection;
    }
    //// End overidden HttpPageRequest members
    
    // methods to allow setting and getting test querystring and cookies
    public function ClearTestQueryString()
    {
        $this->queryStringCollection->ClearTestQueryString();
    }
    
    public function ClearTestCookies()
    {
        $this->cookieCollection->ClearTestCookies();
    }
    
    public function ClearTestContext()
    {
        $this->ClearTestQueryString();
        $this->ClearTestCookies();
    }
    
    public function AddTestQueryStringParameter($key, $value)
    {
        $this->queryStringCollection->AddTestQueryStringParameter($key, $value);
    }
    
    public function AddTestCookie($key, $value)
    {
        $this->cookieCollection->AddTestCookie($key, $value);
    }
}
?>
