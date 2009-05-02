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

// NB. The class actually instantiated in the tests below is PageRequestExposedForTest
// not HttpPageRequest.  The tests are still valid as all HttpPageRequest methods in 
// test cases below are not overridden in PageRequestExposedForTest.  It is necessary
// to sub-class HttpPageRequest as special arrays $_GET and $_COOKIE have no
// special meaning outside of a web context.  The only methods of HttpPageRequest
// not tested are QueryString() and Cookies().  This is not a problem as these
// two methods are trivial, simply returning $_GET and $_COOKIE respectively.
class HttpPageRequestTests extends PHPUnit_Framework_TestCase
{    
    //// Begin: Test code tests
    // Test the utility methods in TestPageRequest
    public function test_ClearQueryString()
    {
        $pageRequest = $this->CreatePageRequest();
        $qsBefore = $pageRequest->QueryString();
        $this->assertNotEquals(0, count($qsBefore));
        $pageRequest->ClearTestQueryString();
        $qsAfter = $pageRequest->QueryString();
        $this->assertEquals(0, count($qsAfter));
    }
    
    public function test_ClearCookies()
    {
        $pageRequest = $this->CreatePageRequest();
        $cookiesBefore = $pageRequest->Cookies();
        $this->assertNotEquals(0, count($cookiesBefore));
        $pageRequest->ClearTestCookies();
        $cookiesAfter = $pageRequest->Cookies();
        $this->assertEquals(0, count($cookiesAfter));
    }
    
    public function test_CreateTestPageRequest()
    {
        $pageRequest = $this->CreatePageRequest();
        $this->assertEquals(3, count($pageRequest->QueryString()));
        $this->assertEquals(2, count($pageRequest->Cookies()));        
        $qskeys = array_keys($pageRequest->QueryString());
        $qsvalues = array_values($pageRequest->QueryString());
        $cookiekeys = array_keys($pageRequest->Cookies());
        $cookievalues = array_values($pageRequest->Cookies());        
        $this->assertEquals(3, count($qskeys));
        $this->assertEquals(3, count($qsvalues));
        $this->assertEquals(2, count($cookiekeys));
        $this->assertEquals(2, count($cookievalues));        
        $this->assertEquals("a", $qskeys[0]);
        $this->assertEquals("B", $qskeys[1]);
        $this->assertEquals("c_d_e", $qskeys[2]);
        $this->assertEquals("123", $qsvalues[0]);
        $this->assertEquals("xyz", $qsvalues[1]);
        $this->assertEquals("Testing This", $qsvalues[2]);
        $this->assertEquals("session_ID", $cookiekeys[0]);
        $this->assertEquals("user_ID", $cookiekeys[1]);
        $this->assertEquals("c123-b456-a789", $cookievalues[0]);
        $this->assertEquals("AE05-FE34-1CC8", $cookievalues[1]);
    }
    //// End: Test code tests
    
    //// Begin: The Tests
    public function test_QueryStringLC()
    {
        $pageRequest = $this->CreatePageRequest();
        
        $qs = $pageRequest->QueryStringLC();
        
        $this->assertEquals(3, count($qs));        
        $qskeys = array_keys($qs);
        $qsvalues = array_values($qs);        
        $this->assertEquals(3, count($qskeys));
        $this->assertEquals(3, count($qsvalues));        
        $this->assertEquals("a", $qskeys[0]);
        $this->assertEquals("b", $qskeys[1]);
        $this->assertEquals("c_d_e", $qskeys[2]);
        $this->assertEquals("123", $qsvalues[0]);
        $this->assertEquals("xyz", $qsvalues[1]);
        $this->assertEquals("testing this", $qsvalues[2]);        
    }
    
    public function test_QueryStringLCKeys()
    {
        $pageRequest = $this->CreatePageRequest();
        
        $qs = $pageRequest->QueryStringLCKeys();
        
        $this->assertEquals(3, count($qs));        
        $qskeys = array_keys($qs);
        $qsvalues = array_values($qs);        
        $this->assertEquals(3, count($qskeys));
        $this->assertEquals(3, count($qsvalues));        
        $this->assertEquals("a", $qskeys[0]);
        $this->assertEquals("b", $qskeys[1]);
        $this->assertEquals("c_d_e", $qskeys[2]);
        $this->assertEquals("123", $qsvalues[0]);
        $this->assertEquals("xyz", $qsvalues[1]);
        $this->assertEquals("Testing This", $qsvalues[2]);        
    }
    
