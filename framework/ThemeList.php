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
 
require_once "Interfaces.php";

//* <class name="ThemeList" modifiers="public">
//* List of page themes
//* </class>
class ThemeList
{
    private $currentTheme = false;
    private $currentElement = false;
    //* <property name="_defaultTheme" modifiers="private" type="string">
    //* Default theme.
    //* </property>    
    private $defaultTheme = false;
    //* <property name="_themeInCookie" modifiers="private" type="boolean">
    //* Flag if theme is set in cookie.
    //* </property>    
    private $themeInCookie = false;
    //* <property name="_themeInQS" modifiers="private" type="boolean">
    //* Flag if theme is set in querystring.
    //* </property>    
    private $themeInQueryString = false;
    //* <property name="_cookieDuration" modifiers="private" type="int">
    //* Length of time in seconds from current time at which cookie saving
    //* theme should expire.
    //* </property>
    private $cookieDuration = 2592000; // default to 30 days
    private $iterator = NULL;
    private $pageRequest = NULL;
    private $themeFactory = NULL;
    
    //// constructors               
    public function __construct(
        ThemeFactory $themeFactory,
        $defaultTheme=false, 
        $pageRequest=NULL) // can't use type hint if want default of NULL
    {
        $this->set_DefaultThemeName($defaultTheme);
        if ($pageRequest != NULL)
        {
            $this->set_PageRequest($pageRequest);
        }
        $this->set_ThemeFactory($themeFactory);
    }
    //// end constructors
    
    protected function set_ThemeFactory(ThemeFactory $themeFactory)
    {
        $this->themeFactory = $themeFactory;
    }
        
    //// public accessor methods
    protected function set_PageRequest(PageRequest $pageRequest)
    {
        $this->pageRequest = $pageRequest;
    }
    
    protected function get_PageRequest()
    {
        if (!$this->pageRequest)
        {
            $this->pageRequest = new HttpPageRequest();
        }
        return $this->pageRequest;
    }
    
    protected function get_CookieCollection()
    {
        return $this->get_PageRequest()->get_CookieCollection();
    }
    
    public function set_CookieDuration($duration)
    {
        $this->cookieDuration = $duration;
    }
    
    public function get_CookieDuration()
    {
        return $this->cookieDuration;
    }
    
    public function set_DefaultThemeName($theme)
    {
        // aside: incorrectly setting type hint of 'Theme' caused
        // a segmentation fault! (Not the 'Fatal Error' would have expected)
        $this->defaultTheme = $theme;
    }
    
    public function get_DefaultThemeName()
    {
        return $this->defaultTheme;
    }
    
    public function get_SelectedTheme()
    {
        $selectedThemeName = $this->get_SelectedThemeName();
        $selectedTheme = false;
        if ("" != $selectedThemeName)
        {
            $selectedTheme = $this->themeFactory->CreateTheme($selectedThemeName);
        }
        return $selectedTheme;
    }
    
    public function get_SelectedThemeName()
    {
        $selectedTheme = $this->get_ExplicitlySelectedTheme();
        if ("" == $selectedTheme)
        {
            if ($this->defaultTheme)
            {
                $selectedTheme = $this->defaultTheme;
            }
        }
        return $selectedTheme;
    }  
    
    public function get_ThemeExplicitlySelected()
    {
        return "" != $this->get_ExplicitlySelectedTheme();
    }
    
    public function get_ThemeInCookie()
    {
        return $this->themeInCookie;
    }
    
    public function get_ThemeInQueryString()
    {
        return $this->themeInQueryString;
    }
    //// end public accessor methods
    
    //// protected accessor methods
    protected function get_SelectedThemeQueryString()
    {
        $pageRequest =& $this->get_PageRequest();
        $queryString = $pageRequest->QueryString();
        $selectedTheme = $this->SelectedThemeFromCollection($queryString);
        $this->themeInQueryString = ("" != $selectedTheme);
        return $selectedTheme;
    }
          
    protected function get_SelectedThemeCookies()
    {
        $pageRequest =& $this->get_PageRequest();
        $cookies =& $pageRequest->Cookies();
        $selectedTheme = $this->SelectedThemeFromCollection($cookies);
        $this->themeInCookie = ("" != $selectedTheme);
        return $selectedTheme;
    }       
    
    //* <method name="_get_ExplicitlySelectedTheme" modifiers="protected" returnType="string">
    //* Gets the explicitly selected theme, i.e. set externally in some way
    //* e.g. from the cookie or querystring
    //* </method>
    protected function get_ExplicitlySelectedTheme()
    {
        $selectedThemeQueryString = $this->get_SelectedThemeQueryString();
        $selectedThemeCookies = $this->get_SelectedThemeCookies();
        
        if ("" != $selectedThemeQueryString)
        {
            if ($selectedThemeCookies != $selectedThemeQueryString)
            {
                $selectedThemeCookies = "";
                $this->themeInCookie = false;
            }    
            return $selectedThemeQueryString;
        }
        return $selectedThemeCookies;
    }
    //// end protected accessor methods       
    
    //// public methods    
    public function SetSelectedThemeCookie()
    {
        if (!$this->get_ThemeExplicitlySelected())
        {
            return;
        }
        if ($this->get_ThemeInCookie())
        {
            return;
        }
        $this->pageRequest->SetCookie(
            "theme", 
            $this->get_SelectedThemeName(), 
            $this->get_CookieDuration(), 
            '/');
    }
    //// end public methods
    
    //// protected methods    
    protected function SelectedThemeFromCollection(array $col)
    {
        $selectedTheme = "";
        if (array_key_exists('theme', $col))
        {
            $selectedTheme = trim($col['theme']);
        }
        return $selectedTheme;
    }
    //// end protected methods
}
?>
