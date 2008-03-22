<?php
/*
 *************************************************************************
 * PHPPageTemplate: A PHP4 page templating system.                       *
 * Version 0.3.0 (11 November 2007)                                      *
 * Copyright (C) 2006-2007 Trevor Barnett                                *
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
 
require_once dirname(__FILE__)."/PageRequest.php";
 
//* <class name="Theme" modifiers="public">
//* Page theme
//* </class>
class Theme
{
    //// private member variables
    var $_favIconUrl = "";
    var $_styleSheetPath = "";
    var $_styleSheetPathIE6 = "";
    var $_styleSheetPathIE7 = "";
    var $_name = "";
    var $_title = "";
    var $_description = "";
    var $_thumbnailUrl = "";
    var $_template = "";
    //// end private member variables
    
    //// constructors
    //* <constructor modifiers="public">
    //* Create Theme object.
    //* <parameter name="$name" type="string">
    //* Name of theme.
    //* </parameter>
    //* </constructor>
    function Theme($name)
    {
        $this->_name = $name;
    }
    //// end constructors
    
    //// public accessor methods
    function get_Name()
    {
        return $this->_name;
    }
    
    function set_FavIconUrl($value)
    {
        $this->_favIconUrl = $value;
    }
    
    function get_FavIconUrl()
    {
        return $this->_favIconUrl;
    }
    
    function set_StyleSheetPath($value)
    {
        $this->_styleSheetPath = $value;
    }
    
    function get_StyleSheetPath()
    {
        return $this->_styleSheetPath;
    }
    
    function set_StyleSheetPathIE6($value)
    {
        $this->_styleSheetPathIE6 = $value;
    }
    
    function get_StyleSheetPathIE6()
    {
        return $this->_styleSheetPathIE6;
    }
    
    function set_StyleSheetPathIE7($value)
    {
        $this->_styleSheetPathIE7 = $value;
    }
    
    function get_StyleSheetPathIE7()
    {
        return $this->_styleSheetPathIE7;
    }    
    
    function set_Title($value) 
    {
        $this->_title = $value;
    }
    
    function get_Title()
    {
        return $this->_title;
    }    
    
    function set_Description($value) 
    {
        $this->_description = $value;
    }
    
    function get_Description()
    {
        return $this->_description;
    }    
    
    function set_ThumbnailUrl($value) 
    {
        $this->_thumbnailUrl = $value;
    }
    
    function get_ThumbnailUrl()
    {
        return $this->_thumbnailUrl;
    }
    
    function set_Template($value)
    {
        $this->_template = $value;
    }
    
    function get_Template()
    {
        return $this->_template;
    }
    //// end public accessor methods
}
?>
