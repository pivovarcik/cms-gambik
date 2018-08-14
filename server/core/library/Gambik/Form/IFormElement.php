<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2012
 */

interface IFormElement
{

	public function isEmpty();
	public function isRequired();
	public function isChecked();
	public function isNumeric();
	public function isMoney();

	public function getValue();
	public function setIgnore($value);
	public function getIgnore();
	public function setAttrib($attribute, $value="");
	public function setAttribs($attribute, $value="");
}
?>