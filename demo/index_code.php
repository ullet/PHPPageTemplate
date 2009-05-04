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
 
require_once("TestPageTemplate.php");
require_once("../framework/PageBase.php");

class IndexPageCode extends PageBase
{
    function IndexPageCode()
    {
        $this->PageBase();
        $pageTemplate =& new TestPageTemplate();
        $pageTemplate->set_Page($this);
        $this->set_Title("PHP Page Template - Simple Template Example");        
        $pageTemplate->set_Heading("PHP Page Template - Simple Template Example");
        $this->_set_PageTemplate($pageTemplate);
        $this->_RegisterPlaceHolder("content1", "PlaceHolder_content1");
        $this->_RegisterPlaceHolder("content2", "PlaceHolder_content2");        
    }
}
?>
