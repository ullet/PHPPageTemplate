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
require_once "../framework/ThemeList.php";
require_once "../framework/CrudeThemeFactory.php";
require_once "Mocks.php";

//* <class name="ThemeListTests" modifiers="public">
//* A selection of unit tests for ThemeList
//* </class>
class ThemeListTests extends PHPUnit_Framework_TestCase
{
    //// Begin: The Tests
    public function test_Create()
    {
        $themeList = $this->CreateThemeList();
        
        $this->assertNotNull($themeList, "Expected ThemeList object");
        $this->assertEquals("test1", $themeList->get_DefaultThemeName());
    }
    
    public function test_Get_Set_CookieDuration()
    {
        $themeList = $this->CreateThemeList();
        // check default is different to what we are going to set
        // (so that can be certain it has changed)
        $this->assertNotEquals(
            60, 
            $themeList->get_CookieDuration(),
            "Default duration is equal to default value - test not valid");
        
        $themeList->set_CookieDuration(60);
        
        $this->assertEquals(60, $themeList->get_CookieDuration());
    }
    
    public function test_Get_Set_DefaultThemeName()
    {
        $themeList = $this->CreateThemeList();
        
        // check value set in constructor
        $this->assertNotEquals(
            "test2", 
            $themeList->get_DefaultThemeName(),
            "Test theme name equal to initial default theme name - test not valid");
        
        $themeList->set_DefaultThemeName("test2");
        
        $this->assertEquals("test2", $themeList->get_DefaultThemeName());
    }
    
    public function test_Get_PageRequest()
    {
        $themeList = $this->CreateThemeList();
        
        // default PageRequest should be of type PageRequest
        $this->assertTrue($themeList->get_PageRequest_ForTesting() instanceof PageRequest);
    }
    
    public function test_Set_PageRequest()
    {
        $themeList = $this->CreateThemeList();
        $pageRequest = new MockPageRequest();
        
        $themeList->set_PageRequest_ForTesting($pageRequest);
        $this->assertSame($pageRequest, $themeList->get_PageRequest_ForTesting());
    }
    
    public function test_Get_SelectedThemeName_Default()
    {
        $themeList =& $this->CreateThemeList();
        $this->assertEquals("test1", $themeList->get_SelectedThemeName());
    }
    
    public function test_Get_SelectedThemeName_FromQueryString()
    {
        $themeList =& $this->CreateThemeListWithQueryString();
        
        $this->assertEquals("qstheme", $themeList->get_SelectedThemeName());
    }
    
    public function test_Get_SelectedThemeName_FromCookie()
    {
        $themeList =& $this->CreateThemeListWithCookie();
        
        $this->assertEquals("cookietheme", $themeList->get_SelectedThemeName());
    }
    
    public function test_Get_SelectedTheme_FromQueryString()
    {
        $themeList =& $this->CreateThemeListWithQueryString();
        
        $theme = $themeList->get_SelectedTheme();
        
        $this->assertEquals("qstheme", $theme->get_Name());
    }
    
    public function test_Get_SelectedTheme_FromCookie()
    {
        $themeList =& $this->CreateThemeListWithCookie();
        
        $theme = $themeList->get_SelectedTheme();        
        $this->assertEquals("cookietheme", $theme->get_Name());
    }
    
    public function test_Get_ThemeExplicitlySelected_Default()
    {
        $themeList =& $this->CreateThemeList();
        
        $this->assertFalse($themeList->get_ThemeExplicitlySelected());
    }
    
    public function test_Get_ThemeExplicitlySelected_FromQueryString()
    {
        $themeList =& $this->CreateThemeListWithQueryString();
        
        $this->assertTrue($themeList->get_ThemeExplicitlySelected());
    }
    
    public function test_Get_ThemeExplicitlySelected_FromCookie()
    {
        $themeList =& $this->CreateThemeListWithCookie();
        
        $this->assertTrue($themeList->get_ThemeExplicitlySelected());
    }
    
    public function test_Get_ThemeInQS_Default()
    {
        $themeList =& $this->CreateThemeList();
        
        // need to call method that will set private field first
        $themeList->get_ThemeExplicitlySelected();
        
        $this->assertFalse($themeList->get_ThemeInQueryString());
    }
    
    public function test_Get_ThemeInQS_FromQuerystring()
    {
        $themeList =& $this->CreateThemeListWithQueryString();
        
        // need to call method that will set private field first
        $themeList->get_ThemeExplicitlySelected();
        
        $this->assertTrue($themeList->get_ThemeInQueryString());
    }
    
