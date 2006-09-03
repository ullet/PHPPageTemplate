<?php
/*
 *************************************************************************
 * PHPPageTemplate: A PHP4 page templating system.                       *
 * Version 0.0.0 (03 September 2006)                                     *
 * Copyright (C) 2006 Trevor Barnett                                     *
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
 
include_once("TestPageTemplate.php");
include_once("PageBase.php");

class IndexPageCode extends PageBase
{
    // protected overridden methods
    function _Initialise()
    {
        parent::_Initialise();
        $pageTemplate =& new TestPageTemplate();
        $pageTemplate->set_Page($this);
        $pageTemplate->set_Title("Page Template Test");        
        $pageTemplate->set_Heading("A Page Template Test");
        $this->_set_PageTemplate($pageTemplate);
        $this->_RegisterPlaceHolder("ph1", "PlaceHolder_ph1");
        $this->_RegisterPlaceHolder("ph2", "PlaceHolder_ph2");        
    }
     
    // protected methods
    function _DoPlaceHolderTest()
    {
        echo "This is a test.";
    }
}
?>