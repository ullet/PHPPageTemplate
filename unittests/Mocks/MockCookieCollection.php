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
require_once "Framework.php";
 
//* <class name="Cookie" modifiers="public">
//* MockCookieCollection class
//* </class>
class MockCookieCollection implements CookieCollection
{
    private $cookies = array();
    
    //// CookieCollection interface members
    public function SetCookie($name, $value, $duration, $path="", $domain="", $secure=0)
    {
        $this->cookies[] = array(
                'name'=>$name,
                'value'=>$value,
                'expires'=>$this->CurrentTime() + $duration,
                'path'=>$path,
                'domain'=>$doamin,
                'secure'=>$secure);
    }
    
    public function Cookies()
    {
        $cookieArray = array();
        foreach ($this->cookies as $cookie)
        {
            $cookieArray[$cookie['name']] = $cookie['value'];
        }
        return $cookieArray;
    }
    //// End CookieCollection interface members
    
    protected function CurrentTime()
    {
        // this method exist purely to make testing easier, can override
        // this method to ensure fixed time to test against
        return time();
    }
    
    public function ClearTestCookies()
    {
        $this->cookies = array();
    }
    
    public function AddTestCookie($key, $value)
    {
        $this->SetCookie($key, $value, 3600);
    }
}