    public function test_Get_ThemeInQS_FromCookie()
    {
        $themeList =& $this->CreateThemeListWithCookie();
        
        // need to call method that will set private field first
        $themeList->get_ThemeExplicitlySelected();
        
        $this->assertFalse($themeList->get_ThemeInQueryString());
    }
    
    public function test_Get_ThemeInCookie_Default()
    {
        $themeList =& $this->CreateThemeList();
        
        // need to call method that will set private field first
        $themeList->get_ThemeExplicitlySelected();
        
        $this->assertFalse($themeList->get_ThemeInCookie());
    }
    
    public function test_Get_ThemeInCookie_FromQuerystring()
    {
        $themeList =& $this->CreateThemeListWithQueryString();
        
        // need to call method that will set private field first
        $themeList->get_ThemeExplicitlySelected();
        
        $this->assertFalse($themeList->get_ThemeInCookie());
    }
    
    public function test_Get_ThemeInCookie_FromCookie()
    {
        $themeList =& $this->CreateThemeListWithCookie();
        
        // need to call method that will set private field first
        $themeList->get_ThemeExplicitlySelected();
        
        $this->assertTrue($themeList->get_ThemeInCookie());
    }
    
    //public function test_Get_Iterator()
    //{
    //    $themeList =& $this->CreateThemeList();
    //    
    //    $iterator =& $themeList->get_Iterator();
    //    
    //    $this->assertNotNull($iterator);
    //    $this->assertTrue($iterator instanceof ListIterator);
    //    
    //    while ($iterator->NextItem())
    //    {
    //        $currentItem =& $iterator->CurrentListItem();
    //        $this->assertNotNull($currentItem);
    //        $this->assertContains("theme", $currentItem->get_Name());
    //    }
    //}
    
    public function test_Get_SelectedThemeQueryString_Default()
    {
        $themeList =& $this->CreateThemeList();
        
        $selectedTheme = $themeList->get_SelectedThemeQueryString_ForTesting();
        
        $this->assertEquals("", $selectedTheme);        
    }
    
    public function test_Get_SelectedThemeQueryString_FromQueryString()
    {
        $themeList =& $this->CreateThemeListWithQueryString();
        
        $selectedTheme = $themeList->get_SelectedThemeQueryString_ForTesting();
        
        $this->assertEquals("qstheme", $selectedTheme);        
    }
    
    public function test_Get_SelectedThemeQueryString_FromCookie()
    {
        $themeList =& $this->CreateThemeListWithCookie();
        
        $selectedTheme = $themeList->get_SelectedThemeQueryString_ForTesting();
        
        $this->assertEquals("", $selectedTheme);        
    }
    
    public function test_Get_SelectedThemeCookies_Default()
    {
        $themeList =& $this->CreateThemeList();
        
        $selectedTheme = $themeList->get_SelectedThemeCookies_ForTesting();
        
        $this->assertEquals("", $selectedTheme);        
    }
    
    public function test_Get_SelectedThemeCookies_FromQueryString()
    {
        $themeList =& $this->CreateThemeListWithQueryString();
        
        $selectedTheme = $themeList->get_SelectedThemeCookies_ForTesting();
        
        $this->assertEquals("", $selectedTheme);        
    }
    
    public function test_Get_SelectedThemeCookies_FromCookie()
    {
        $themeList =& $this->CreateThemeListWithCookie();
        
        $selectedTheme = $themeList->get_SelectedThemeCookies_ForTesting();
        
        $this->assertEquals("cookietheme", $selectedTheme);        
    }
    
    public function test_Get_ExplicitlySelectedTheme_Default()
    {
        $themeList =& $this->CreateThemeList();
        
        $selectedTheme = $themeList->get_ExplicitlySelectedTheme_ForTesting();
        
        $this->assertEquals("", $selectedTheme);        
    }
    
    public function test_Get_ExplicitlySelectedTheme_FromQueryString()
    {
        $themeList =& $this->CreateThemeListWithQueryString();
        
        $selectedTheme = $themeList->get_ExplicitlySelectedTheme_ForTesting();
        
        $this->assertEquals("qstheme", $selectedTheme);        
    }
    
    public function test_ExplicitlySelectedTheme_FromCookie()
    {
        $themeList =& $this->CreateThemeListWithCookie();
        
        $selectedTheme = $themeList->get_ExplicitlySelectedTheme_ForTesting();
        
        $this->assertEquals("cookietheme", $selectedTheme);        
    }
    
