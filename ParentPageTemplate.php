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
 
include_once("ParentPageTemplate_code.php");
class ParentPageTemplate extends ParentPageTemplateCode
{    
    function RenderContent()
    { 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" >
<html>
  <head>
    <title><?= $this->get_EncodedTitle() ?></title>
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" href="template.css" type="text/css" />
  </head>
  <body>
    <div id="pagewidth">
      <div id="header">
        <h1 id="mainheading"><?= $this->get_EncodedHeading() ?></h1>
      </div>
      <div id="wrapper" class="clearfix" > 
        <div id="twocols" class="clearfix"> 
          <div id="maincol">
            <?php $this->_RenderPlaceHolder("maincol") ?>
          </div>
		  <div id="rightcol">
		    <?php $this->_RenderPlaceHolder("rightcol") ?>
		  </div>
		</div> 
        <div id="leftcol">
          <?php $this->_RenderPlaceHolder("leftcol") ?>
        </div>
      </div>
	  <div id="footer">
	    <?php $this->_RenderPlaceHolder("footer") ?>
	  </div>
	</div>
  </body>
</html>
<?php
    }        
}
?>