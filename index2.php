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
 
require_once("index2_code.php");

class IndexPage2 extends IndexPage2Code
{
    function IndexPage2()
    {
        $this->IndexPage2Code();
    }
    
    function PlaceHolder_top()
    { 
?>
<p>
In est. Vivamus neque tortor, fringilla vitae, ornare et, auctor a, lectus. Mauris volutpat. Mauris cursus lectus et erat. Etiam lacinia augue in sem. Etiam viverra tortor a orci. Duis purus dui, pulvinar eu, consectetuer nec, euismod et, diam. Curabitur dui augue, porttitor ac, condimentum ut, elementum vitae, odio. Sed suscipit eros congue erat aliquet lacinia. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Donec tincidunt. Praesent vehicula nunc non pede. Pellentesque eget orci. Donec odio mauris, ornare vel, vestibulum nec, mollis tristique, turpis. Curabitur varius ultrices nisi.
</p>
<p>
Nam sit amet tortor. Phasellus lacus. Curabitur luctus aliquam neque. Nunc vel diam ut justo congue viverra. Cras faucibus turpis dignissim purus. Maecenas fermentum ipsum a nunc. Pellentesque cursus egestas leo. Quisque urna mauris, condimentum et, placerat non, vulputate a, augue. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Morbi laoreet. Sed posuere erat a eros. Etiam at felis eu lacus placerat consectetuer. Suspendisse potenti. Proin vehicula massa commodo tortor. Morbi euismod pretium massa. Sed sagittis mi eu diam. Etiam sed libero nec nunc malesuada volutpat. Pellentesque condimentum ultrices est.
</p>
<?php 
    }
    
    function PlaceHolder_bottom()
    { 
?>
<p>
Maecenas tristique lacus et sem. In sagittis viverra leo. Fusce molestie, odio vitae pharetra mattis, arcu metus luctus pede, fringilla congue sem justo condimentum libero. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec porta. Maecenas iaculis arcu commodo elit. Phasellus quis arcu. Morbi felis quam, pulvinar hendrerit, porttitor eu, mattis sed, nunc. Vestibulum facilisis elit quis neque. Nulla turpis. Sed elementum mattis pede. Maecenas tincidunt, ipsum ut vestibulum fermentum, neque dolor suscipit lacus, id aliquam sem ipsum non ante. Aenean luctus malesuada enim.
<p>
</p>
Pellentesque scelerisque, nibh sed faucibus posuere, turpis nisl vestibulum sapien, sit amet aliquet nibh tortor a tellus. Nullam consectetuer eros non diam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Ut viverra lacinia tortor. In tempor massa nec metus. In nonummy tincidunt dolor. Vestibulum rhoncus congue augue. Fusce nonummy dapibus nibh. Ut in dui dictum arcu convallis tincidunt. Aliquam vulputate placerat diam. Morbi est risus, imperdiet nec, aliquam non, facilisis nec, dolor. Donec pellentesque tincidunt libero. Mauris sed nulla vitae urna vulputate malesuada. Morbi accumsan. Maecenas nisi justo, condimentum eget, aliquet sit amet, aliquam non, massa.
</p>
<?php 
    }    
}

$page =& new IndexPage2();
$page->Render();
?>