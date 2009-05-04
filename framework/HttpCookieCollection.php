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

//* <class name="CookieCollection" modifiers="public">
//* CookieCollection class
//* </class>
class HttpCookieCollection
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
    
    protected function CurrentTime()
    {
        // this method exist purely to make testing easier, can override
        // this method to ensure fixed time to test against
        return time();
    }
}
