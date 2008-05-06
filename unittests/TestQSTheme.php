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
 
require_once "../framework/Theme.php";

class TestQSTheme extends Theme
{
    public function __construct()
    {
        parent::__construct("qstheme");
        $this->set_FavIconUrl("/qstheme.ico");
        $this->set_StyleSheetPath("/qstheme.css");
        $this->set_StyleSheetPathIE6("/qsthemeie6.css");
        $this->set_StyleSheetPathIE7("/qsthemeie7.css");
        $this->set_Title("QS Theme");
        $this->set_Description("The QS theme");
        $this->set_ThumbnailUrl("/qsthemethumb.jpg");
    }
}
?>
