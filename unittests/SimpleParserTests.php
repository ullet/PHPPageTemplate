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
require_once "Framework.php";

class SimpleParserTests extends PHPUnit_Framework_TestCase
{
    public function test_GetAllDataSingleLineValues()
    {
        $parser = new SimpleParser("testsimpleparserdata.xml");
        $data = $parser->GetAllData();
        
        $this->assertEquals(3, count($data), "Wrong number of top level items");
        $this->assertTrue(
            is_array($data[0]) && is_array($data[1]) && is_array($data[2]), 
            "Top level item must be an array"); 
        $this->assertEquals("theme", $data[0]["type"], "Wrong type for item 1");
        $this->assertEquals("stuff", $data[1]["type"], "Wrong type for item 2");
        $this->assertEquals("theme", $data[2]["type"], "Wrong type for item 3");
        $this->assertTrue(
            is_array($data[0]["attributes"]) && 
            is_array($data[1]["attributes"]) && 
            is_array($data[2]["attributes"]), 
            "attributes must be an array");
        $this->assertEquals(
            "theme1", 
            $data[0]["attributes"]["id"], 
            "Wrong value for id attribute for item 1");
        $this->assertEquals(
            "monkeysuit", 
            $data[1]["attributes"]["StuffID"], 
            "Wrong value for StuffID attribute for item 2");
        $this->assertEquals(
            "theme2", 
            $data[2]["attributes"]["id"], 
            "Wrong value for id attribute for item 3");
        $this->assertTrue(
            is_array($data[0]["properties"]) && 
            is_array($data[1]["properties"]) &&
            is_array($data[2]["properties"]),
            "properties must be an array");
        $this->assertEquals(
            "Theme 1", 
            $data[0]["properties"]["name"], 
            "Wrong value for name property for item 1");
        $this->assertEquals(
            "The first theme", 
            $data[0]["properties"]["description"], 
            "Wrong value for description property for item 1");
        $this->assertEquals(
            "Monkey Suit", 
            $data[1]["properties"]["StuffName"], 
            "Wrong value for StuffName property for item 2");
        $this->assertEquals(
            "Gorilla costume, probably shouldn't be called a Monkey Suit.", 
            $data[1]["properties"]["Description"], 
            "Wrong value for Description property for item 2");
        $this->assertEquals(
            "Theme 2", 
            $data[2]["properties"]["name"], 
            "Wrong value for name property for item 3");
        $this->assertEquals(
            "The second theme", 
            $data[2]["properties"]["description"], 
            "Wrong value for description property for item 3");
    }
    
    public function test_GetDataOfTypeSingleLineValues()
    {
        $parser = new SimpleParser("testsimpleparserdata.xml");
        $themeData = $parser->GetDataOfType("theme");
        
        $this->assertEquals(2, count($themeData), "Wrong number of top level items");
        $this->assertTrue(
            is_array($themeData[0]) && is_array($themeData[1]), 
            "Top level item must be an array"); 
        $this->assertEquals("theme", $themeData[0]["type"], "Wrong type for item 1");
        $this->assertEquals("theme", $themeData[1]["type"], "Wrong type for item 2");
        $this->assertTrue(
            is_array($themeData[0]["attributes"]) && is_array($themeData[1]["attributes"]), 
            "attributes must be an array");
        $this->assertEquals(
            "theme1", 
            $themeData[0]["attributes"]["id"], 
            "Wrong value for id attribute for item 1");
        $this->assertEquals(
            "theme2", 
            $themeData[1]["attributes"]["id"], 
            "Wrong value for id attribute for item 2");
        $this->assertTrue(
            is_array($themeData[0]["properties"]) && is_array($themeData[1]["properties"]), 
            "properties must be an array");
        $this->assertEquals(
            "Theme 1", 
            $themeData[0]["properties"]["name"], 
            "Wrong value for name property for item 1");
        $this->assertEquals(
            "The first theme", 
            $themeData[0]["properties"]["description"], 
            "Wrong value for description property for item 1");
        $this->assertEquals(
            "Theme 2", 
            $themeData[1]["properties"]["name"], 
            "Wrong value for name property for item 2");
        $this->assertEquals(
            "The second theme", 
            $themeData[1]["properties"]["description"], 
            "Wrong value for description property for item 2");
            
        $stuffData = $parser->GetDataOfType("stuff");
        
        $this->assertEquals(1, count($stuffData), "Wrong number of top level items");
        $this->assertTrue(is_array($stuffData[0]), "Top level item must be an array"); 
        $this->assertEquals("stuff", $stuffData[0]["type"], "Wrong type for item 1");
        $this->assertTrue(is_array($stuffData[0]["attributes"]), "attributes must be an array");
        $this->assertEquals(
            "monkeysuit", 
            $stuffData[0]["attributes"]["StuffID"], 
            "Wrong value for StuffID attribute for item 1");
        $this->assertTrue(is_array($stuffData[0]["properties"]), "properties must be an array");
        $this->assertEquals(
            "Monkey Suit", 
            $stuffData[0]["properties"]["StuffName"], 
            "Wrong value for StuffName property for item 1");
        $this->assertEquals(
            "Gorilla costume, probably shouldn't be called a Monkey Suit.", 
            $stuffData[0]["properties"]["Description"], 
            "Wrong value for Description property for item 1");
    }
    
