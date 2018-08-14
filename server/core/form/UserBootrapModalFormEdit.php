<?php


require_once("UserBootrapModalForm.php");
class UserBootrapModalFormEdit extends UserBootrapModalForm {

	public function __construct()
	{
		parent::__construct("F_AdminUserEdit");
		$this->setBody();
	}

}