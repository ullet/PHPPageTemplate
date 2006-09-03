<?php
include_once("TestPageTemplate.php");
include_once("PageBase.php");

class IndexPageCode extends PageBase
{
    // protected overridden methods
    function _Initialise()
    {
        parent::_Initialise();
        $pageTemplate =& new TestPageTemplate();
        $pageTemplate->set_Page($this);
        $pageTemplate->set_Title("Page Template Test");        
        $pageTemplate->set_Heading("A Page Template Test");
        $this->_set_PageTemplate($pageTemplate);
        $this->_RegisterPlaceHolder("ph1", "PlaceHolder_ph1");
        $this->_RegisterPlaceHolder("ph2", "PlaceHolder_ph2");        
    }
     
    // protected methods
    function _DoPlaceHolderTest()
    {
        echo "This is a test.";
    }
}
?>