    public function test_SelectedThemeFromCollection()
    {
        $themeList =& $this->CreateThemeList();
        
        $col = array();
        $col["param1"]="value1";
        $col["theme"]="qstheme";
        $col["param2"]="value2";
        $selectedTheme = $themeList->SelectedThemeFromCollection_ForTesting($col);
        
        $this->assertEquals("qstheme", $selectedTheme);        
    }
    
    //public function test_AddTheme()
    //{
    //    $themeList =& $this->CreateThemeListNoParse();
    //    
    //    $theme1 =& new MockQSTheme();
    //    $theme2 =& new MockCookieTheme();
    //    
    //    $themeList->AddTheme_ForTesting($theme1);
    //    $themeList->AddTheme_ForTesting($theme2);
    //    
    //    $iterator =& $themeList->get_Iterator();
    //    
    //    $this->assertNotNull($iterator);
    //    $this->assertTrue($iterator instanceof ListIterator);
    //    
    //    $idx = 0;
    //    while ($iterator->NextItem())
    //    {
    //        $currentItem =& $iterator->CurrentListItem();
    //        $this->assertNotNull($currentItem);
    //        if ($idx == 0)
    //        {
    //            $this->assertSame($theme1, $currentItem, "Theme 1 not same as current item");
    //        }
    //        if ($idx == 1)
    //        {
    //            $this->assertSame($theme2, $currentItem, "Theme 2 not same as current item");
    //        }
    //        $idx++;
    //    }
    //    $this->assertEquals(2, $idx);
    //}
    
    //public function test_ParseThemes()
    //{
    //    $themeList =& $this->CreateThemeListNoParse();
    //    
    //    $this->assertFileExists("testthemeconfig.xml");
    //    $themeList->ParseThemes_ForTesting("testthemeconfig.xml");
    //    
    //    $iterator =& $themeList->get_Iterator();
    //    
    //    $this->assertNotNull($iterator);
    //    $this->assertTrue($iterator instanceof ListIterator);
    //    
    //    $idx = 0;
    //    while ($iterator->NextItem())
    //    {
    //        $currentItem =& $iterator->CurrentListItem();
    //        $this->assertNotNull($currentItem);
    //        $this->assertTrue($currentItem instanceof Theme);
    //        if ($idx == 0)
    //        {
    //            $this->assertEquals("xmltheme1", $currentItem->get_Name(), "xmltheme1 name mismatch");
    //            $this->assertEquals("/xmltheme1.ico", $currentItem->get_FavIconUrl());
    //            $this->assertEquals("/xmltheme1.css", $currentItem->get_StyleSheetPath());
    //            $this->assertEquals("/xmltheme1ie6.css", $currentItem->get_StyleSheetPathIE6());
    //            $this->assertEquals("/xmltheme1ie7.css", $currentItem->get_StyleSheetPathIE7());
    //            $this->assertEquals("XML Theme 1", $currentItem->get_Title());
    //            $this->assertEquals("The XML theme 1", $currentItem->get_Description());
    //            $this->assertEquals("/xmltheme1thumb.jpg", $currentItem->get_ThumbnailUrl());
    //        }
    //        if ($idx == 1)
    //        {
    //            $this->assertEquals("xmltheme2", $currentItem->get_Name(), "xmltheme2 name mismatch");
    //            $this->assertEquals("/xmltheme2.ico", $currentItem->get_FavIconUrl());
    //            $this->assertEquals("/xmltheme2.css", $currentItem->get_StyleSheetPath());
    //            $this->assertEquals("/xmltheme2ie6.css", $currentItem->get_StyleSheetPathIE6());
    //            $this->assertEquals("/xmltheme2ie7.css", $currentItem->get_StyleSheetPathIE7());
    //            $this->assertEquals("XML Theme 2", $currentItem->get_Title());
    //            $this->assertEquals("The XML theme 2", $currentItem->get_Description());
    //            $this->assertEquals("/xmltheme2thumb.jpg", $currentItem->get_ThumbnailUrl());
    //        }
    //        $idx++;
    //    }
    //    $this->assertEquals(2, $idx);
    //}
    
    //public function test_ThemeExists()
    //{
    //    $themeList = $this->CreateThemeList();
    //    
    //    $this->assertTrue($themeList->ThemeExists("qstheme"));
    //    $this->assertTrue($themeList->ThemeExists("cookietheme"));
    //    $this->assertFalse($themeList->ThemeExists("test1"));
    //}
    
