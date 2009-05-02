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
 
require_once dirname(__FILE__)."/Theme.php";
require_once dirname(__FILE__)."/ListIterator.php";
require_once dirname(__FILE__)."/PageRequest.php";
require_once dirname(__FILE__)."/CookieCollection.php";

//* <class name="ThemeList" modifiers="public">
//* List of page themes
//* </class>
class ThemeList
{
    private $themeList = false;
    private $orderedThemeList = false;
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
    private $themeInQS = false;
    //* <property name="_cookieDuration" modifiers="private" type="int">
    //* Length of time in seconds from current time at which cookie saving
    //* theme should expire.
    //* </property>
    private $cookieDuration = 2592000; // default to 30 days
    private $iterator = NULL;
    private $pageRequest = NULL;
    
    //// constructors               
    public function __construct($themeListPath, $defaultTheme=false, PageRequest $pageRequest=NULL)
    {
        $this->set_DefaultThemeName($defaultTheme);
        $this->set_PageRequest($pageRequest);
        $this->ParseThemes($themeListPath);
    }
    //// end constructors
    
    //// public accessor methods
    public function set_PageRequest($pageRequest)
    {
        $this->pageRequest = $pageRequest;
    }
    
    public function get_PageRequest()
    {
        if (!$this->pageRequest)
        {
            $this->pageRequest = new PageRequest();
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
        if ("" == $selectedThemeName ||
            !array_key_exists($selectedThemeName, $this->themeList))
        {
            return false;
        }
        return $this->themeList[$selectedThemeName];
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
    
    public function get_ThemeInQS()
    {
        return $this->themeInQS;
    }
    
    public function get_Iterator()
    {
        if (!$this->iterator)
        {
            $this->iterator =& new ListIterator();
            $this->iterator->set_List(array_values($this->orderedThemeList));
        }
        return $this->iterator;
    }
    //// end public accessor methods
    
    //// protected accessor methods
    protected function get_SelectedThemeQS()
    {
        $pageRequest =& $this->get_PageRequest();
        $qs =& $pageRequest->QueryStringLC();
        $selectedTheme = $this->SelectedThemeFromCollection($qs);
        $this->themeInQS = ("" != $selectedTheme);
        return $selectedTheme;
    }
          
    protected function get_SelectedThemeCookies()
    {
        $pageRequest =& $this->get_PageRequest();
        $cookies =& $pageRequest->CookiesLC();
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
        $selectedThemeQS = $this->get_SelectedThemeQS();
        $selectedThemeCookies = $this->get_SelectedThemeCookies();
        
        if ("" != $selectedThemeQS)
        {
            if ($selectedThemeCookies != $selectedThemeQS)
            {
                $selectedThemeCookies = "";
                $this->themeInCookie = false;
            }    
            return $selectedThemeQS;
        }
        return $selectedThemeCookies;
    }
    //// end protected accessor methods       
    
    //// public methods
    public function ThemeExists($themeName)
    {
        if (!$this->themeList)
        {
            return false;
        }
        return array_key_exists($themeName, $this->themeList);
    }
    
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
        $this->get_CookieCollection()->SetCookie(
            "theme", $this->get_SelectedThemeName(), 
            $this->get_CookieDuration(), '/');
    }
    //// end public methods
    
    //// protected methods    
    protected function SelectedThemeFromCollection(array $col)
    {
        if (array_key_exists('theme', $col))
        {
            $selectedTheme = trim($col['theme']);
            if ($this->ThemeExists($selectedTheme))
            {
                return $selectedTheme;
            }
        }
        return "";
    }  
    
    protected function ParseThemes($themeListPath)
    {
        if (!file_exists($themeListPath))
        {
            return;            
        }
        $fp = fopen($themeListPath, "r");
        if (!$fp)
        {
            return;
        }
        
        $themesXml = "";
        while ($data = fread($fp, 102400))
        {
            $themesXml .= $data;
        }
        fclose($fp);
        
        $parser = xml_parser_create();
        xml_set_object($parser, $this);
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, false);
        xml_set_element_handler($parser, 'StartElement', 'EndElement');
        xml_set_character_data_handler($parser, 'CharacterData');
                                            
        if (!xml_parse($parser, $themesXml))
        {
            // do some error handling
        }
    }
    
    protected function StartElement($parser, $elementName, &$attributes)
    {
        if ($elementName == "theme")
        {
            // start new theme
            if (array_key_exists("name", $attributes))
            {
                $theme =& new Theme(strtolower($attributes["name"]));
                $this->currentTheme =& $theme;
            }
            else
            {
                $this->currentTheme = false;
            }
        }
        else 
        {
            $this->currentElement = $elementName;
        }
    }
    
    protected function CharacterData($parser, $cdata)
    {
        if ($this->currentElement && $this->currentTheme)
        {
            $theme =& $this->currentTheme;
            if ($this->currentElement == "favIconUrl")
            {
                $theme->set_FavIconUrl(trim($cdata));
            }
            else if ($this->currentElement == "styleSheetPath")
            {
                $theme->set_StyleSheetPath(trim($cdata));
            }
            else if ($this->currentElement == "styleSheetPathIE6")
            {
                $theme->set_StyleSheetPathIE6(trim($cdata));
            }
            else if ($this->currentElement == "styleSheetPathIE7")
            {
                $theme->set_StyleSheetPathIE7(trim($cdata));
            }
            else if ($this->currentElement == "title")
            {
                $theme->set_Title(trim($cdata));
            }
            else if ($this->currentElement == "description")
            {
                $text = $theme->get_Description();
                if ($text != "")
                {
                    $text .= " ";
                }
                $text .= trim($cdata);                
                $theme->set_Description($text);
            }
            else if ($this->currentElement == "thumbnailUrl")
            {
                $theme->set_ThumbnailUrl(trim($cdata));
            }
            else if ($this->currentElement == "template")
            {
                $theme->set_Template(trim($cdata));
            }
        }
    }
    
    protected function EndElement($parser, $elementName)
    {
        if ($elementName == "theme")
        {
            // end of current theme
            if ($this->currentTheme)
            {
                $this->AddTheme($this->currentTheme);
            }
            $this->currentTheme = false;
        }
        $this->currentElement = false;
    } 
    
    protected function AddTheme(Theme $theme)
    {
        if ($theme)
        {
            if (!$this->themeList || !$this->orderedThemeList)
            {
                $this->themeList = array();
                $this->orderedThemeList = array();
            }
            $this->themeList[$theme->get_Name()] = $theme;
            $this->orderedThemeList[] = $theme;
        }
    }
    //// end protected methods
}
?>