    public function test_QueryStringLCValues()
    {
        $pageRequest = $this->CreatePageRequest();
        
        $qs = $pageRequest->QueryStringLCValues();
        
        $this->assertEquals(3, count($qs));        
        $qskeys = array_keys($qs);
        $qsvalues = array_values($qs);        
        $this->assertEquals(3, count($qskeys));
        $this->assertEquals(3, count($qsvalues));        
        $this->assertEquals("a", $qskeys[0]);
        $this->assertEquals("B", $qskeys[1]);
        $this->assertEquals("c_d_e", $qskeys[2]);
        $this->assertEquals("123", $qsvalues[0]);
        $this->assertEquals("xyz", $qsvalues[1]);
        $this->assertEquals("testing this", $qsvalues[2]);        
    }
    
    public function test_QueryStringHash()
    {
        $pageRequest = $this->CreatePageRequest();
        
        $qs = $pageRequest->QueryStringHash();
        
        $this->assertEquals(3, count($qs));        
        $qskeys = array_keys($qs);
        $qsvalues = array_values($qs);        
        $this->assertEquals(3, count($qskeys));
        $this->assertEquals(3, count($qsvalues));
        $this->assertEquals(3, count($qsvalues[0]));
        $this->assertEquals(3, count($qsvalues[1]));
        $this->assertEquals(3, count($qsvalues[2]));
        $this->assertEquals("a", $qskeys[0]);
        $this->assertEquals("b", $qskeys[1]);
        $this->assertEquals("c_d_e", $qskeys[2]);
        $this->assertEquals("a", $qsvalues[0]["actualKey"]);
        $this->assertEquals("123", $qsvalues[0]["value"]);
        $this->assertEquals("123", $qsvalues[0]["valueLC"]);
        $this->assertEquals("B", $qsvalues[1]["actualKey"]);
        $this->assertEquals("xyz", $qsvalues[1]["value"]);
        $this->assertEquals("xyz", $qsvalues[1]["valueLC"]);
        $this->assertEquals("c_d_e", $qsvalues[2]["actualKey"]);
        $this->assertEquals("Testing This", $qsvalues[2]["value"]);
        $this->assertEquals("testing this", $qsvalues[2]["valueLC"]);        
    }
    
    public function test_CookiesLC()
    {
        $pageRequest = $this->CreatePageRequest();
        
        $cookies = $pageRequest->CookiesLC();
        
        $this->assertEquals(2, count($cookies));        
        $cookiekeys = array_keys($cookies);
        $cookievalues = array_values($cookies);        
        $this->assertEquals(2, count($cookiekeys));
        $this->assertEquals(2, count($cookievalues));        
        $this->assertEquals("session_id", $cookiekeys[0]);
        $this->assertEquals("user_id", $cookiekeys[1]);
        $this->assertEquals("c123-b456-a789", $cookievalues[0]);
        $this->assertEquals("ae05-fe34-1cc8", $cookievalues[1]);      
    }
    
    public function test_CookiesLCKeys()
    {
        $pageRequest = $this->CreatePageRequest();
        
        $cookies = $pageRequest->CookiesLCKeys();
        
        $this->assertEquals(2, count($cookies));        
        $cookiekeys = array_keys($cookies);
        $cookievalues = array_values($cookies);        
        $this->assertEquals(2, count($cookiekeys));
        $this->assertEquals(2, count($cookievalues));        
        $this->assertEquals("session_id", $cookiekeys[0]);
        $this->assertEquals("user_id", $cookiekeys[1]);
        $this->assertEquals("c123-b456-a789", $cookievalues[0]);
        $this->assertEquals("AE05-FE34-1CC8", $cookievalues[1]);      
    }
    
    public function test_CookiesLCValues()
    {
        $pageRequest = $this->CreatePageRequest();
        
        $cookies = $pageRequest->CookiesLCValues();
        
        $this->assertEquals(2, count($cookies));        
        $cookiekeys = array_keys($cookies);
        $cookievalues = array_values($cookies);        
        $this->assertEquals(2, count($cookiekeys));
        $this->assertEquals(2, count($cookievalues));        
        $this->assertEquals("session_ID", $cookiekeys[0]);
        $this->assertEquals("user_ID", $cookiekeys[1]);
        $this->assertEquals("c123-b456-a789", $cookievalues[0]);
        $this->assertEquals("ae05-fe34-1cc8", $cookievalues[1]);      
    }
    
