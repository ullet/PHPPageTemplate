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

require_once "FilterDataByType.php";

/**
 * XML parser to parse simple XML documents with up to two levels of elements below root.  
 *
 * Parses XML document to a data structure of nested arrays.  Outer array is an indexed array with
 * one value for each direct child of the root element ('type element').  The value is an 
 * associative array with three keys 'type', 'attributes', and 'properties'.  Attributes and
 * properties are in turn associative arrays, keys and values of which are read from the XML
 * document, attribute keys and values are from the attributes of the type element, property keys
 * and values are from the element names and values of the type elements children ('property 
 * elements').
 *  
 * Type elements can have attributes and any number of child elements but any character data not 
 * within a child element will be ignored (i.e. don't have a simple value).  Attribute names should
 * be unique for a given type element, duplicates are handled as 'last one wins'.  Type element 
 * names can be any valid name.  The element name is used as the value for the 'type' key in the 
 * parsed data structure. 
 *
 * Property elements should contain only character data.  Any attributes and child elements of 
 * propery elements will be ignored.  Property element names can be any valid name but should be
 * unique for a given parent type element, duplicates are handled as 'last one wins'.
 
 * The root element name can be any valid name.  The root element is required to make the document
 * well formed but is otherwise ignored and not saved to the parsed data structure.
 */
class SimpleParser
{
    private $parsedData = NULL;
    private $allData = NULL;
    private $dataPath = NULL;
    private $currentElementDepth = 0;
    private $currentItem = NULL;
    private $currentProperty = NULL;
    
    /**
     * Creates an instance of the SimpleParser class setting path of the XML data to be parsed.
     */
    public function __Construct($dataPath)
    {
        $this->dataPath = $dataPath;
    }
    
    /**
     * Gets all parsed data in a nested array structure.
     */
    public function GetAllData()
    {
        // By default arrays are returned by value, so returned data is a copy.  All nested arrays
        // are copied by value also.  Only objects in the array will be copied by reference.  In
        // this case there shouldn't ever be any objects.
        
        if (is_null($this->parsedData))
        {
            $this->Parse();
        }
        
        return $this->parsedData;
    }
    
    /**
     * Gets all parsed data of a specific type in a nested array structure.
     */
    public function GetDataOfType($type)
    {
        return $this->GetFilteredData(new FilterDataByType($type));
    }  
    
    /**
     * Gets filtered parsed data in a nested array structure.
     *
     * Returns data structure contain just those items that pass the filtering rule or rules 
     * defined by given instance of a class implementing the Filter interface.
     */    
    protected function &GetFilteredData(Filter $filter)
    {
        if (is_null($this->parsedData))
        {
            $this->Parse();
        }
        
        // array_values used to reset indexes - array_filter leaves 'holes'
        return array_values(
            array_filter($this->parsedData, array($filter, "Filter")));
    }
    
    /**
     * Parses the XML document in the file given in the constructor.
     */
    protected function Parse()
    {
        $this->Reset();             
        
        if (is_null($this->dataPath) || !file_exists($this->dataPath))
        {
            return;            
        }
        
        $fp = fopen($this->dataPath, "r");
        if (!$fp)
        {
            return;
        }
        
        $dataXml = "";
        while ($dataBlock = fread($fp, 102400))
        {
            $dataXml .= $dataBlock;
        }
        fclose($fp);
        
        $this->ParseXml($dataXml);
    }
    
    /**
     * Parses the XML document given in the string parameter value.
     */
    protected function ParseXml($dataXml)
    {
        $parser = xml_parser_create();
        xml_set_object($parser, $this);
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, false);
        xml_set_element_handler($parser, 'StartElementHandler', 'EndElementHandler');
        xml_set_character_data_handler($parser, 'CharacterDataHandler');
                                
        if (!xml_parse($parser, $dataXml))
        {
            // do some error handling
        }
    }
    
    /**
     * Initialises parsing properties ready to starting parsing XML document.
     */  
    protected function Reset()
    {
        $this->currentElementDepth == 0;
        $this->currentItem = NULL;
        $this->currentProperty = NULL;
        $this->parsedData = array();
    }
    
    /**
     * Method passed to 'xml_parser' for the 'start element handler' callback.
     */
    protected function StartElementHandler($parser, $elementName, &$attributes)
    {
        if ($this->currentElementDepth == 1) // top level (non-root) element            
        {
            $this->currentItem = array();
            $this->currentItem["type"] = $elementName;
            $this->currentItem["attributes"] = array();
            foreach (array_keys($attributes) as $attributeName)
            {
                $this->currentItem["attributes"][$attributeName] =
                    $attributes[$attributeName];
            }
            $this->currentItem["properties"] = array();
        }
        if ($this->currentElementDepth == 2) // "property level"
        {
            $this->currentProperty = $elementName;
        }
        // ignore any elements of depth > 2
        
        $this->currentElementDepth ++;        
    }
        
    /**
     * Method passed to 'xml_parser' for the 'character data handler' callback.
     */
    protected function CharacterDataHandler($parser, $cdata)
    {
        if ($this->currentElementDepth == 3) // "property level" element data
        {
            $this->currentItem["properties"][$this->currentProperty] = trim($cdata);
        }
    }
    
    /**
     * Method passed to 'xml_parser' for the 'end element handler' callback.
     */
    protected function EndElementHandler($parser, $elementName)
    {
        $this->currentElementDepth --;
        
        if ($this->currentElementDepth == 2) // "property level"
        {
            $this->currentProperty = NULL; 
        }
        
        if ($this->currentElementDepth == 1) // "property level"
        {
            $this->parsedData[] = $this->currentItem;
            $this->currentItem = NULL; 
        }
    }
}
 
?>