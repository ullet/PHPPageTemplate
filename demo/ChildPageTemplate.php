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
 
require_once("ChildPageTemplate_code.php");

class ChildPageTemplate extends ChildPageTemplateCode
{    
    function ChildPageTemplate()
    {
        $this->ChildPageTemplateCode();
    }
        
    function PlaceHolder_leftcol()
    { 
?>
<fieldset>
  <legend>Main Menu</legend>
  <ul id="mainmenu">
    <li><a href="#">Duis quis leo quis</a></li>
    <li><a href="#">Ut in magna eu lorem</a></li>
    <li><a href="#">Nullam faucibus odio</a></li>
    <li><a href="#">Vivamus sed eros quis</a></li>
    <li><a href="#">Curabitur bibendum</a></li>
    <li><a href="#">Cras blandit elit</a></li>
    <li><a href="#">Quisque accumsan</a></li>
  </ul>
</fieldset>
<?php
    }        
    
    function PlaceHolder_rightcol()
    { 
?>
<fieldset>
  <legend>Sub Menu</legend>
  <ul id="submenu">
    <li><a href="#">Praesent ut turpis</a></li>
    <li><a href="#">Pellentesque quis</a></li>
    <li><a href="#">Integer in nisi</a></li>
    <li><a href="#">Etiam bibendum</a></li>
    <li><a href="#">Aliquam volutpat</a></li>
    <li><a href="#">Donec scelerisque</a></li>
    <li><a href="#">In vel orci non</a></li>
    <li><a href="#">Suspendisse id</a></li>
  </ul>
</fieldset>
<?php
    } 
    
    function PlaceHolder_maincol()
    {
?>
<fieldset>
  <legend>Top</legend>
  <?php $this->_RenderPlaceHolder("top") ?>
</fieldset>
<div>
  <hr />
  <hr />
</div>
<fieldset>
  <legend>Bottom</legend>
  <?php $this->_RenderPlaceHolder("bottom") ?>
</fieldset>
<?php
    }
}
?>
