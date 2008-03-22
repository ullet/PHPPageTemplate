<?php
/*
 *************************************************************************
 * PHPPageTemplate: A PHP4 page templating system.                       *
 * Version 0.3.0 (11 November 2007)                                      *
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
 
require_once("index_code.php");

class IndexPage extends IndexPageCode
{
    function IndexPage()
    {
        $this->IndexPageCode();
    }
    
    function PlaceHolder_content1() 
    {
?>
<p>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nulla gravida tincidunt dolor. Maecenas vestibulum. In hac habitasse platea dictumst. Suspendisse sapien mauris, ullamcorper et, bibendum quis, imperdiet non, leo. Cras gravida, urna in venenatis cursus, eros felis nonummy libero, eget ultricies erat metus et sapien. Nulla quam mauris, condimentum in, pharetra eu, faucibus eu, est. Aliquam felis. Phasellus arcu. In volutpat dapibus ipsum. Donec arcu tortor, porttitor in, iaculis eget, ullamcorper in, felis. Nullam et arcu. In sit amet purus.
</p>
<p>
Etiam sodales dapibus purus. Sed eleifend lectus eget nisl. Nullam lacus. Etiam a elit. Aenean ultricies mollis sem. Nam vehicula ultrices tellus. Nulla malesuada, justo vel convallis nonummy, nulla quam hendrerit pede, tincidunt interdum enim nulla id ante. Etiam sed mi. Maecenas sed justo. Vestibulum congue porta erat. Quisque id turpis. Praesent sagittis dapibus augue. Curabitur laoreet turpis. Mauris magna nisl, fermentum nec, interdum ut, dignissim at, erat. Vivamus eu nisl nec nunc elementum pulvinar. Curabitur vestibulum, mauris vel eleifend ornare, lectus odio iaculis risus, egestas ullamcorper massa sapien sed risus. Maecenas blandit.
</p>
<p>
Donec vel magna ac lorem euismod consequat. Vestibulum dictum tortor sed mauris cursus fringilla. Donec malesuada ultrices pede. Sed eu lorem sed nisl egestas congue. Nam vestibulum. Sed sed erat. Duis sagittis. Etiam cursus magna id felis. Nullam vitae augue in lectus sagittis sollicitudin. In vulputate orci vitae dui. Nulla auctor libero non turpis consectetuer suscipit. Vivamus metus. Sed fringilla, est a lacinia rutrum, orci pede porttitor tellus, sed molestie erat nisl non turpis. Curabitur hendrerit massa.
</p>
<?php
    }

    function PlaceHolder_content2()
    { 
?>
<p>
Morbi quis lorem sit amet ligula auctor tristique. Proin ut mi sit amet mi posuere tincidunt. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nam rhoncus. Integer a turpis. Ut interdum odio. Pellentesque interdum urna sed nunc. Etiam euismod tempus metus. Donec eget leo. Donec gravida posuere turpis. Donec euismod magna vitae sem. Aenean placerat sem eget purus. Aenean tristique, sem ac eleifend porttitor, nisl diam scelerisque est, a varius lectus lacus et augue. Mauris fringilla, mauris eget nonummy elementum, magna metus faucibus erat, malesuada facilisis felis quam lacinia lectus. Vestibulum vitae metus. Duis volutpat. Integer a arcu. Morbi augue. Suspendisse elit dolor, gravida nec, pulvinar sit amet, dictum non, quam.
</p>
<p>
Pellentesque tincidunt, tellus eleifend tempus nonummy, odio felis malesuada tortor, vitae pretium tellus neque egestas pede. Cras vel elit. Nunc lectus sapien, posuere vel, malesuada eu, pharetra nec, purus. Phasellus in arcu. Pellentesque habitant.
</p>
<?php 
    }
}

$page =& new IndexPage();
$page->Render();
?>
