<?php
/*
 *************************************************************************
 * PHPPageTemplate: A PHP4 page templating system.                       *
 * Version 0.0.0 (03 September 2006)                                     *
 * Copyright (C) 2006 Trevor Barnett                                     *
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
 
include_once("index_code.php");

class IndexPage extends IndexPageCode
{
    function PlaceHolder_ph1() 
    {
        $this->_DoPlaceHolderTest();
    }

    function PlaceHolder_ph2()
    { 
?>
  <p>
    This is the content to go in Place Holder 2.
    <br />
    Here is a list of stuff:
    <ul>
      <li>Rabbit</li>
      <li>Aeroplane</li>
      <li>Windows XP</li>
      <li>Madriva Linux</li>
      <li>Anti-static Cleaning Solution</li>
    </ul>
  </p>
<?php 
    }
}

$page =& new IndexPage();
$page->Render();
?>