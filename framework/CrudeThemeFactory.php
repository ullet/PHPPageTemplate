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
 
class CrudeThemeFactory implements ThemeFactory
{
    private $themeListPath;
    private $themeList = false;
    private $orderedThemeList = false;
    private $currentTheme = false;
    
    public function __construct($themeListPath)
    {
        $this->themeListPath = $themeListPath;
    }            
        
    public function CreateTheme($themeName)
    {
        $theme = NULL;
        if ($this->ThemeExists($themeName))
        {
            $theme = $themeList[$themeName];
        }
        return $theme;
    }
    
    public function ThemeExists($themeName)
    {
        if (!$this->themeList)
        {
            $this->ParseThemes();
        }
        if (!$this->themeList)
        {
            return false;
        }
        return array_key_exists($themeName, $this->themeList);
    }    
    
    protected function ParseThemes()
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
                $theme = new CrudeTheme(strtolower($attributes["name"]));
                $this->currentTheme = $theme;
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
}

?>