<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class CommentsController extends G_Controller_Action
{
	function __construct()
	{
		parent::__construct();
		parent::afterLoad();
	}




	public function deleteAction()
	{

		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('action', false)
			&& "deleteComments" == $this->getRequest->getPost('action', false))
		{

			$selectedItems = $this->getRequest->getPost('slct', array());
			$seznamCiselObjednavek = array();
			if (count($selectedItems) > 0) {
				foreach ($selectedItems as $key => $doklad_id) {
					if ($doklad_id) {
						$model = new models_Comments();
						$obj = $model->getDetailById($doklad_id);

						if ($obj) {
							$data = array();
							$data["isDeleted"] = 1;
							if($model->updateRecords($model->getTableName(),$data,"id=".$doklad_id))
							{
								array_push($seznamCiselObjednavek,$obj->id );
							}
						}
					}
				}
				if (count($seznamCiselObjednavek)>0) {
					array_reverse($seznamCiselObjednavek);
					$_SESSION["statusmessage"]="Komentář " . implode(",", $seznamCiselObjednavek) . " byl smazán.";
					$_SESSION["classmessage"]="success";
					$this->getRequest->goBackRef();
				}
			}

		}
	}

	public function createAjaxAction()
	{
		if($this->getRequest->isPost() && "ins_message" === $this->getRequest->getPost('F_CommentsCreate_action', false))
		{
			// načtu Objekt formu

			$form = $this->formLoad('CommentsCreate');
			// Provedu validaci formu
			if ($form->isValid($form->getPost()))
			{

				$model = new models_Comments();

				$postdata = $form->getValues();
				$data = array();

				if (defined("USER_ID")) {
					$data["user_id"] = USER_ID;
				}

				if (isset($postdata["category_id"])) {
					$data["parent_id"] = $postdata["category_id"];
				}
				$data["text"] = $postdata["message"];
				$data["ip"] = $_SERVER["REMOTE_ADDR"];

				if ($model->insertRecords($model->getTableName(), $data)) {
					$form->setResultSuccess("Zpráva byla vložena.");

					return true;
				//	$this->getRequest->goBackRef();
				}


			}
		}
	}
	public function createAction()
	{
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('ins_message', false))
		{
			// načtu Objekt formu
			$form = $this->formLoad('CommentsCreate');
			// Provedu validaci formu


			if ($form->isValid($this->getRequest->getPost()))
			{
				$model = new models_Comments();

				$postdata = $form->getValues();
				$data = array();

				if (defined("USER_ID")) {
					$data["user_id"] = USER_ID;
				}

				if (isset($postdata["category_id"])) {
					$data["parent_id"] = $postdata["category_id"];
				}
				$data["text"] = $postdata["message"];
				$data["ip"] = $_SERVER["REMOTE_ADDR"];

				if ($model->insertRecords($model->getTableName(), $data)) {
					$form->setResultSuccess("Zpráva byla vložena.");
					$this->getRequest->goBackRef();
				}
			//	print $model->getLastQuery();

			} else {
				foreach($form->getError() as $key => $value)
				{
					$_SESSION["statusmessage"]= $key . ": ". $value;
				}
				//print_r($form->getError());

				$_SESSION["classmessage"]="errors";
				return false;
			}
		}

		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('send_message', false))
		{
			// načtu Objekt formu
			$form = $this->formLoad('CommentsPublicCreate');
			// Provedu validaci formu


			if ($form->isValid($this->getRequest->getPost()))
			{
				$model = new models_Comments();

				$postdata = $form->getValues();
				$data = array();

				if (defined("USER_ID")) {
					$data["user_id"] = USER_ID;
				}

				if (md5(strtolower($postdata["captcha"])) != $_SESSION["captcha"]) {
					$_SESSION["classmessage"]="errors";
					$_SESSION["statusmessage"]= "Kontrolní kód se neshoduje!!";
					//	$_SESSION["err_elem"]["email"] = "Tento email je již registrován!";
					return false;
				}

/*
				if ((false !== $this->getRequest->getPost('but1', false)
					&& false !== $this->getRequest->getPost('but2', false))
					|| (false == $this->getRequest->getPost('but1', false)
					&& false == $this->getRequest->getPost('but2', false)))
				{
					return false;
				}
				*/
				if (defined("PAGE_ID")) {
					$data["parent_id"] = PAGE_ID;
				}
				if (isset($postdata["category_id"])) {
					$data["parent_id"] = $postdata["category_id"];
				}
				if (isset($postdata["nick"])) {
					$data["nick"] = $postdata["nick"];
				}
				if (isset($postdata["email"])) {
					$data["email"] = $postdata["email"];
				}
				$data["text"] = $postdata["message"];
				$data["ip"] = $_SERVER["REMOTE_ADDR"];
				//print_r($data);
				if ($model->insertRecords($model->getTableName(), $data)) {
					$_SESSION["statusmessage"]="Message was added.";
					$_SESSION["classmessage"]="success";
					$this->getRequest->goBackRef();
				}

			} else {
				foreach($form->getError() as $key => $value)
				{
					$_SESSION["err_elem"][$key] = $value;
					$_SESSION["statusmessage"]= $key . ": ". $value;
				}
				//print_r($form->getError());

				$_SESSION["statusmessage"]= $this->translator->prelozitFrazy("not_filled_in_all_required_fields")."!";
				$_SESSION["classmessage"]="errors";
				return false;
			}
		}
	}

	public function commentsList($params = array())
	{
		$model = new models_Comments();

		$params2 = array();
		$limit 	= (int) $this->getRequest->getQuery('limit', 100);
		if (isset($params['limit']) && is_numeric($params['limit'])) {
			$limit = $params['limit'];
		}
		$params2["limit"] = $limit;

		$page 	= (int) $this->getRequest->getQuery('pg', 1);
		$params2["page"] = $page;

		$search_string = $this->getRequest->getQuery('q', '');
		$params2["fulltext"] = $search_string;



		if (isset($params['category_id']) && is_numeric($params['category_id'])) {
			$params2['category_id'] = $params['category_id'];
		}

		$querys = array();

		$querys[] = array('title'=>'Název','url'=>'name','sql'=>'t1.nick');
		$querys[] = array('title'=>'Popis','url'=>'desc','sql'=>'t1.text');
		$orderFromQuery = $this->orderFromQuery($querys, 't1.timeStamp DESC');
		$params2["order"] = $orderFromQuery;

		$l = $model->getList($params2);
		$this->total = $model->total;

		return $l;
	}

	public function commentsListTable($params = array())
	{

		$l = $this->commentsListEdit($params);

		//print_r($l);
		$sorting = new G_Sorting("num","desc");

		$data = array();
		$th_attrib = array();
		$column["checkbox"] = '<input onclick="multi_check(this);" type="checkbox">';
		$column["text"] = '';
		//$column["cislo_mat"] = $sorting->render("Číslo", "num");
		$column["nick"] = $sorting->render("Jméno", "name");
		$column["category_nazev"] = $sorting->render("Umístění", "tree");

		$column["cmd"] = '';

		$th_attrib["checkbox"]["class"] = "check-column";
		$th_attrib["nick"]["class"] = "column-cat";
		$th_attrib["category_nazev"]["class"] = "column-cat";

		$th_attrib["cmd"]["class"] = "column-cmd";


		$td_attrib["qty"]["class"] = "column-qty";
		$td_attrib["prodcena"]["class"] = "column-price";

		$table = new G_Table($l, $column, $th_attrib, $td_attrib);


		$table_attrib = array(
								"class" => "widefat fixed",
								"id" => "data_grid",
								"cellspacing" => "0",
								);
		return $table->makeTable($table_attrib);

	}

	public function commentsListEdit($params = array())
	{
		$l = $this->commentsList($params);


		for($i=0;$i<count($l);$i++)
		{

		//	$url= URL_HOME . 'admin/user_detail.php?id=' . $l[$i]->uid;

			if ($l[$i]->prihlasen == 1 && ($l[$i]->casnaposledy + 30) > time()){
				$status = "online";
			} else {
				$status = "offline";
			}
			$l[$i]->nick = '<a href="'.$url.'"><span class="'. $status . '">' . $l[$i]->nick . '</span></a>';
			$l[$i]->last_active = date("j.n.Y H:i:s",strtotime($l[$i]->naposledy));
			if ( (isset($_POST["slct"][$i]) && is_numeric($_POST["slct"][$i])) )
			{
				$elem = new G_Form_Element_Checkbox("slct[" . $i . "]");
				$elem->setAttribs('value', $l[$i]->uid);
				$elem->setAttribs('checked', 'checked');
				$l[$i]->checkbox = $elem->render();

				$elem = new G_Form_Element_Text("jmeno[" . $i . "]");
				$value = $this->getRequest->getPost("jmeno[" . $i . "]", $l[$i]->jmeno);
				$elem->setAttribs('value',$value);
				$l[$i]->jmeno = $elem->render();

				$elem = new G_Form_Element_Text("prijmeni[" . $i . "]");
				$value = $this->getRequest->getPost("prijmeni[" . $i . "]", $l[$i]->prijmeni);
				$elem->setAttribs('value',$value);
				$l[$i]->prijmeni = $elem->render();

				$elem = new G_Form_Element_Text("email[" . $i . "]");
				$value = $this->getRequest->getPost("email[" . $i . "]", $l[$i]->email);
				$elem->setAttribs('value',$value);
				$l[$i]->email = $elem->render();

				$elem = new G_Form_Element_Text("mobil[" . $i . "]");
				$value = $this->getRequest->getPost("mobil[" . $i . "]", $l[$i]->mobil);
				$elem->setAttribs('value',$value);
				$l[$i]->mobil = $elem->render();





				$l[$i]->cmd = '';
			} else {
				$elem = new G_Form_Element_Checkbox("slct[" . $i . "]");
				$elem->setAttribs('value', $l[$i]->uid);
				//$elem->setAttribs('checked', 'checked');
				$l[$i]->checkbox = $elem->render();

				if ($l[$i]->category==0)
				{
					$category =  '<span>Nezařazené</span>';
				} else {
					$link_item = categoryToUrl($l[$i]->serial_cat_nazev,"/");
					$category = '<a title="'.$link_item.'" href="' . URL_HOME . 'admin/cat.php?id=' . $l[$i]->category . '">' . $link_item . '</a>';
				}

				$l[$i]->category_nazev = $category;

				if (!is_null($l[$i]->user_id)) {
					$l[$i]->nick = '<a href="' . URL_HOME . 'admin/user_detail.php?id=' . $l[$i]->user_id . '">' . $l[$i]->regnick . '</a>';
				}
				$l[$i]->nick .='<br />' . date("j.n.Y H:i:s",strtotime($l[$i]->TimeStamp));


				$command = '<input class="" style="border:0 none;background-color:transparent;" onclick="return confirm(\'Opravdu komentář?\')" type="image" src="'.URL_HOME . 'admin/images/cancel.png" value="X" name="remove_action[' . $i . ']"/>';
				$command .= '<input type="hidden" value="' . $l[$i]->id . '" name="item_id[' . $i . ']"/>';
				$l[$i]->cmd = $command;
			}

		}
		return $l;
	}
}