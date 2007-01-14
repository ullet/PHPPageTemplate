<?php
/*
 *************************************************************************
 * PHPPageTemplate: A PHP4 page templating system.                       *
 * Version 0.2.1 (14 January 2007)                                       *
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
 
require_once("PageBase.php");

class ParentPageTemplateCode extends PageBase
{    
    // private member variables
    var $_heading = "";
    
    // public accessors
    function get_Heading()
    {
        if ($this->_heading == "")
        {
            return $this->_title;
        }
        else
        {
            return $this->_heading;
        }
    }
    
    function get_EncodedHeading()
    {
        if ($this->_heading == "")
        {
            return $this->get_EncodedTitle();
        }
        else
        {
            return htmlentities($this->_heading);
        }
    }
    
    function set_Heading($heading)
    {
        $this->_heading = trim($heading);
    }     
    
    function Render()
    {
        parent::Render();
    }
    
    function _set_PageTemplate($pageTemplate)
    {
        parent::_set_PageTemplate($pageTemplate);
    }
}
?>