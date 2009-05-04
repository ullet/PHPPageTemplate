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
 * Common interface for filter classes, particularly for use with array_filter.
 *
 * A class implementing the Filter interface can use additional parameters to filter the data in
 * the array, something which is not possible with a regular callback function.  (Of course could
 * use a class property of the class defining the callback function which in some cases is fine,
 * but this helps keep the class 'clean' avoiding creating class scoped properties for variables
 * that are only needed within a single method.
 */
interface Filter
{
    /**
     * Filter given value against rule(s) defined in implementing class.
     *
     * Implementing class applies one or more rules to filter the given value.  The value could
     * be a simple value, e.g. a string, an array, or any type of object.  The return value must
     * be true if the test value is "in" or false if the test value is "out".  The filter method
     * can use any other methods or properties on the implementing class to define the filtering
     * rule or rules, which could include values passed in a constructor (this is the advantage 
     * of an instance method over a static method).
     */
    function Filter($value);
}

?>