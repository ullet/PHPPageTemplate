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
