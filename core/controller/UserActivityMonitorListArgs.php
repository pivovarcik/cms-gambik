<?php



class UserActivityMonitorListArgs extends ListArgs{


	public function __construct()
	{
				$this->allowedOrder = array(
		   "TimeStamp" => "t1.TimeStamp",
		   "id" => "p.id",
		   "title" => "v.title",
		   );

		parent::__construct();


		$this->orderBy = "t1.TimeStamp DESC";

		$name = "q";
		$this->search = $this->request->getQuery($name,"");

		$name = "status_id";
		//$this->$name = $this->request->getQuery($name,"");


	}
}