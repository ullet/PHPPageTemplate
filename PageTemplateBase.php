<?php
include_once("PageBase.php");
class PageTemplateBase // abstract
{
    // private members
    var $_page; // as PageBase
    var $_title = "Untitled page";
    
    // public accessors
    function get_EncodedTitle()
    {
       return htmlentities($this->_title);
    }
    
    function get_Title()
    {
       return $this->_title;
    }
    
    function set_Title($title)
    {
        $this->_title = trim($title);
    }
    
    function &get_Page()
    {
        return $this->_page;
    }
    
    function set_Page(&$page)
    {
        $this->_page =& $page;
    }
    
    
    // public methods
    function Render() 
    {
        $this->Initialise();
        $this->RenderContent();        
    }
    
    // abstract public methods
    function Initialise() // abstract
    {
    }
    
    function RenderContent() // abstract
    {
    }
    
    // protected methods
    function _RenderPlaceHolder($name)
    {
        if ($this->_page)
        {
            $functionName = $this->_page->GetFunctionForPlaceHolder($name);
            if ($functionName != "")
            {
                $this->_page->$functionName();
            }
        }
    }
}
?>