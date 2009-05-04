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