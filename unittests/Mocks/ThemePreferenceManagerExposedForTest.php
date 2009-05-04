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
 
require_once "../framework/ThemePreferenceManager.php";

class ThemePreferenceManagerExposedForTest extends ThemePreferenceManager
{
    // override constructor so can capture themeListPath for testing
    public function __construct(
        ThemeFactory $themeFactory,
        $defaultTheme=false, 
        $pageRequest=NULL)
    {
        $this->themeListPath = $themeListPath;
        parent::__construct(
            $themeFactory, 
            $defaultTheme, 
            $pageRequest);
    }
    
    public function get_SelectedThemeQueryString_ForTesting()
    {
        return parent::get_SelectedThemeQueryString();
    }
    
    public function get_SelectedThemeCookies_ForTesting()
    {
        return parent::get_SelectedThemeCookies();
    }
    
    public function get_ExplicitlySelectedTheme_ForTesting()
    {
        return parent::get_ExplicitlySelectedTheme();
    }
    
    public function SelectedThemeFromCollection_ForTesting(&$col)
    {
        return parent::SelectedThemeFromCollection($col);
    }
    
    public function get_PageRequest_ForTesting()
    {
        return parent::get_PageRequest();
    }
    
    public function set_PageRequest_ForTesting(PageRequest $pageRequest)
    {
        return parent::set_PageRequest($pageRequest);
    }
}
