<?php
/*
 *************************************************************************
 * PHPPageTemplate: A PHP4 page templating system.                       *
 * Version 0.1.0 (13 January 2007)                                       *
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

//* <class name="PageCache" modifiers="public">
//* Base class for a web page based on a template and a template page
//* </class>
class PageCache
{    
    //// private member variables
    //* <property name="_cacheDuration" modifiers="private"
    //* type="int">
    //* Set duration for page to be cached
    //* </property>    
    var $_cacheDuration = 0;
    //* <property name="_cacheParameters" modifiers="private"
    //* type="string">
    //* Comma separated list of querystring parameters to vary cache.
    //* Output for different values of the parameter will cached.
    //* Separately.
    //* </property>
    var $_cacheParameters = "";
    //* <property name="_cacheDirectory" modifiers="private"
    //* type="string">
    //* Directory for storing cache files.
    //* </property>
    var $_cacheDirectory = "";
    //* <property name="_page" modifiers="private"
    //* type="&amp;PageBase">
    //* Reference to page to be cached.
    //* </property>
    var $_page;
    //// end private member variables
    
    //// constructors
    //* <constructor modifiers="public">
    //* Create page cache object.
    //* <parameter name="$cacheDirectory" type="string">
    //* Directory for storing cache files.
    //* </parameter>
    //* <parameter name="$cacheDuration" type="string">
    //* Duration for page to cached.
    //* </parameter>
    //* <parameter name="$cacheParameters" type="string">
    //* Comma separated list of querystring parameters to vary cache.
    //* </parameter>
    //* </constructor>
    function PageCache(&$page, $cacheDirectory, $cacheDuration=false, $cacheParameters=false)
    {
        $this->_page =& $page;
        
        $this->_cacheDirectory = $this->_TidyDirName($cacheDirectory);
        
        if ($cacheDuration && $cacheDuration > 0)
        {
            $this->_cacheDuration = $cacheDuration;
        }
        
        if ($cacheParameters && $cacheParameters != "")
        {
            $this->_cacheParameters = $cacheParameters;
        }
    }
    //// end constructors
    
    //// public methods
    //* <method name="CachePage" modifiers="public"
    //* returnType="void">
    //* Saves page output to cache.
    //* </method>
    function CachePage()
    {
        $page =& $this->_page;
        $this->ClearCache($page->get_PageName());
        if ($this->_cacheDuration <= 0)
        {
            // cache will be immediately invalid so don't waste time caching page
            return;
        }
        
        $contents = ob_get_contents();
        // save contents to cache file
        
        $cacheFilePath = $this->GetCacheFilePath();
        
        $fh = fopen($cacheFilePath, 'w');
        if ($fh)
        {
            flock($fh, LOCK_EX);
            fputs($fh, $contents);
            flock($fh, LOCK_UN);
            fclose($fh);
        }
    }
    
    //* <method name="GetCachedPage" modifiers="public"
    //* returnType="string">
    //* Get page output from cache.  Returns false if
    //* page not in cache or expired.
    //* </method>
    function GetCachedPage()
    {
        $cacheFilePath = $this->GetCacheFilePath();
        
        if (!file_exists($cacheFilePath))
        {
            return false;
        }        
        
        if (filemtime($cacheFilePath)+$this->_cacheDuration < time())
        {
            // cache expired
            return false;
        }
        
        $fh = fopen($cacheFilePath, 'r');
        if (!$fh)
        {
            return false;
        }
        $contents = "";
        while ($contentsLine = fgets($fh))
        {
            $contents .= $contentsLine;
        }
        fclose($fh);
        
        return $contents;
    }
    
    //* <method name="ClearCache" modifiers="public"
    //* returnType="void">
    //* Clears cache for specified page or all pages if no page specified.
    //* <parameter name="$pageName" type="string">
    //* Optional.  Name of page to clear cache.  
    //* If not given clears whole cache.
    //* </parameter>
    //* </method>
    function ClearCache($pageName = false)
    {
        if (!$pageName)
        {
            // clear whole cache
            
            if ($dh = opendir($this->_cacheDirectory))
            {
                while ($file = readdir($dh))
                {
                    if (ereg("\.html$", $file))
                    {
                        unlink($this->_cacheDirectory.$file);
                    }
                }                
            }
        }
        else
        {            
            // clear just specified page
            $cacheFilePath = $this->GetCacheFilePath($pageName);
            
            if (file_exists($cacheFilePath))
            {
                unlink($cacheFilePath);
            }
        }  
    }
    //// end public methods
    
    //// protected methods
    //* <method name="_GetCacheFilePath" modifiers="protected"
    //* returnType="string">
    //* Get path of cache file for current or given page.
    //* <parameter name="$pageName" type="string">
    //* Optional.  Name of page.  If not given uses name of current page.
    //* </parameter>
    //* </method>
    function _GetCacheFilePath($pageName = false)
    {
        if (!$pageName)
        {
            $page =& $this->_page;
            $pageName = $page->get_PageName();
        }
        // get page name without leading / or \ and .php extension
        $pageName = ereg_replace('^[/\](.*)\.php', '\1', $pageName); 
        $safePageName = $this->_FileSystemSafeName($pageName);
        $cacheDirectory = $this->_cacheDirectory;
        
        return $cacheDirectory.$safePageName.'.html';
    }
    
    //* <method name="_FileSystemSafeName" modifiers="protected"
    //* returnType="string">
    //* Encode string to be safe to use as a file or directory name.
    //* <parameter name="$name" type="string">
    //* String to encode.
    //* </parameter>
    //* </method>
    function _FileSystemSafeName($name)
    {
        $safeName = $name;
        $safeName = str_replace("~", "~0", $safeName);
        $safeName = str_replace("\\", "~1", $safeName);
        $safeName = str_replace("/", "~2", $safeName);
        $safeName = str_replace(":", "~3", $safeName);
        $safeName = str_replace("*", "~4", $safeName);
        $safeName = str_replace("?", "~5", $safeName);
        $safeName = str_replace("\"", "~6", $safeName);
        $safeName = str_replace("<", "~7", $safeName);
        $safeName = str_replace(">", "~8", $safeName);
        $safeName = str_replace("|", "~9", $safeName);
        // replace a few non-essentials too
        $safeName = str_replace(" ", "~A", $safeName);
        $safeName = str_replace(".", "~B", $safeName);
        return $safeName;
    }
    
    //* <method name="_GetNameFromFileSystemSafeName" modifiers="protected"
    //* returnType="string">
    //* Decode string previously encoded with _FileSystemSafeName()
    //* <parameter name="$safeName" type="string">
    //* String to decode.
    //* </parameter>
    //* </method>
    function _GetNameFromFileSystemSafeName($safeName)
    {
        $name = $safeName;
        $name = str_replace("~1", "\\", $name);
        $name = str_replace("~2", "/", $name);
        $name = str_replace("~3", ":", $name);
        $name = str_replace("~4", "*", $name);
        $name = str_replace("~5", "?", $name);
        $name = str_replace("~6", "\"", $name);
        $name = str_replace("~7", "<", $name);
        $name = str_replace("~8", ">", $name);
        $name = str_replace("~9", "|", $name);
        $name = str_replace("~A", " ", $name);
        $name = str_replace("~B", ".", $name);
        $name = str_replace("~0", "~", $name);
        return $name;
    }
    
    //* <method name="_TidyDirName" modifiers="protected"
    //* returnType="string">
    //* Clean up directory name to consistently use OS specific directory
    //* separator and ensure terminated by directory separator.
    //* <parameter name="$safeName" type="string">
    //* String to decode.
    //* </parameter>
    //* </method>
    function _TidyDirName($dirName)
    {
        $tidyDirName = $dirName;
        $tidyDirName = ereg_replace('[\/]', DIRECTORY_SEPARATOR, $tidyDirName);
        if (!ereg('\\'.DIRECTORY_SEPARATOR.'$', $tidyDirName))
        {
            $tidyDirName .= DIRECTORY_SEPARATOR;
        }
        
        return $tidyDirName;
    }
    //// end protected methods
}