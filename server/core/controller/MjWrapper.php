<?php


class MjWrapper extends G_Wrapper{

	public function __construct($radek)
	{
		parent::__construct($radek);

		$radek->dg_commands = array();



    			$command = new EditDataGridCommandModal(URL_HOME . "options/mj?do=edit&id=" . $radek->id);
			array_push($radek->dg_commands, $command);

			$command = new DeleteDataGridCommand(URL_HOME . "options/mj?do=MjDelete&id=" . $radek->id);
			array_push($radek->dg_commands, $command);
  }
}