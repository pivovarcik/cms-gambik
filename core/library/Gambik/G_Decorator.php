<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
class G_Decorator
{

	public $first;
	public $last;
	function __construct()
	{

	}
	public function setDecorator($first='', $last='')
	{
		$this->first = '<dt>';
		$this->last = '</dt>';
	}

	public function getDecorator()
	{

	}

}