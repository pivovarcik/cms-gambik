<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
define('T_SHOP_PARAM_VALUE','param_value');
class models_ProductParamValue extends G_Service{
	function __construct()
	{
		parent::__construct(T_SHOP_PARAM_VALUE);
	}


}

/*
CREATE TABLE IF NOT EXISTS `param` (
`id` int(11) NOT NULL auto_increment,
`id_param` int(11) NOT NULL,
`type` char(25) NULL,
`name` char(100) NULL,
PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
   */