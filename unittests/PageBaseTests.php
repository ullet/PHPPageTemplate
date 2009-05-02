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
 
require_once "PHPUnit/Framework.php";
require_once "Mocks.php";

//* <class name="PageBaseTests" modifiers="public">
//* A selection of unit tests for PageBase
//* </class>
class PageBaseTests extends PHPUnit_Framework_TestCase
{
    public function test_Create_Page()
    {
        $page = $this->CreatePage();

        $this->assertNotNull($page, "Expected page object");
    }
    
    public function test_Create_Template()
    {
        $template = $this->CreateTemplate();

        $this->assertNotNull($template, "Expected template object");
    }
    
    public function test_Get_Page_Title_Single_Page()
    {
        $page = $this->CreatePage();
        $page->set_Title("The Page");

        $this->assertEquals("The Page", $page->get_Title());
    }
    
    public function test_Get_Page_Title_Templated_Page()
    {
        $page = $this->CreatePage();
        $template = $this->CreateTemplate();
        $page->set_Title("The Page");
        $template->set_Title("The Template");
        $this->assertEquals("The Page", $page->get_Title());
        $this->assertEquals("The Template", $template->get_Title());
        $template->set_Page($page);

        // now that page is set template title should be same as page
        $this->assertEquals("The Page", $page->get_Title(), "Incorrect page title");
        $this->assertEquals("The Page", $template->get_Title(), "Incorrect template title");
    }  
    
    public function test_Get_Page_Title_Nested_Templated_Page()
    {
        // Page and template titles are independent until the using page is set for a template, at
        // which point the titles become linked, the template taking on the title of the page.
        $page = $this->CreatePage();
        $template1 = $this->CreateTemplate();
        $template2 = $this->CreateTemplate();
        $template3 = $this->CreateTemplate();
        $page->set_Title("The Page");
        $template1->set_Title("Template 1");
        $template2->set_Title("Template 2");
        $template3->set_Title("Template 3");

        // page and templates not (yet) related so titles independent
        $this->assertEquals("The Page", $page->get_Title(), "Wrong page title (unlinked)");
        $this->assertEquals(
            "Template 1", 
            $template1->get_Title(), 
            "Wrong title for template 1 (unlinked)");
        $this->assertEquals(
            "Template 2", 
            $template2->get_Title(),
            "Wrong title for template 2 (unlinked)");
        $this->assertEquals(
            "Template 3", 
            $template3->get_Title(),
            "Wrong title for template 3 (unlinked)");

        $template1->set_Page($template2);

        $this->assertEquals("The Page", $page->get_Title(), "Wrong page title (linked 1<-2)");
        $this->assertEquals(
            "Template 2", 
            $template1->get_Title(), 
            "Wrong title for template 1 (linked 1<-2)");
        $this->assertEquals(
            "Template 2", 
            $template2->get_Title(),
            "Wrong title for template 2 (linked 1<-2)");
        $this->assertEquals(
            "Template 3", 
            $template3->get_Title(),
            "Wrong title for template 3 (linked 1<-2)");

        $template2->set_Page($template3);

        $this->assertEquals(
            "The Page", 
            $page->get_Title(), 
            "Wrong page title (linked 1<-2<-3)");
        $this->assertEquals(
            "Template 3", 
            $template1->get_Title(), 
            "Wrong title for template 1 (linked 1<-2<-3)");
        $this->assertEquals(
            "Template 3", 
            $template2->get_Title(),
            "Wrong title for template 2 (linked 1<-2<-3)");
        $this->assertEquals(
            "Template 3", 
            $template3->get_Title(),
            "Wrong title for template 3 (linked 1<-2<-3)");

        $template3->set_Page($page);

        // now that page is set all template titles should be same as page
        $this->assertEquals(
            "The Page", 
            $page->get_Title(), 
            "Wrong page title (linked 1<-2<-3<-page)");
        $this->assertEquals(
            "The Page", 
            $template1->get_Title(), 
            "Wrong title for template 1 (linked 1<-2<-3<-page)");
        $this->assertEquals(
            "The Page", 
            $template2->get_Title(),
            "Wrong title for template 2 (linked 1<-2<-3<-page)");
        $this->assertEquals(
            "The Page", 
            $template3->get_Title(),
            "Wrong title for template 3 (linked 1<-2<-3<-page)");
    } 
    
    public function test_CallFunctionForPlaceHolder()
    {
        $page = $this->CreatePage();
        $page->ResetPlaceHolderState();
        $page->RegisterPlaceHolderFunction("placeholder");
        $page->CallFunctionForPlaceHolder("placeholder");
        $this->assertNotNull($page->WasPlaceHolderCalled(), 
            "Place holder function not called");
        $page->ResetPlaceHolderState();
    }
    
    public function test_RenderPlaceHolder()
    {
        $page = $this->CreatePage();
        $template = $this->CreateTemplate();
        $page->set_PageTemplate($template);
        $template->set_Page($page);
        $page->ResetPlaceHolderState();
        $page->RegisterPlaceHolderFunction("placeholder");
        $template->RenderPlaceHolder("placeholder");
        $this->assertNotNull($page->WasPlaceHolderCalled(), 
            "Place holder function not called");
        $page->ResetPlaceHolderState();
    }
    
    protected function CreatePage()
    {
        // NB. MockPage extends PageBase and implements additional
        // sensing methods.  Code under test is from PageBase.
        return new MockPage();
    }
    
    protected function CreateTemplate()
    {
        // A template is just a page used a bit differently
        // NB. MockTemplate extends PageBase and implements additional
        // sensing methods.  Code under test is from PageBase.        
        return new MockTemplate();
    }
}
?>

