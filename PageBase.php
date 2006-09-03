<?php
include_once("PageTemplateBase.php");
class PageBase // abstract
{
    var $_pageTemplate;    
    var $_placeHolderfunctions;
    
    // protected methods
    function _RegisterPlaceHolder($placeHolderName, $functionName)
    {
        $this->_placeHolderfunctions[$placeHolderName] = $functionName;
    }
    
    function _set_PageTemplate(&$pageTemplate)
    {
        $this->_pageTemplate =& $pageTemplate;
    }
    
    function _Initialise()
    {
        $this->_placeHolderfunctions = array();
    }
    
    // public methods
    function Render()
    {
        $this->_Initialise();
        $this->_pageTemplate->Render();       
    }
    
    function GetFunctionForPlaceHolder($placeHolderName)
    {
        if (!in_array($placeHolderName, 
            array_keys($this->_placeHolderfunctions)))
        {
            return "";
        }
        return $this->_placeHolderfunctions[$placeHolderName];
    }
}
?>