<?php
/*
 * This file is part of FacturaSctipts
 * Copyright (C) 2012  Carlos Garcia Gomez  neorazorx@gmail.com
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 * 
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once 'config.php';
require_once 'base/fs_controller.php';
require_once 'raintpl/rain.tpl.class.php';

/// ¿Qué controlador usar?
if( isset($_GET['page']) )
{
   if( file_exists('controller/'.$_GET['page'].'.php') )
   {
      require_once 'controller/'.$_GET['page'].'.php';
      $fsc = new $_GET['page']();
   }
   else
      $fsc = new fs_controller();
}
else
{
   $fsc = new fs_controller();
   $fsc->select_default_page();
}

if( $fsc->template )
{
   /// configuramos rain.tpl
   raintpl::configure("base_url", null );
   raintpl::configure("tpl_dir", "view/" );
   raintpl::configure("cache_dir", "tmp/" );
   $tpl = new RainTPL();
   $tpl->assign('fsc', $fsc);
   if( isset($_POST['user']) )
      $tpl->assign('nlogin', $_POST['user']);
   else if( isset($_GET['nlogin']) )
      $tpl->assign('nlogin', $_GET['nlogin']);
   else
      $tpl->assign('nlogin', '');
   $tpl->draw( $fsc->template );
}

$fsc->close();

?>