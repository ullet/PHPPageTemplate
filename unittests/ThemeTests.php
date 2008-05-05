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
 
require_once "PHPUnit/Framework.php";
require_once "../framework/Theme.php";
require_once "MockTemplate.php";

//* <class name="ThemeTests" modifiers="public">
//* A selection of unit tests for Theme
//* </class>
class ThemeTests extends PHPUnit_Framework_TestCase
{
    function test_Create()
    {
        $theme =& $this->_CreateTheme();
        $this->assertNotNull($theme, "Expected theme object");
        $this->assertEquals("test", $theme->get_Name());
    }
    
    function test_Get_Set_FavIconUrl()
    {
        $theme =& $this->_CreateTheme();
        $theme->set_FavIconUrl("/favicon.ico");
        $this->assertEquals("/favicon.ico", $theme->get_FavIconUrl());
    }
    
    function test_Get_Set_StyleSheetPath()
    {
        $theme =& $this->_CreateTheme();
        $theme->set_StyleSheetPath("/styles.css");
        $this->assertEquals("/styles.css", $theme->get_StyleSheetPath());
    }
    
    function test_Get_Set_StyleSheetPathIE6()
    {
        $theme =& $this->_CreateTheme();
        $theme->set_StyleSheetPathIE6("/stylesIE6.css");
        $this->assertEquals("/stylesIE6.css", $theme->get_StyleSheetPathIE6());
    }
    
    function test_Get_Set_StyleSheetPathIE7()
    {
        $theme =& $this->_CreateTheme();
        $theme->set_StyleSheetPathIE7("/stylesIE7.css");
        $this->assertEquals("/stylesIE7.css", $theme->get_StyleSheetPathIE7());
    }
    
    function test_Get_Set_Title()
    {
        $theme =& $this->_CreateTheme();
        $theme->set_Title("A Theme");
        $this->assertEquals("A Theme", $theme->get_Title());
    }
    
    function test_Get_Set_Description()
    {
        $theme =& $this->_CreateTheme();
        $theme->set_Description("A description of a theme");
        $this->assertEquals("A description of a theme", $theme->get_Description());
    }
    
    function test_Get_Set_ThumbnailUrl()
    {
        $theme =& $this->_CreateTheme();
        $theme->set_ThumbnailUrl("/thumbnail.jpg");
        $this->assertEquals("/thumbnail.jpg", $theme->get_ThumbnailUrl());
    }
    
    function test_Get_Set_Template()
    {
        // Template object should be passed by reference.  This will always
        // be the case with PHP5.
        $theme =& $this->_CreateTheme();
        $template &= $this->_CreateTemplate();
        $this->assertNotNull($template, "Expected template object");
        $theme->set_Template($template);
        $this->assertSame($template, $theme->get_Template());
        $this->assertNotNull($theme->get_Template(), "Expected template object returned by get");
    }
    
    function &_CreateTheme()
    {
        return new Theme("test");
    }
    
    function &_CreateTemplate()
    {
        $template =& new MockTemplate();
        return $template;
    }
}
?>
