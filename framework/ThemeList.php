<?php
/*
 *************************************************************************
 * PHPPageTemplate: A PHP4 page templating system.                       *
 * Version 0.3.0 (11 November 2007)                                      *
 * Copyright (C) 2006-2007 Trevor Barnett                                *
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

//* <class name="ThemeList" modifiers="public">
//* List of page themes
//* </class>
class ThemeList
{
    var $_themeList = false;
    var $_currentTheme = false;
    var $_currentElement = false;
    //* <property name="_defaultTheme" modifiers="private" type="string">
    //* Default theme.
    //* </property>    
    var $_defaultTheme = false;
    //* <property name="_themeInCookie" modifiers="private" type="boolean">
    //* Flag if theme is set in cookie.
    //* </property>    
    var $_themeInCookie = false;
    //* <property name="_themeInQS" modifiers="private" type="boolean">
    //* Flag if theme is set in querystring.
    //* </property>    
    var $_themeInQS = false;
    //* <property name="_cookieDuration" modifiers="private" type="int">
    //* Length of time in seconds from current time at which cookie saving
    //* theme should expire.
    //* </property>
    var $_cookieDuration = 315360000; // 10 years
    var $_iterator = false;
    
    //// constructors
    function ThemeList($themeListPath, $defaultTheme=false)
    {
        $this->set_DefaultThemeName($defaultTheme);
        $this->_ParseThemes($themeListPath);
    }
    //// end constructors
    
    //// public accessor methods
    function set_CookieDuration($duration)
    {
        $this->_cookieDuration = $duration;
    }
    
    function get_CookieDuration()
    {
        return $this->_cookieDuration;
    }
    
    function set_DefaultThemeName($theme)
    {
        $this->_defaultTheme = $theme;
    }
    
    function get_DefaultThemeName($theme)
    {
        return $this->_defaultTheme;
    }
    
    function &get_SelectedTheme()
    {
        $selectedThemeName = $this->get_SelectedThemeName();
        if ("" == $selectedThemeName ||
            !array_key_exists($selectedThemeName, $this->_themeList))
        {
            return false;
        }
        return $this->_themeList[$selectedThemeName];
    }
    
    function get_SelectedThemeName()
    {
        $selectedTheme = $this->_get_ExplicitlySelectedTheme();
        if ("" == $selectedTheme)
        {
            if ($this->_defaultTheme)
            {
                $selectedTheme = $this->_defaultTheme;
            }
        }
        return $selectedTheme;
    }  
    
    function get_ThemeExplicitlySelected()
    {
        return "" != $this->_get_ExplicitlySelectedTheme();
    }
    
    function get_ThemeInCookie()
    {
        return $this->_themeInCookie;
    }
    
    function get_ThemeInQS()
    {
        return $this->_themeInQS;
    }
    
    function &get_Iterator()
    {
        if (!$this->_iterator)
        {
            $this->_iterator =& new ListIterator();
            $this->_iterator->set_List(array_values($this->_themeList));
        }
        return $this->_iterator;
    }
    //// end public accessor methods
    
    //// protected accessor methods
    function _get_SelectedThemeQS()
    {
        $qs =& PageRequest::QueryStringLC();
        $selectedTheme = $this->_SelectedThemeFromCollection($qs);
        $this->_themeInQS = ("" != $selectedTheme);
        return $selectedTheme;
    }
          
    function _get_SelectedThemeCookies()
    {
        $cookies =& PageRequest::CookiesLC();
        $selectedTheme = $this->_SelectedThemeFromCollection($cookies);
        $this->_themeInCookie = ("" != $selectedTheme);
        return $selectedTheme;
    }       
    
    function _get_ExplicitlySelectedTheme()
    {
        $selectedThemeQS = $this->_get_SelectedThemeQS();
        $selectedThemeCookies = $this->_get_SelectedThemeCookies();
        
        if ("" != $selectedThemeQS)
        {
            if ($selectedThemeCookies != $selectedThemeQS)
            {
                $selectedThemeCookies = "";
                $this->_themeInCookie = false;
            }    
            return $selectedThemeQS;
        }
        return $selectedThemeCookies;
    }
    //// end protected accessor methods       
    
    //// public methods
    function ThemeExists($themeName)
    {
        if (!$this->_themeList)
        {
            return false;
        }
        return array_key_exists($themeName, $this->_themeList);
    }
    
    function SetSelectedThemeCookie()
    {
        if (!$this->get_ThemeExplicitlySelected())
        {
            return;
        }
        if ($this->get_ThemeInCookie())
        {
            return;
        }
        setcookie("theme", $this->get_SelectedThemeName(), 
            time() + $this->get_CookieDuration(), '/');
    }
    //// end public methods
    
    //// protected methods    
    function _SelectedThemeFromCollection(&$col)
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
    
    function _ParseThemes($themeListPath)
    {
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
        xml_set_element_handler($parser, '_StartElement', '_EndElement');
        xml_set_character_data_handler($parser, '_CharacterData');
        
        if (!xml_parse($parser, $themesXml))
        {
            // do some error handling
        }
    }
    
    function _StartElement($parser, $elementName, &$attributes)
    {
        if ($elementName == "theme")
        {
            // start new theme
            if (array_key_exists("name", $attributes))
            {
                $theme =& new Theme(strtolower($attributes["name"]));
                $this->_currentTheme =& $theme;
            }
            else
            {
                $this->_currentTheme = false;
            }
        }
        else 
        {
            $this->_currentElement = $elementName;
        }
    }
    
    function _CharacterData($parser, $cdata)
    {
        if ($this->_currentElement && $this->_currentTheme)
        {
            $theme =& $this->_currentTheme;
            if ($this->_currentElement == "favIconUrl")
            {
                $theme->set_FavIconUrl(trim($cdata));
            }
            else if ($this->_currentElement == "styleSheetPath")
            {
                $theme->set_StyleSheetPath(trim($cdata));
            }
            else if ($this->_currentElement == "styleSheetPathIE6")
            {
                $theme->set_StyleSheetPathIE6(trim($cdata));
            }
            else if ($this->_currentElement == "styleSheetPathIE7")
            {
                $theme->set_StyleSheetPathIE7(trim($cdata));
            }
            else if ($this->_currentElement == "title")
            {
                $theme->set_Title(trim($cdata));
            }
            else if ($this->_currentElement == "description")
            {
                $text = $theme->get_Description();
                if ($text != "")
                {
                    $text .= " ";
                }
                $text .= trim($cdata);                
                $theme->set_Description($text);
            }
            else if ($this->_currentElement == "thumbnailUrl")
            {
                $theme->set_ThumbnailUrl(trim($cdata));
            }
            else if ($this->_currentElement == "template")
            {
                $theme->set_Template(trim($cdata));
            }
        }
    }
    
    function _EndElement($parser, $elementName)
    {
        if ($elementName == "theme")
        {
            // end of current theme
            if ($this->_currentTheme)
            {
                if (!$this->_themeList)
                {
                    $this->_themeList = array();
                }
                $this->_themeList[$this->_currentTheme->get_Name()] =
                    $this->_currentTheme;
            }
            $this->_currentTheme = false;
        }
        $this->_currentElement = false;
    } 
    //// end protected methods
}
?>