    public function test_CookiesHash()
    {
        $pageRequest = $this->CreatePageRequest();
        
        $cookies = $pageRequest->CookiesHash();
        
        $this->assertEquals(2, count($cookies));        
        $cookiekeys = array_keys($cookies);
        $cookievalues = array_values($cookies);        
        $this->assertEquals(2, count($cookiekeys));
        $this->assertEquals(2, count($cookievalues));
        $this->assertEquals(3, count($cookievalues[0]));
        $this->assertEquals(3, count($cookievalues[1]));
        $this->assertEquals("session_id", $cookiekeys[0]);
        $this->assertEquals("user_id", $cookiekeys[1]);
        $this->assertEquals("session_ID", $cookievalues[0]["actualKey"]);
        $this->assertEquals("c123-b456-a789", $cookievalues[0]["value"]);
        $this->assertEquals("c123-b456-a789", $cookievalues[0]["valueLC"]);
        $this->assertEquals("user_ID", $cookievalues[1]["actualKey"]);
        $this->assertEquals("AE05-FE34-1CC8", $cookievalues[1]["value"]);
        $this->assertEquals("ae05-fe34-1cc8", $cookievalues[1]["valueLC"]);      
    }
    
    public function test_Get_CookieCollection_RealDefault()
    {
        $pageRequest = new HttpPageRequest();
        
        // verify default is CookieCollection and not a subtype
        $this->assertTrue($pageRequest->get_CookieCollection() instanceof CookieCollection);
        $this->assertFalse(is_subclass_of($pageRequest->get_CookieCollection(), CookieCollection));
    }
    
    public function test_Get_QueryStringCollection_RealDefault()
    {
        $pageRequest = new HttpPageRequest();
        
        // verify default is QueryStringCollection and not a subtype
        $this->assertTrue($pageRequest->get_QueryStringCollection() instanceof QueryStringCollection);
        $this->assertFalse(is_subclass_of($pageRequest->get_QueryStringCollection(), QueryStringCollection));
    }
    
    public function test_Set_CookieCollection()
    {
        $pageRequest = $this->CreatePageRequest();
        
        // verify start with MockCookieCollection
        $this->assertTrue($pageRequest->get_CookieCollection() instanceof MockCookieCollection);
        $this->assertFalse(is_subclass_of($pageRequest->get_CookieCollection(), MockCookieCollection));
        
        // change cookie collection instance to a different type
        $pageRequest->set_CookieCollection_ForTesting(new CookieCollection());
        
        // verify type of instance change
        $this->assertTrue($pageRequest->get_CookieCollection() instanceof CookieCollection);
        $this->assertFalse(is_subclass_of($pageRequest->get_CookieCollection(), CookieCollection));
    }
    
    public function test_Set_QueryStringCollection()
    {
        $pageRequest = $this->CreatePageRequest();
        
        // verify start with MockQueryStringCollection
        $this->assertTrue($pageRequest->get_QueryStringCollection() instanceof MockQueryStringCollection);
        $this->assertFalse(is_subclass_of($pageRequest->get_QueryStringCollection(), MockQueryStringCollection));
        
        // change QueryString collection instance to a different type
        $pageRequest->set_QueryStringCollection_ForTesting(new QueryStringCollection());
        
        // verify type of instance change
        $this->assertTrue($pageRequest->get_QueryStringCollection() instanceof QueryStringCollection);
        $this->assertFalse(is_subclass_of($pageRequest->get_QueryStringCollection(), QueryStringCollection));
    }
    //// End: The Tests
    
    //// Begin: Utility methods
    protected function CreatePageRequest()
    {
        $pageRequest = new HttpPageRequestExposedForTest();
        $pageRequest->ClearTestContext();
        $pageRequest->AddTestQueryStringParameter("a", "123");
        $pageRequest->AddTestQueryStringParameter("B", "xyz");
        $pageRequest->AddTestQueryStringParameter("c_d_e", "Testing This");
        $pageRequest->AddTestCookie("session_ID", "c123-b456-a789");
        $pageRequest->AddTestCookie("user_ID", "AE05-FE34-1CC8");
        
        return $pageRequest;
    }
    //// End: Utility methods
}
?>
