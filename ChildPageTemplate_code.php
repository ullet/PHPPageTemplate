<?php
/*
 *************************************************************************
 * PHPPageTemplate: A PHP4 page templating system.                       *
 * Version 0.2.0 (14 January 2007)                                       *
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
require_once("ParentPageTemplate.php");

class ChildPageTemplateCode extends PageBase
{    
    function ChildPageTemplateCode()
    {
        $this->PageBase();
        $pageTemplate =& new ParentPageTemplate();
        $pageTemplate->set_Page($this);
        $this->_set_PageTemplate($pageTemplate);
        $this->_RegisterPlaceHolder("leftcol", "PlaceHolder_leftcol");
        $this->_RegisterPlaceHolder("rightcol", "PlaceHolder_rightcol");
        $this->_RegisterPlaceHolder("maincol", "PlaceHolder_maincol");
        $pageTemplate =& $this->_get_PageTemplate(); // as ParentPageTemplate 
        $pageTemplate->set_Heading($this->get_Heading());     
    }
    
    // public accessors
    function get_Heading()
    {
        $pageTemplate =& $this->_get_PageTemplate(); // as ParentPageTemplate
        return !$pageTemplate ? "" : $pageTemplate->get_Heading();
    }
    
    function get_EncodedHeading()
    {
        $pageTemplate =& $this->_get_PageTemplate(); // as ParentPageTemplate
        return !$pageTemplate ? "" : $pageTemplate->get_EncodedHeading();        
    }
    
    function set_Heading($heading)
    {
        $pageTemplate =& $this->_get_PageTemplate(); // as ParentPageTemplate
        if ($pageTemplate)
        {
            $pageTemplate->set_Heading($heading);
        }
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