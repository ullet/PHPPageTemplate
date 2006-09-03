<?php
include_once("PageTemplateBase.php");
class TestPageTemplateCode extends PageTemplateBase
{    
    // private member variables
    var $_heading = "";
    
    // public accessors
    function get_Heading()
    {
        if ($this->_heading == "")
        {
            return $this->_title;
        }
        else
        {
            return $this->_heading;
        }
    }
    
    function get_EncodedHeading()
    {
        if ($this->_heading == "")
        {
            return $this->get_EncodedTitle();
        }
        else
        {
            return htmlentities($this->_heading);
        }
    }
    
    function set_Heading($heading)
    {
        $this->_heading = trim($heading);
    }     
    
    // public overridden methods
    function Initialise()
    {
        parent::Initialise();
    }   
}