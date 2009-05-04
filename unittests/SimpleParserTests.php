<?php
/*
 ***************************************************************************************************
 * PHPPageTemplate: A PHP page templating system.                                                  *
 * Version 0.4 (04 May 2009)                                                                       *
 * Copyright (C) 2009 Trevor Barnett                                                               *
 *                                                                                                 *
 * This file is part of PHPPageTemplate.                                                           *                                                      *
 *                                                                                                 *
 * PHPPageTemplate is free software: you can redistribute it and/or modify it under the terms of   *
 * the GNU General Public License as published by the Free Software Foundation, either version 3   *
 * of the License, or (at your option) any later version.                                          *
 *                                                                                                 *
 * PHPPageTemplate is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;    *
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See  *
 * the GNU General Public License for more details.                                                *                          *
 *                                                                                                 *
 * You should have received a copy of the GNU General Public License along with PHPPageTemplate.   *
 * If not, see <http://www.gnu.org/licenses/>.                                                     *
 ***************************************************************************************************
 */
 
require_once "PHPUnit/Framework.php";
require_once "Framework.php";

class SimpleParserTests extends PHPUnit_Framework_TestCase
{
    public function test_GetAllDataSingleLineValues()
    {
        $parser = new SimpleParser("testsimpleparserdata.xml");
        
        $this->assertEquals(
            array(
                $this->Theme1Array(),
                $this->StuffArray(),
                $this->Theme2Array(),
                $this->Theme3Array(),
                $this->Theme4Array()),
            $parser->GetAllData());
    }
    
    public function test_GetDataOfTypeSingleLineValues()
    {
        $parser = new SimpleParser("testsimpleparserdata.xml");
            
        $this->assertEquals(
            array(
                $this->Theme1Array(),
                $this->Theme2Array(),
                $this->Theme3Array(),
                $this->Theme4Array()),
            $parser->GetDataOfType("theme"),
            "Incorrect filtered data for type 'theme'");
            
        $this->assertEquals(
            array($this->StuffArray()),
            $parser->GetDataOfType("stuff"),
            "Incorrect filtered data for type 'stuff'");
    }
    
    public function test_GetDataWithAttributesSingleAttributeExists()
    {
        $parser = new SimpleParser("testsimpleparserdata.xml");
            
        $this->assertEquals(
            array(
                $this->Theme1Array(),
                $this->Theme2Array(),
                $this->Theme3Array(),
                $this->Theme4Array()),
            $parser->GetDataWithAttributes(array("id"=>NULL)));     
    }    
    
    public function test_GetDataWithAttributesSingleAttributeHasValue()
    {
        $parser = new SimpleParser("testsimpleparserdata.xml");
            
        $this->assertEquals(
            array($this->Theme1Array()),
            $parser->GetDataWithAttributes(array("id"=>"theme1")));
    }  
    
    public function test_GetDataWithAttributesMultipleAttributesExist()
    {
        $parser = new SimpleParser("testsimpleparserdata.xml");
            
        $this->assertEquals(
            array(
                $this->Theme1Array(),
                $this->Theme2Array(),
                $this->Theme3Array()),
            $parser->GetDataWithAttributes(array("id"=>NULL, "tagged"=>NULL)));     
    }   
    
    public function test_GetDataWithAttributesMultipleAttributesHaveOneValue()
    {
        $parser = new SimpleParser("testsimpleparserdata.xml");
            
        $this->assertEquals(
            array(
                $this->Theme1Array(),
                $this->Theme3Array()),
            $parser->GetDataWithAttributes(array("id"=>NULL, "tagged"=>"true")));     
    }    
    
    public function test_GetDataWithAttributesMultipleAttributesHaveAllValue()
    {
        $parser = new SimpleParser("testsimpleparserdata.xml");
            
        $this->assertEquals(
            array(
                $this->Theme3Array()),
            $parser->GetDataWithAttributes(array("id"=>"theme3", "tagged"=>"true")));     
    } 
    
    public function test_GetDataOfTypeWithAttributes()
    {
        $parser = new SimpleParser("testsimpleparserdata.xml");
        
        $this->assertEquals(
            array(
                $this->Theme1Array(),
                $this->Theme2Array(),
                $this->Theme3Array()),
            $parser->GetDataOfTypeWithAttributes("theme", array("tagged"=>NULL)),
            "Wrong data for type=theme & tagged attribute exists");
            
        $this->assertEquals(
            array($this->StuffArray()),
            $parser->GetDataOfTypeWithAttributes("stuff", array("tagged"=>NULL)),
            "Wrong data for type=Stuff & tagged attribute exists");
    }
    
    public function test_GetDataWithAttributesMultipleAttributesHaveAllValueNoMatch()
    {
        $parser = new SimpleParser("testsimpleparserdata.xml");
            
        $this->assertEquals(
            array(),
            $parser->GetDataWithAttributes(array("id"=>"theme2", "tagged"=>"true")));     
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
    
    public function test_GetDataWithAttributesTriggerSingleParseForLifeOfObjectForCallsInAnyOrder()
    {
        $parser = new SimpleParserWithSensing("testsimpleparserdata.xml");
        
        $this->assertEquals(0, $parser->ParseCount, "Data should not be parsed on initialisation");
        
        $data = $parser->GetDataWithAttributes(array("id"=>NULL));
        
        $this->assertEquals(1, $parser->ParseCount, "Data should have been parsed once");
        
        $data = $parser->GetDataWithAttributes(array("id"=>"theme3"));
        
        $this->assertEquals(1, $parser->ParseCount, "Data should only have been parsed once after 2 calls");
        
        $data = $parser->GetDataWithAttributes(array("StuffID"=>"monkeysuit"));
        
        $this->assertEquals(1, $parser->ParseCount, "Data should only have been parsed once after 3 calls");
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
    
    private function &Theme1Array()
    {
        return array(
            "type"=>"theme", 
            "attributes"=>array(
                "id"=>"theme1",
                "tagged"=>"true"),
            "properties"=>array(
                "name"=>"Theme 1",
                "description"=>"The first theme"));
    }
    
    private function &Theme2Array()
    {
        return array(
            "type"=>"theme", 
            "attributes"=>array(
                "id"=>"theme2",
                "tagged"=>"false"),
            "properties"=>array(
                "name"=>"Theme 2",
                "description"=>"The second theme"));
    }
    
    private function &Theme3Array()
    {
        return array(
            "type"=>"theme", 
            "attributes"=>array(
                "id"=>"theme3",
                "tagged"=>"true"),
            "properties"=>array(
                "name"=>"Theme 3",
                "description"=>"The third theme"));
    }
    
    private function &Theme4Array()
    {
        return array(
            "type"=>"theme", 
            "attributes"=>array(
                "id"=>"theme4"),
            "properties"=>array(
                "name"=>"Theme 4",
                "description"=>"The fourth theme"));
    }
    
    private function &StuffArray()
    {
        return array(
            "type"=>"stuff", 
            "attributes"=>array(
                "StuffID"=>"monkeysuit",
                "tagged"=>"true"),
            "properties"=>array(
                "StuffName"=>"Monkey Suit",
                "Description"=>
                    "Gorilla costume, probably shouldn't be called a Monkey Suit."));
    }
}

?>