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
 
require_once "TestThemeList.php";
require_once "TestQSTheme.php";
require_once "TestCookieTheme.php";

class TestThemeListMockParse extends TestThemeList
{
    public function __construct($themeListPath, $defaultTheme=false, PageRequest $pageRequest=NULL)
    {
        parent::__construct($themeListPath, $defaultTheme, $pageRequest);
    }
    
    // Override _ParseThemes method to set test values in order to be able
    // to test methods that need config data (but don't need to parse a file).
    protected function _ParseThemes($themeListPath)
    {
        $this->_AddTheme(new TestQSTheme());
        $this->_AddTheme(new TestCookieTheme());
    }
}
?>
