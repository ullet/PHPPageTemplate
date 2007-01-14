<?php
/*
 *************************************************************************
 * PHPPageTemplate: A PHP4 page templating system.                       *
 * Version 0.2.0 (14 January 2007)                                       *
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
    //* <property name="_cacheDuration" modifiers="private" type="int">
    //* Set duration for page to be cached
    //* </property>    
    var $_cacheDuration = 0;
    //* <property name="_cacheParameters" modifiers="private" type="string">
    //* Comma separated list of querystring parameter names to vary cache.
    //* Output for different values of the parameter will be cached separately.
    //* </property>
    var $_cacheParameters = "";
    //* <property name="_cacheParameters" modifiers="private" type="string[]">
    //* Array of querystring parameter names to vary cache.
    //* Output for different values of the parameter will be cached separately.
    //* </property>
    var $_cacheParametersArray = false;
    //* <property name="_cacheDirectory" modifiers="private" type="string">
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
        
        $this->set_CacheDuration($cacheDuration);
        
        $this->set_cacheParameters($cacheParameters);
    }
    //// end constructors
    
    //// public accessor methods
    //* <method name="set_CacheParameters" modifiers="public" returnType="void">
    //* Set parameter list for cache to be varied by.
    //* <parameter name="$cacheParameters" type="string">
    //* Parameter list as comma separated string.
    //* </parameter>
    //* </method>
    function set_CacheParameters($cacheParameters)
    {
        if ($cacheParameters && $cacheParameters != "")
        {
            $this->_cacheParametersArray = split(',',$cacheParameters);
            $this->_cacheParameters = $cacheParameters;
        }
        else
        {
            $this->_cacheParametersArray = array();
        }
    }
    
    //* <method name="set_CacheDuration" modifiers="public" returnType="void">
    //* Set duration to cache page.
    //* <parameter name="$cacheDuration" type="int">
    //* Duration in seconds.
    //* </parameter>
    //* </method>
    function set_CacheDuration($cacheDuration)
    {
        if ($cacheDuration && $cacheDuration > 0)
        {
            $this->_cacheDuration = $cacheDuration;
        }
    }
    //// end public accessor methods
    
    //// public methods
    //* <method name="CachePage" modifiers="public" returnType="void">
    //* Saves page output to cache.
    //* </method>
    function CachePage()
    {
        if ($this->_cacheDuration <= 0)
        {
            // cache will be immediately invalid so don't waste time caching page
            return;
        }
        
        $contents = ob_get_contents();
        // save contents to cache file
        
        $cacheFilePath = $this->_GetNewCacheFilePath();
        
        if ($cacheFilePath != "" && 
            $cacheFilePath != $this->_cacheDirectory &&
            $fh = fopen($cacheFilePath, 'w'))
        {
            flock($fh, LOCK_EX);
            fputs($fh, $contents);
            flock($fh, LOCK_UN);
            fclose($fh);
        }
    }
    
    //* <method name="GetCachedPage" modifiers="public" returnType="string">
    //* Get page output from cache.  Returns false if
    //* page not in cache or expired.
    //* </method>
    function GetCachedPage()
    {
        $cacheFilePath = $this->_GetCacheFilePath();
        
        if ($cacheFilePath == "" ||
            $cacheFilePath == $this->_cacheDirectory || 
            !file_exists($cacheFilePath))
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
    
    //* <method name="ClearCache" modifiers="public" returnType="void">
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
                    if (ereg("\.(html)|(cache)$", $file))
                    {
                        unlink($this->_cacheDirectory.$file);
                    }
                }                
            }
        }
        else
        {            
            // clear just specified page
            // delete all files given in list
            $cacheFilePaths = $this->_GetCacheFilePathsForPage($pageName);            
            for($idx=0; $idx<count($cacheFilePaths); $idx++)
            {
                if ($cacheFilePaths[$idx] != "" && 
                    $cacheFilePaths[$idx] != $this->_cacheDirectory &&
                    file_exists($cacheFilePaths[$idx]))
                {
                    unlink($cacheFilePaths[$idx]);
                }
            }
            
            // delete list file
            $cacheListFilePath = $this->_GetCacheListFilePath($pageName);            
            if ($cacheListFilePath != "" && 
                $cacheListFilePath != $this->_cacheDirectory &&
                file_exists($cacheListFilePath))
            {
                unlink($cacheListFilePath);
            }
        }  
    }
    //// end public methods
    
    //// protected methods
    //* <method name="_GetNewCacheFilePath" modifiers="protected" returnType="string">
    //* Get path of cache file for current or given page.
    //* <parameter name="$pageName" type="string">
    //* Optional.  Name of page.  If not given uses name of current page.
    //* </parameter>
    //* </method>
    function _GetNewCacheFilePath($pageName = false)
    {
        if (!$pageName)
        {
            $page =& $this->_page;
            $pageName = $page->get_PageName();
        }
        
        $existingCacheFilePath = $this->_GetCacheFilePath($pageName);
        
        if ($existingCacheFilePath != "" &&
            $existingCacheFilePath != $this->_cacheDirectory)
        {
            return $existingCacheFilePath;
        }   
        
        // get page name without leading / or \ and .php extension
        $safePageName = ereg_replace('^[/\](.*)\.php', '\1', $pageName); 
        $safePageName = $this->_FileSystemSafeName($safePageName);
        $cacheDirectory = $this->_cacheDirectory;
        
        $cacheFilePathBase = $cacheDirectory.$safePageName;
        $cacheFilePath = $cacheFilePathBase.'.html';
        $counter = 0;
        while (file_exists($cacheFilePath))
        {
            $counter++;
            $cacheFilePath = "$cacheFilePathBase.$counter.html";
        }        
        
        $this->_AddCacheFilePathToList($cacheFilePath);
        
        return $cacheFilePath;
    }
    
    //* <method name="_AddCacheFilePathToList" modifiers="protected" returnType="bool">
    //* Added cache file to cache file list for page.
    //* <parameter name="$cacheFilePath" type="string">
    //* Path of cache file to be added to list.
    //* </parameter>
    //* <parameter name="$pageName" type="string">
    //* Optional.  Name of page.  If not given uses name of current page.
    //* </parameter>
    //* </method>
    function _AddCacheFilePathToList($cacheFilePath, $pageName = false)
    {
        if (!$pageName)
        {
            $page =& $this->_page;
            $pageName = $page->get_PageName();
        }
        
        $cacheListFilePath = $this->_GetCacheListFilePath($pageName);
                
        $fh = fopen($cacheListFilePath, 'a');
        if (!$fh)
        {
            return false;
        }
        
        if ($this->_cacheParametersArray)
        {
            foreach ($this->_cacheParametersArray as $paramKey)
            {
                if (!array_key_exists($paramKey, $_GET))
                {
                    fputs($fh, "Parameter:$paramKey=\r\n");
                }
                else
                {
                    fputs($fh, "Parameter:$paramKey=".$_GET[$paramKey]."\r\n");
                }
            }
        }
        $shortCacheFilePath = str_replace($this->_cacheDirectory, "", $cacheFilePath);
        fputs($fh, "CacheFile:$shortCacheFilePath\r\n");
        fclose($fh);
        
        return true;
    }
    
    //* <method name="_GetCacheFilePathsForPage" modifiers="protected" returnType="string[]">
    //* Get list of cache file paths for page.
    //* <parameter name="$pageName" type="string">
    //* Optional.  Name of page.  If not given uses name of current page.
    //* </parameter>
    //* </method>
    function _GetCacheFilePathsForPage($pageName = false)
    {
        if (!$pageName)
        {
            $page =& $this->_page;
            $pageName = $page->get_PageName();
        }
        $cacheListFilePath = $this->_GetCacheListFilePath($pageName);
        if (!file_exists($cacheListFilePath))
        {
            return false;
        }
        
        $fh = fopen($cacheListFilePath, 'r');
        if (!$fh)
        {
            return "";
        }
        $cacheFiles = array();
        
        while ($line = fgets($fh))
        {
            $line = ltrim(rtrim($line));
            if (ereg('^CacheFile:(.*)$', $line, $matches))
            {
                $cacheFiles[] = $this->_cacheDirectory.$matches[1];
            }
        }
        
        fclose($fh);
        
        return $cacheFiles;
    }
    
    //* <method name="_GetCacheFilePath" modifiers="protected" returnType="string">
    //* Get path cache file for previously cached page.
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
        $cacheListFilePath = $this->_GetCacheListFilePath($pageName);
        if (!file_exists($cacheListFilePath))
        {
            return "";
        }
        
        $fh = fopen($cacheListFilePath, 'r');
        if (!$fh)
        {
            return "";
        }
        $cacheFilePath = "";
        $parameters = array();
        while ($line = fgets($fh))
        {
            $line = ltrim(rtrim($line));
            if (ereg('^Parameter:(.*)$', $line, $matches))
            {
                $keyValue = split('=', $matches[1]);
                
                $key = $keyValue[0];
                if (count($keyValue) == 1)
                {
                    $value = "";
                }
                else if (count($keyValue) > 2)
                {
                    // value contained 1 or more "=" so need to join value
                    // back together
                    $value = join("=", array_slice($keyValue, 1));
                }
                else
                {
                    $value = $keyValue[1];
                }
                $parameters[$key] = $value;
            }
            else if (ereg('^CacheFile:(.*)$', $line, $matches))
            {
                $paramMatch = true;
                if (count($parameters) != count($this->_cacheParametersArray))
                {
                    $paramMatch = false;
                }
                else
                {
                    foreach (array_keys($this->_cacheParametersArray) as $exkey)
                    {
                        if (!array_key_exists($exKey, $parameters))
                        {
                            $paramMatch = false;
                            break;
                        }
                    }
                    if ($paramMatch)
                    {
                        // always match if no parameters
                        if (count($parameters) > 0)
                        {
                            foreach (array_keys($parameters) as $key)
                            {
                                if (!array_key_exists($key, $_GET))
                                {
                                    // no parameter treated same as blank parameter
                                    if ($parameters[$key] != "")
                                    {
                                        $paramMatch = false;
                                        break;
                                    }
                                }
                                else if ($_GET[$key] != $parameters[$key])
                                {
                                    $paramMatch = false;
                                    break;
                                }
                            }
                        }
                    }
                }
                if ($paramMatch)
                {
                   $cacheFilePath = ltrim($matches[1]);
                   $cacheFilePath = rtrim($cacheFilePath);
                   break;
                }
                else
                {
                    // reset parameter list
                    $parameters = array();
                }                        
            }
        }
        fclose($fh);
        return $this->_cacheDirectory.$cacheFilePath;
    }
    
    //* <method name="_GetCacheListFilePath" modifiers="protected" returnType="string">
    //* Get path of cache list file for page
    //* <parameter name="$pageName" type="string">
    //* Optional.  Name of page.  If not given uses name of current page.
    //* </parameter>
    //* </method>
    function _GetCacheListFilePath($pageName = false)
    {
        if (!$pageName)
        {
            $page =& $this->_page;
            $pageName = $page->get_PageName();
        }
        // get page name without leading / or \ and .php extension
        $safePageName = ereg_replace('^[/\](.*)\.php', '\1', $pageName); 
        $safePageName = $this->_FileSystemSafeName($safePageName);
        $cacheDirectory = $this->_cacheDirectory;
        
        return $cacheDirectory.$safePageName.'.cache';
    }
    
    //* <method name="_FileSystemSafeName" modifiers="protected" returnType="string">
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
    
    //* <method name="_GetNameFromFileSystemSafeName" modifiers="protected" returnType="string">
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
    
    //* <method name="_TidyDirName" modifiers="protected" returnType="string">
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