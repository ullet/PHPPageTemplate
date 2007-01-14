<?php
/*
 *************************************************************************
 * PHPPageTemplate: A PHP4 page templating system.                       *
 * Version 0.2.1 (14 January 2007)                                       *
 * Copyright (C) 2006-2007 Trevor Barnett                                *
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
 
require_once "phpunit.php";
require_once "MockPage.php";
require_once "MockTemplate.php";

//* <class name="PageBaseTests" modifiers="public">
//* A selection of unit tests for PageBase
//* </class>
class PageBaseTests extends TestCase
{
    function test_Create_Page()
    {
        $page =& $this->_CreatePage();
        $this->assert($page, "Expected page object");
    }
    
    function test_Create_Template()
    {
        $template =& $this->_CreateTemplate();
        $this->assert($template, "Expected template object");
    }
    
    function test_Get_Page_Title_Single_Page()
    {
        $page =& $this->_CreatePage();
        $page->set_Title("The Page");
        $this->assertEquals("The Page", $page->get_Title());
    }
    
    function test_Get_Page_Title_Templated_Page()
    {
        $page =& $this->_CreatePage();
        $template =& $this->_CreateTemplate();
        $page->set_Title("The Page");
        $template->set_Title("The Template");
        $this->assertEquals("The Page", $page->get_Title());
        $this->assertEquals("The Template", $template->get_Title());
        $template->set_Page($page);
        // now that page is set template title should be same as page
        $this->assertEquals("The Page", $page->get_Title());
        $this->assertEquals("The Page", $template->get_Title());
    }  
    
    function test_Get_Page_Title_Nested_Templated_Page()
    {
        $page =& $this->_CreatePage();
        $template1 =& $this->_CreateTemplate();
        $template2 =& $this->_CreateTemplate();
        $template3 =& $this->_CreateTemplate();
        $page->set_Title("The Page");
        $template1->set_Title("Template 1");
        $template2->set_Title("Template 2");
        $template3->set_Title("Template 3");
        $this->assertEquals("The Page", $page->get_Title());
        $this->assertEquals("Template 1", $template1->get_Title());
        $this->assertEquals("Template 2", $template2->get_Title());
        $this->assertEquals("Template 3", $template3->get_Title());
        $template1->set_Page($template2);
        $template2->set_Page($template3);
        $template3->set_Page($page);
        // now that page is set template titles should be same as page
        $this->assertEquals("The Page", $page->get_Title());
        $this->assertEquals("The Page", $template1->get_Title());
        $this->assertEquals("The Page", $template2->get_Title());
        $this->assertEquals("The Page", $template3->get_Title());
    } 
    
    function test_CallFunctionForPlaceHolder()
    {
        $page =& $this->_CreatePage();
        $page->ResetPlaceHolderState();
        $page->RegisterPlaceHolderFunction("placeholder");
        $page->CallFunctionForPlaceHolder("placeholder");
        $this->assert($page->WasPlaceHolderCalled(), 
            "Place holder function not called");
        $page->ResetPlaceHolderState();
    }
    
    function test_RenderPlaceHolder()
    {
        $page =& $this->_CreatePage();
        $template =& $this->_CreateTemplate();
        $page->set_PageTemplate($template);
        $template->set_Page($page);
        $page->ResetPlaceHolderState();
        $page->RegisterPlaceHolderFunction("placeholder");
        $template->RenderPlaceHolder("placeholder");
        $this->assert($page->WasPlaceHolderCalled(), 
            "Place holder function not called");
        $page->ResetPlaceHolderState();
    }
    
    function &_CreatePage()
    {
        $page =& new MockPage();
        return $page;
    }
    
    function &_CreateTemplate()
    {
        $template =& new MockTemplate();
        return $template;
    }
}
?>

<html>
  <head>
    <title>PHP-Unit Results</title>
  </head>
  <body>
<?php
$suite = new TestSuite("PageBaseTests");
$testRunner = new TestRunner();
$testRunner->run($suite);
?>
  </body>
</html>