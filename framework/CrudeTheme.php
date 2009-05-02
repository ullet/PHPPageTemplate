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
 
require_once dirname(__FILE__)."/PageRequest.php";
 
//* <class name="CrudeTheme" modifiers="public">
//* Crude page theme
//* </class>
class CrudeTheme implements Theme
{
    //// private member variables
    private $_favIconUrl = "";
    private $_styleSheetPath = "";
    private $_styleSheetPathIE6 = "";
    private $_styleSheetPathIE7 = "";
    private $_name = "";
    private $_title = "";
    private $_description = "";
    private $_thumbnailUrl = "";
    private $_template = "";
    //// end private member variables
    
    //// constructors
    //* <constructor modifiers="public">
    //* Create Theme object.
    //* <parameter name="$name" type="string">
    //* Name of theme.
    //* </parameter>
    //* </constructor>
    public function __construct($name)
    {
        $this->_name = $name;
    }
    //// end constructors
    
    //// public accessor methods
    public function get_Name()
    {
        return $this->_name;
    }
    
    public function set_FavIconUrl($value)
    {
        $this->_favIconUrl = $value;
    }
    
    public function get_FavIconUrl()
    {
        return $this->_favIconUrl;
    }
    
    public function set_StyleSheetPath($value)
    {
        $this->_styleSheetPath = $value;
    }
    
    public function get_StyleSheetPath()
    {
        return $this->_styleSheetPath;
    }
    
    public function set_StyleSheetPathIE6($value)
    {
        $this->_styleSheetPathIE6 = $value;
    }
    
    public function get_StyleSheetPathIE6()
    {
        return $this->_styleSheetPathIE6;
    }
    
    public function set_StyleSheetPathIE7($value)
    {
        $this->_styleSheetPathIE7 = $value;
    }
    
    public function get_StyleSheetPathIE7()
    {
        return $this->_styleSheetPathIE7;
    }    
    
    public function set_Title($value) 
    {
        $this->_title = $value;
    }
    
    public function get_Title()
    {
        return $this->_title;
    }    
    
    public function set_Description($value) 
    {
        $this->_description = $value;
    }
    
    public function get_Description()
    {
        return $this->_description;
    }    
    
    public function set_ThumbnailUrl($value) 
    {
        $this->_thumbnailUrl = $value;
    }
    
    public function get_ThumbnailUrl()
    {
        return $this->_thumbnailUrl;
    }
    
    public function set_Template(PageBase $value)
    {
        $this->_template = $value;
    }
    
    public function get_Template()
    {
        return $this->_template;
    }
    //// end public accessor methods
}
?>
