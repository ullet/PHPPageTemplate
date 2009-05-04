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
 
require_once "../framework/PageBase.php";

class MockPage extends PageBase
{   
    private $_placeHolderCalled = false;
    
    public function ResetPlaceHolderState()
    {
        $this->_placeHolderCalled = false;
    }
    
    public function WasPlaceHolderCalled()
    {
        return $this->_placeHolderCalled;
    }
        
    public function PlaceHolderFunction()
    {
        $this->_placeHolderCalled = true;
    }
    
    public function RegisterPlaceHolderFunction($name)
    {
        $this->_RegisterPlaceHolder($name, "PlaceHolderFunction");
    }
    
    public function set_PageTemplate(&$template)
    {
        $this->_set_PageTemplate($template);
    }
    
    public function &get_PageTemplate()
    {
        return $this->_get_PageTemplate();
    }
}
?>
