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
 
require_once "../framework/ThemeList.php";

class TestThemeList extends ThemeList
{
    private $themeListPath;
    
    // override constructor so can capture themeListPath for testing
    public function __construct($themeListPath, $defaultTheme=false, PageRequest $pageRequest=NULL)
    {
        $this->themeListPath = $themeListPath;
        parent::__construct($themeListPath, $defaultTheme, $pageRequest);
    }
    
    public function get_ThemeListPath_ForTesting()
    {
        return $this->themeListPath;
    }
    
    public function get_SelectedThemeQS_ForTesting()
    {
        return $this->get_SelectedThemeQS();
    }
    
    public function get_SelectedThemeCookies_ForTesting()
    {
        return $this->get_SelectedThemeCookies();
    }
    
    public function get_ExplicitlySelectedTheme_ForTesting()
    {
        return $this->get_ExplicitlySelectedTheme();
    }
    
    public function SelectedThemeFromCollection_ForTesting(&$col)
    {
        return $this->SelectedThemeFromCollection($col);
    }
    
    public function ParseThemes_ForTesting($themeListPath)
    {
        // use parent not $this to ensure real
        // method is called not one of the overridden
        // test methods.
        return parent::ParseThemes($themeListPath);
    }
    
    public function AddTheme_ForTesting($theme)
    {
        $this->AddTheme($theme);
    }
}
?>
