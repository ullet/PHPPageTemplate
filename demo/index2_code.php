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
 
require_once("ChildPageTemplate.php");
require_once("../framework/PageBase.php");

class IndexPage2Code extends PageBase
{
    // protected overridden methods
    function IndexPage2Code()
    {
        $pageTemplate =& new ChildPageTemplate();
        $this->_set_PageTemplate($pageTemplate);        
        $pageTemplate->set_Page($this);
        $this->_RegisterPlaceHolder("top", "PlaceHolder_top");
        $this->_RegisterPlaceHolder("bottom", "PlaceHolder_bottom");
        $this->set_Title("PHP Page Template - Nested Template Example");        
        $pageTemplate->set_Heading("PHP Page Template - Nested Template Example");  
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
