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

//* <class name="QueryStringCollection" modifiers="public">
//* QueryStringCollection class
//* </class>
class QueryStringCollection
{
    //* <method name="QueryString" modifiers="public" 
    //* returnType="[string=>string]">
    //* Gets querystring parameters as an associative array
    //* </method>
    public function QueryString()
    {
        return $_GET;
    }
    
    //* <method name="QueryStringLC" modifiers="public" 
    //* returnType="[string=>string]">
    //* Gets querystring parameters as an associative array with all keys and
    //* values in lower case
    //* </method>
    public function QueryStringLC()
    {
        $qs = $this->QueryString();
        $qslc = array();
        foreach (array_keys($qs) as $key)
        {
            $qslc[strtolower($key)] = strtolower($qs[$key]);
        }
        return $qslc;
    }
    
    //* <method name="QueryStringLCKeys" modifiers="public" 
    //* returnType="[string=>string]">
    //* Gets querystring parameters as an associative array with all keys in 
    //* lower case
    //* </method>
    public function QueryStringLCKeys()
    {
        $qs = $this->QueryString();
        $qslc = array();
        foreach (array_keys($qs) as $key)
        {
            $qslc[strtolower($key)] = $qs[$key];
        }
        return $qslc;
    }
    
    //* <method name="QueryStringLCValues" modifiers="public" 
    //* returnType="[string=>string]">
    //* Gets querystring parameters as an associative array with all values in 
    //* lower case
    //* </method>
    public function QueryStringLCValues()
    {
        $qs = $this->QueryString();
        $qslc = array();
        foreach (array_keys($qs) as $key)
        {
            $qslc[$key] = strtolower($qs[$key]);
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
    public function QueryStringHash()
    {
        $qs = $this->QueryString();
        $qsHash = array();
        foreach (array_keys($qs) as $key)
        {
            $qsHash[strtolower($key)] = array(
                "actualKey" => $key,
                "value" => $qs[$key],
                "valueLC" => strtolower($qs[$key]));
        }
        return $qsHash;
    }
}
?>
