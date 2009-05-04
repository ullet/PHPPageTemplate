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
 
require_once "Interfaces.php";
 
//* <class name="SimpleTheme" modifiers="public">
//* A basic page theme type with all custom theme properties accessed via one
//* simple accessor method.
//* <remarks>
//* This simple Theme implementation is mostly provided as an example.  It can
//* be used if really wanted but better to use a more specific implementation.
//* </remarks>
//* </class>
class SimpleTheme implements Theme
{
    //// private member variables
    private $id = NULL;
    private $properties = NULL;
    private $propertiesClone = NULL;
    //// end private member variables
    
    //// constructors
    //* <constructor modifiers="public">
    //* Create instance of SimpleTheme.
    //* <parameter name="$name" type="string">
    //* Name of theme.
    //* </parameter>
    //* <parameter name="$properites" type="hash">
    //* Associative array of custom properties.
    //* </parameter>
    //* </constructor>
    public function __construct($id, $properties=NULL)
    {
        $this->id = $id;
        $this->properties = array();
        if (!is_null($properties) && is_array($properties))
        {
            foreach($properties as $propertyName)
            {
                $this->properties[$propertyName] = $property[$propertyName];
            }
        }
    }
    //// end constructors
    
    //// Theme interface members
    public function ID()
    {
        return $this->id;
    }
    //// End Theme interface members
    
    //// public methods
    public function GetProperty($name)
    {
        if (is_null($this->properties) || 
            !is_array($this->properties) || 
            !array_key_exists($name, $this->properties))
        {
            return NULL;
        }
        return $this->properties[$name];
    }
    
    /**
     * Get all custom properties of theme as an associative array.
     */
    public function GetAllProperties()
    {
        if (is_null($this->propertiesClone))
        { 
            $this->propertiesClone = array();
            foreach (array_keys($this->properties) as $name)
            {
                $this->propertiesClone[$name] = $this->properties[$name];
            } 
        }
        return $this->propertiesClone;
    }
    //// end public methods
}
?>
