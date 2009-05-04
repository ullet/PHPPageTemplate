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
 * Class to filter elements of any array by the elements "type".
 *
 * Filters elements of an array of data in format output by SimpleParser GetAllData method
 * by the "type" field of the element.
 */
class FilterDataByType implements Filter
{
    private $type;
 
    /**
     * Creates an instance of the filter.
     *
     * Creates an instance of the filter taking a single type parameter which will be used to 
     * filter the data.
     */  
    public function __construct($type)
    {
        $this->type = $type;
    }
    
    /**
     * Filter given value returning true if of required "type", false otherwise.
     */
    public function Filter($value)
    {
        return $value["type"] == $this->type;
    }
}