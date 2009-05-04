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

/**
 * Class to filter elements of an array by the elements "attributes".
 *
 * Filters elements of an array of data in format output by SimpleParser GetAllData method
 * by the "attributes" field of the element.
 */
class FilterDataByAttributes implements Filter
{
    private $attributeSpec;
 
    /**
     * Creates an instance of the filter.
     *
     * Creates an instance of the filter taking a single $attributeSpec parameter which will be used
     * to filter the data.  The attribute spec is an associative array specifying attribute names 
     * and values to look for.  A NULL value is used to indicate match any value.
     */  
    public function __construct($attributeSpec)
    {
        $this->attributeSpec = $attributeSpec;
    }
    
    /**
     * Filter given value returning true if has required attributes, false otherwise.
     */
    public function Filter($value)
    {
        $include = true;
        foreach (array_keys($this->attributeSpec) as $requiredAttribute)
        {
            if (!array_key_exists($requiredAttribute, $value["attributes"]))
            {
                $include = false;
                break;
            }
            if (!is_null($this->attributeSpec[$requiredAttribute]) &&
                $this->attributeSpec[$requiredAttribute] != 
                    $value["attributes"][$requiredAttribute])
            {
                $include = false;
                break;
            }
        }
        
        return $include;
    }
}

?>