    public function test_GetAllDataOnlyTriggersSingleParseForLifeOfObject()
    {
        $parser = new SimpleParserWithSensing("testsimpleparserdata.xml");
        
        $this->assertEquals(0, $parser->ParseCount, "Data should not be parsed on initialisation");
        
        $data = $parser->GetAllData();
        
        $this->assertEquals(1, $parser->ParseCount, "Data should have been parsed once");
        
        $data = $parser->GetAllData();
        
        $this->assertEquals(1, $parser->ParseCount, "Data should only have been parsed once");
    }    
    
    public function test_GetDataOfTypeOnlyTriggersSingleParseForLifeOfObject()
    {
        $parser = new SimpleParserWithSensing("testsimpleparserdata.xml");
        
        $this->assertEquals(0, $parser->ParseCount, "Data should not be parsed on initialisation");
        
        $data = $parser->GetDataOfType("theme");
        
        $this->assertEquals(1, $parser->ParseCount, "Data should have been parsed once");
        
        $data = $parser->GetDataOfType("theme");
        
        $this->assertEquals(1, $parser->ParseCount, "Data should only have been parsed once after 2 calls");
        
        $data = $parser->GetDataOfType("stuff");
        
        $this->assertEquals(1, $parser->ParseCount, "Data should only have been parsed once after 3 calls");
    } 
    
    public function test_GetDataMethodsTriggerSingleParseForLifeOfObjectForCallsInAnyOrder()
    {
        $parserA = new SimpleParserWithSensing("testsimpleparserdata.xml");
        
        $this->assertEquals(0, $parserA->ParseCount, "Data should not be parsed on initialisation (A)");
        
        $data = $parserA->GetAllData();
        
        $this->assertEquals(1, $parserA->ParseCount, "Data should have been parsed once (A)");
        
        $data = $parserA->GetDataOfType("theme");
        
        $this->assertEquals(1, $parserA->ParseCount, "Data should only have been parsed once after 2 calls (A)");
        
        $data = $parserA->GetDataOfType("stuff");
        
        $this->assertEquals(1, $parserA->ParseCount, "Data should only have been parsed once after 3 calls (A)");
        
        $parserB = new SimpleParserWithSensing("testsimpleparserdata.xml");
        
        $this->assertEquals(0, $parserB->ParseCount, "Data should not be parsed on initialisation (A)");
        
        $data = $parserB->GetDataOfType("stuff");     
           
        $this->assertEquals(1, $parserB->ParseCount, "Data should have been parsed once (B)");
        
        $data = $parserB->GetAllData();
        
        $this->assertEquals(1, $parserB->ParseCount, "Data should only have been parsed once after 2 calls (B)");
        
        $data = $parserB->GetDataOfType("theme");
        
        $this->assertEquals(1, $parserB->ParseCount, "Data should only have been parsed once after 3 calls (B)");
    }      
    
    public function test_CannotModifyObjectsCopyOfData()
    {
        $parser = new SimpleParser("testsimpleparserdata.xml");
        
        // get copy of data
        $dataCopy1 = $parser->GetAllData();
        
        // verify original values 
        $this->assertEquals(
            "theme1", 
            $dataCopy1[0]["attributes"]["id"], 
            "Wrong value for id attribute for item 1 in unmodified copy 1");
        $this->assertEquals(
            "The second theme", 
            $dataCopy1[2]["properties"]["description"], 
            "Wrong value for description property for item 3 in unmodified copy 1");
            
        // modify some values
        $dataCopy1[0]["attributes"]["id"] = "wrongid";
        $dataCopy1[2]["properties"]["description"] = "Wrong description";
        
        // verify new values        
        $this->assertNotEquals(
            "theme1", 
            $dataCopy1[0]["attributes"]["id"], 
            "Wrong value for id attribute for item 1 in modified copy 1 before copy 2");
        $this->assertNotEquals(
            "The second theme", 
            $dataCopy1[2]["properties"]["description"], 
            "Wrong value for description property for item 3 in modified copy 1 before copy 2");
            
        // get new copy of data
        $dataCopy2 = $parser->GetAllData();
        
        // verify new copy has original values
        $this->assertEquals(
            "theme1", 
            $dataCopy2[0]["attributes"]["id"], 
            "Wrong value for id attribute for item 1 in unmodified copy 2");
        $this->assertEquals(
            "The second theme", 
            $dataCopy2[2]["properties"]["description"], 
            "Wrong value for description property for item 3 in unmodified copy 2");
            
        // verify modified copy still modified        
        $this->assertNotEquals(
            "theme1", 
            $dataCopy1[0]["attributes"]["id"], 
            "Wrong value for id attribute for item 1 in modified copy 1 after copy 2");
        $this->assertNotEquals(
            "The second theme", 
            $dataCopy1[2]["properties"]["description"], 
            "Wrong value for description property for item 3 in modified copy 1 after copy 2");
    }
}

?>