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
 * Class to iterator over a list (indexed array) of objects.
 *
 * Iterated list may contain any type of object.  Can either be used to simply loop over the
 * objects in the list, in which case no advantage over standard array functions, or can access
 * properties or call a parameterless method on the object as iterate over the list, returning
 * the property/method value rather than the object.  Additionally a function reference can be
 * given to perform additional processing on the object/property/method value and return the
 * processed value.  The main advantage of this is that it compacts all the logic into a single
 * function call. 
 */
class ListIterator
{
    /**
     * Current item in list.
     */
    private $_currentItem = false;
    /**
     *Index of current item in list.
     */
    private $_currentItemIndex = -1;
    /**
     * List of items.
     */
    private $_list = false;
    
    public function __constructor(array $list)
    {
        $this->_list = array();
        if (!is_null($list))
        {
            foreach ($list as $item)
            {
                $this->_list[] = $item;
            }
        }
    }
    
    //// public methods
    /**
     * Move to next item in list.
     */
    public function NextItem()
    {
        $this->_currentItemIndex ++;
        
        if ($this->_currentItemIndex >= count($this->_list))
        {
            $this->_currentItem = false;
            return false;
        }
        $this->_currentItem = $this->_list[$this->_currentItemIndex];
        return true;
    }
    
    //* <method name="CurrentItem" modifiers="public" returnType="object">
    //* Get current item or property of current item in list
    //* <parameter name="$object" type="object">
    //* Object against which $evalFunction is evaluated
    //* </parameter>
    //* <parameter name="$item" type="string">
    //* Name of class variable in this class containing 'current item' object
    //* </parameter>
    //* <parameter name="$property" type="string">
    //* Name of property/method on current item to be evaluated
    //* </parameter>
    //* <parameter name="$evalFunction" type="string">
    //* Optional name of function on $object to be called to perform additional
    //* processing on the current item/value of current item $property
    //* </parameter>
    //* </method>
    public function CurrentItem($object, $item, $property, $evalFunction = false)
    {
        if (!$evalFunction && !$property)
        {
            return $this->$item;
        }
        
        if (!$evalFunction && !is_object($this->$item))
        {
            return false;
        }
        
        $method = $property;
        if ($method)
        {
            if (!method_exists($this->$item, $method))
            {
                $method = "get_".$property;
            }
        }
        if ($method && !method_exists($this->$item, $method))
        {
            $value = false;
        }
        else
        {
            if (!$method)
            {
                $value = $this->$item;
            }
            else
            {
                $value = $this->$item->$method();
            }
        }
        if ($evalFunction)
        {
            if (substr($evalFunction,0,5) != "\$this")
            {
                if ($object && method_exists($object, $evalFunction))
                {
                    $evalFunction = "\$object->$evalFunction";
                }
                if (method_exists($this, $evalFunction))
                {
                    $evalFunction = "\$this->$evalFunction";
                }
                else if (method_exists($this->$item, $evalFunction))
                {
                    $evalFunction = "\$this->\$item->$evalFunction";
                }
            }
            eval("\$value=$evalFunction(\$value);");
        }
        else if (!is_scalar($value))
        {
            if (is_object($value))
            {
                if (method_exists($value, 'ToString'))
                {
                    $value = $value->ToString();
                }
            }
        }
        return $value;
    }
    
    //* <method name="CurrentListItem" modifiers="public" returnType="object">
    //* Get current item or property of current item in list
    //* <parameter name="$object" type="object">
    //* Object against which $evalFunction is evaluated
    //* </parameter>
    //* <parameter name="$property" type="string">
    //* Optional name of property/method on current item to be evaluated
    //* </parameter>
    //* <parameter name="$evalFunction" type="string">
    //* Optional name of function on $object to be called to perform additional
    //* processing on the current item/value of current item $property
    //* </parameter>
    //* </method>
    public function CurrentListItem($object = false, $property = false, $evalFunction = false)
    {
        return $this->CurrentItem($object, "_currentItem", $property, $evalFunction);
    }
    //// End public methods
}
?>