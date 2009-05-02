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
require_once "../framework/CookieCollection.php";
 
//* <class name="Cookie" modifiers="public">
//* MockCookieCollection class
//* </class>
class MockCookieCollection extends CookieCollection
{
    private $cookies = array();
    
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