    public function test_SetSelectedThemeCookie()
    {
        // need theme selected in QS else cookie won't be set (as
        // will be determined nothing to set).
        $themeList = $this->CreateThemeListWithQueryString();
        $pageRequest = $themeList->get_PageRequest_ForTesting();
        
        // verify start with no cookies
        $this->assertEquals(0, count($pageRequest->Cookies()));
        
        $themeList->SetSelectedThemeCookie();
        
        $cookies = $pageRequest->Cookies();
        $this->assertEquals(1, count($cookies));
        $cookieKeys = array_keys($cookies);
        $cookieValues = array_values($cookies);
        $this->assertEquals("theme", $cookieKeys[0]);
        $this->assertEquals("qstheme", $cookieValues[0]);
    }
    
    public function test_SetSelectedThemeCookie_NoThemeSelected()
    {
        // no selected theme so should not set cookie
        $themeList = $this->CreateThemeList();
        $pageRequest = $themeList->get_PageRequest_ForTesting();
        
        // verify start with no cookies
        $this->assertEquals(0, count($pageRequest->Cookies()));
        
        $themeList->SetSelectedThemeCookie();
        
        // verify end with no cookies
        $this->assertEquals(0, count($pageRequest->Cookies()));
    }
    
    public function test_SetSelectedThemeCookie_ThemeAlreadyInCookie()
    {
        // no selected theme so should not set cookie
        $themeList = $this->CreateThemeListWithCookie();
        $pageRequest = $themeList->get_PageRequest_ForTesting();
        
        // verify start with expected theme cookie
        $cookies = $pageRequest->Cookies();
        $this->assertEquals(1, count($cookies));
        $cookieKeys = array_keys($cookies);
        $cookieValues = array_values($cookies);
        $this->assertEquals("theme", $cookieKeys[0]);
        $this->assertEquals("cookietheme", $cookieValues[0]);
        
        $themeList->SetSelectedThemeCookie();
        
        // verify end with same cookie
        $cookies = $pageRequest->Cookies();
        $this->assertEquals(1, count($cookies));
        $cookieKeys = array_keys($cookies);
        $cookieValues = array_values($cookies);
        $this->assertEquals("theme", $cookieKeys[0]);
        $this->assertEquals("cookietheme", $cookieValues[0]);
    }
    
    public function test_SetSelectedThemeCookie_ThemeAlreadyInCookie_NewThemeInQS()
    {
        $pageRequest = new MockPageRequest();
        $pageRequest->AddTestQueryStringParameter("theme", "qstheme");
        $pageRequest->AddTestCookie("theme", "cookietheme");
        $themeList = new ThemeListExposedForTest(
            new CrudeThemeFactory("/notadir/notafile.xml"),
            "test1", 
            $pageRequest);
        
        // verify start with expected theme cookie
        $cookies = $pageRequest->Cookies();
        $this->assertEquals(1, count($cookies));
        $cookieKeys = array_keys($cookies);
        $cookieValues = array_values($cookies);
        $this->assertEquals("theme", $cookieKeys[0]);
        $this->assertEquals("cookietheme", $cookieValues[0]);
        
        $themeList->SetSelectedThemeCookie();
        
        // verify end with new cookie
        $cookies = $pageRequest->Cookies();
        $this->assertEquals(1, count($cookies));
        $cookieKeys = array_keys($cookies);
        $cookieValues = array_values($cookies);
        $this->assertEquals("theme", $cookieKeys[0]);
        $this->assertEquals("qstheme", $cookieValues[0]);
    }
    //// End: The Tests
    
    //// Begin: Utility methods
    protected function CreateThemeList()
    {
        return new ThemeListExposedForTest(
            new MockThemeFactory(),
            "test1");        
    }
    
    protected function CreateThemeListWithQueryString()
    {
        $pageRequest = new MockPageRequest();
        $pageRequest->AddTestQueryStringParameter("theme", "qstheme");
        return new ThemeListExposedForTest(
            new MockThemeFactory(),
            "test1", 
            $pageRequest);
    }
    
    protected function CreateThemeListWithCookie()
    {
        $pageRequest = new MockPageRequest();
        $pageRequest->AddTestCookie("theme", "cookietheme");
        return new ThemeListExposedForTest(
            new MockThemeFactory(),
            "test1", 
            $pageRequest);
    }
    //// End: Utility methods
}
?>
