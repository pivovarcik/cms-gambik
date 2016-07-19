<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2012
 */

class MessageTabs extends G_Tabs {

	protected $form;
	protected $entityName;
	public function __construct($pageForm)
	{

		$this->form = $pageForm;
		//	$form = new Application_Form_CategoryEdit();
		$this->entityName = "Message";
	}

	protected function MainTabs()
	{
		$form = $this->form;
		$contentMain ='';
		$contentMain .=$form->getElement("adresat_id")->render();
		$contentMain .='<p class="desc"></p><br />';
		$contentMain .=$form->getElement("message")->render();
		$contentMain .='<p class="desc"></p><br />';
		return $contentMain;

	}

	public function makeTabs($tabs = array()) {


		array_push($tabs, array("name" => "Main", "title" => 'Obecné',"content" => $this->MainTabs()));
		return parent::makeTabs($tabs);
	}

}

class MessageController extends G_Controller_Action
{
	var $versioning = true;

	public function setReader($id)
	{
		$model = new models_Message();
		$data = array();
		$data["ReadTimeStamp"] = date("Y-m-d H:i:s");
		return $model->updateRecords($model->getTablename(),$data, "id=".$id);
	}
	public function saveAction()
	{

		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('upd_cat', false) && false !== $this->getRequest->getPost('id', false))
		{
			// načtu Objekt formu
			$form = $this->formLoad('CategoryEdit');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{

				$this->versioning = (VERSION_CATEGORY == 1) ? true : false;
				//print_r($form->page);
				$entity = new CategoryEntity();
				$versionEntity = new CategoryVersionEntity();

				$model = new models_Category();

				$postdata = $form->getValues();
				$data = array();

				// stejný čas
				$caszapsani = date("Y-m-d H:i:s");
				//$page_id = 0;
				if ($this->versioning) {
					$version = $form->page->version+1;

				} else {
					$version = $form->page->version;
				}

				$data["version"] = $version;

				//$data["user_edit"] = USER_ID;

				$page_id = (int) $this->getRequest->getPost('id', 0);

				if ($page_id == 0) {
					$_SESSION["statusmessage"]= "ID is not specified";
					$_SESSION["classmessage"]="errors";
					return false;
				}

				if (isset($postdata["category_id"])) {
					$data["category_id"] = $postdata["category_id"];

					if ($data["category_id"] == $page_id) {
						$_SESSION["statusmessage"]= "Nelze vybrat jako umístění sám sebe!";
						$_SESSION["classmessage"]="errors";
						return false;
					}
				}
/*
				if (isset($postdata["date_public"])) {
					$data["caszobrazeni"] = date("Y-m-d H:i:s", strtotime($postdata["date_public"]));
				}
				*/

				$languageModel = new models_Language();
				$languageList = $languageModel->getActiveLanguage();
				// Verzování dle jazyků

				$all_query_ok=true;
				$model->start_transakce();

				foreach ($languageList as $key => $val){
					$versionData = array();
					$versionData["caszapsani"] = $caszapsani;
					$versionData["lang_id"] = $val->id;
					$versionData["page_id"] = $page_id;

					$versionData["user_id"] = USER_ID;
					$versionData["version"] = $version;

					if (isset($postdata["category_id"])) {
						$versionData["category_id"] = $postdata["category_id"];
					}
					if (isset($postdata["title_$val->code"])) {
						$versionData["title"] = $postdata["title_$val->code"];
					}
					if (isset($postdata["perex_$val->code"])) {
						$versionData["perex"] = $postdata["perex_$val->code"];
					}
					if (isset($postdata["description_$val->code"])) {
						$versionData["description"] = $postdata["description_$val->code"];
					}
					if (isset($postdata["pagetitle_$val->code"])) {
						$versionData["pagetitle"] = $postdata["pagetitle_$val->code"];
					}
					if (isset($postdata["pagedescription_$val->code"])) {
						$versionData["pagedescription"] = $postdata["pagedescription_$val->code"];
					}

					if (isset($postdata["pagekeywords_$val->code"])) {
						$versionData["pagekeywords"] = $postdata["pagekeywords_$val->code"];
					}

					if (isset($postdata["url_$val->code"])) {
						$versionData["url"] = $postdata["url_$val->code"];
					} else {
						$versionData["url"] = strToUrl($versionData["title"]);
					}

					if ($this->versioning) {
						$model->insertRecords($versionEntity->getTablename(),$versionData);
					} else {
						$model->updateRecords($versionEntity->getTablename(),$versionData,"page_id=" . $page_id . " and lang_id=" . $val->id . " and version=" . $version);
					}
					$model->commit ? null : $all_query_ok = false;
				}

				$model->updateRecords($model->getTableName(), $data, "id={$page_id}");
				$model->commit ? null : $all_query_ok = false;

				if($model->konec_transakce($all_query_ok))
				{
					$_SESSION["statusmessage"]="Section has been updated.";
					$_SESSION["classmessage"]="success";
					$this->getRequest->goBackRef();
					EXIT;
				}

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
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('action_hromadne', false) && false !== $this->getRequest->getPost('edit', false))
		{

			if($this->getRequest->isPost() && 'edit_finish' == $this->getRequest->getPost('action', ''))
			{
				if (!empty($params['lang'])){
					$znak = $params['lang'] ;
				} else {
					$znak = LANG_TRANSLATOR ;
				}
				if (!defined("LANG_TRANSLATOR") || LANG_TRANSLATOR == "") {
					$znak = LANG_TRANSLATOR;
				} else{
					$znak = 'cs';
				}

				$models = new models_Publish();
				$vybranePolozky = $this->getRequest->getPost('slct', array());


				$data = array();
				if (false !== $this->getRequest->getPost('titulek', false)) {
					$data["titulek_" . $znak] = $this->getRequest->getPost('titulek', array());
				}
				if (false !== $this->getRequest->getPost('podtitulek', false)) {
					$data["podtitulek_" . $znak] = $this->getRequest->getPost('podtitulek', array());
				}
				if (false !== $this->getRequest->getPost('category', false)) {
					$data["category"] = $this->getRequest->getPost('category', array());
				}
				$pocitadlo = 0;
				$pocet = count($vybranePolozky);
				for($i=0;$i<100;$i++)
				{
					if (isset($vybranePolozky[$i]))
					{
						$changes = array();
						foreach ($data as $key => $value)
						{
							//	print_r($key);
							//	print_r($value);

							$changes[$key] = $value[$i];
							$changes["last_edit"] = date("Y-m-d H:i:s");
							$changes["user_edit"] = USER_ID;

						}
					//	print_r($changes);
						$models->updateRecords($models->getTableName(), $changes, "uid={$vybranePolozky[$i]}");
						$pocitadlo++;
					}
					if ($pocitadlo==$pocet)
					{
						break;
					}
				}

				//$this->getRequest->clearPost();
				$this->getRequest->goBackRef();
				exit;
			}
		}
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('clear', false))
		{
			$this->getRequest->clearPost();
		}
	}

	public function createAction()
	{

		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('ins_message', false))
		{
			// načtu Objekt formu
			$form = $this->formLoad('MessageCreate');

			$translator = G_Translator::instance();
			// Provedu validaci formu


			if ($form->isValid($this->getRequest->getPost()))
			{
				$entity = new MessageEntity();

				$model = new models_Message();

				$postdata = $form->getValues();
				$data = array();


				//$data["last_modified_date"] = $caszapsani;
				$data["autor_id"] = USER_ID;
				//$data["adresat_id"] = USER_ID;


				if (isset($postdata["adresat_id"])) {
					if ($postdata["adresat_id"] == USER_ID) {
						// nelze poslat zprávu sám sobě

						return false;
					}
					$data["adresat_id"] = $postdata["adresat_id"];
				}
				$data["message"] = $postdata["message"];

				if ($model->setMessage($data["autor_id"], $data["adresat_id"], $data["message"])) {
					$form->setResultSuccess($translator->prelozitFrazy("message_was_added"));
					$this->getRequest->goBackRef();
				}


			}
		}

		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('send_message', false))
		{
			$translator = G_Translator::instance();
			// načtu Objekt formu
			$form = $this->formLoad('MessageUserCreate');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{
				$entity = new MessageEntity();

				$model = new models_Message();

				$postdata = $form->getValues();
				$data = array();


				//$data["last_modified_date"] = $caszapsani;
				$data["autor_id"] = USER_ID;
				//$data["adresat_id"] = USER_ID;
				$data["adresat_id"] = 3;

				$data["message"] = $postdata["message"];

				if ($model->setMessage($data["autor_id"], $data["adresat_id"], $data["message"])) {
					$form->setResultSuccess($translator->prelozitFrazy("message_was_added"));
					$this->getRequest->goBackRef();
				}
			}
		}
	}

	public function sendMailAction($email,$data)
	{

	}
	public function sendNeverReadMessagesAction()
	{
		$params = array();
		$params["new"] = 1;
		$params["send_info_mail"] = 0;
		$params["order"] = "adresat_id ASC,TimeStamp DESC";
		$l = $this->messagesList($params);

		$dalsi_adresat = false;
		$pamatuj_adresata = "";
		for($i=0;$i<count($l);$i++)
		{
			if ($dalsi_adresat) {
				// send email;

				$this->sendMailAction($l[$i]->adresat_email,$data);
				$dalsi_adresat = false;
			}

			if ($l[$i]->adresat_id <> $pamatuj_adresata) {
				$dalsi_adresat = true;
			} else {
				//$dalsi_adresat = true;
			}

			$url_odesilatel = URL_HOME . 'admin/user_detail.php?id=' . $l[$i]->autor_id;
			$url_adresat = URL_HOME . 'admin/user_detail.php?id=' . $l[$i]->adresat_id;


		//	$l[$i]->adresat_jmeno = '<a href="'.$url_adresat.'">'.$l[$i]->adresat_jmeno.'</a>';
		//	$l[$i]->autor_jmeno = '<a href="'.$url_odesilatel.'">'.$l[$i]->autor_jmeno.'</a>';
			$l[$i]->TimeStamp = date("j.n.Y H:i:s",strtotime($l[$i]->TimeStamp));

			$pamatuj_adresata = $l[$i]->adresat_id;


		}
		return $l;
	}

	public function getCategory($id)
	{
		//$id = $this->getRequest->getQuery("id",0);
		$id = (int) $id;
		$url = $this->getRequest->getQuery("item","");
		if ($id >0) {
		//	print "tudy " . $id;

			$model = new models_Category();
			$detail = $model->getDetailById($id);
		} elseif (!empty($url)) {
			$model = new models_Category();
			$detail = $model->getPublishByUrl($url);
		} else {
			print "{CategoryController} nebyl specifkován požadavek!";
			return false;
		}
		if ($detail) {

			$detail->pagetitle = !empty($detail->pagetitle) ? $detail->pagetitle : $detail->title;
			//$detail->pagekeywords = !empty($detail->pagekeywords) ? $detail->pagekeywords : $detail->titulek;
			$detail->pagedescription = !empty($detail->pagedescription) ? $detail->pagedescription : $detail->description;
			return $detail;
		}

	}
	public function messagesListEdit($params = array())
	{
		$l = $this->messagesList($params);

		//print_r($l);
		for($i=0;$i<count($l);$i++)
		{

			$l[$i]->checkbox = "";
			if (empty($l[$i]->ReadTimeStamp) && $l[$i]->autor_id <> USER_ID) {
				$this->setReader($l[$i]->id);
			//	print "přečteno";
			}

			$url_odesilatel = URL_HOME . 'admin/user_detail.php?id=' . $l[$i]->autor_id;
			$url_adresat = URL_HOME . 'admin/user_detail.php?id=' . $l[$i]->adresat_id;


			$l[$i]->adresat_jmeno = '<a href="'.$url_adresat.'">'.$l[$i]->adresat_jmeno.'</a>';
			$l[$i]->autor_jmeno = '<a href="'.$url_odesilatel.'">'.$l[$i]->autor_jmeno.'</a>';
			$l[$i]->TimeStamp = date("j.n.Y H:i:s",strtotime($l[$i]->TimeStamp));

			$l[$i]->OdeslanoPreceteno = date("j.n.Y H:i:s",strtotime($l[$i]->TimeStamp)) . "<br />";

			if ($l[$i]->precteno == 1) {
				$l[$i]->OdeslanoPreceteno .= date("j.n.Y H:i:s",strtotime($l[$i]->ReadTimeStamp));
			} else {
				$l[$i]->OdeslanoPreceteno .= "Nepřečteno";
			}

			$url_odpoved = URL_HOME . 'admin/add_message.php?adresat_id=' . $l[$i]->autor_id;

			$commnad = '<a href="'.$url_odpoved.'">odpovědět</a>';
			$l[$i]->cmd = $commnad;


		}
		return $l;
	}
	public function messagesList($params = array())
	{
		$model = new models_Message();

		$params2 = array();
		$limit 	= (int) $this->getRequest->getQuery('limit', 100);
		if (isset($params['limit']) && is_numeric($params['limit'])) {
			$limit = $params['limit'];
		}
		//$params2['lang'] = LANG_TRANSLATOR;
		$params2["limit"] = $limit;

		$page 	= (int) $this->getRequest->getQuery('pg', 1);
		$params2["page"] = $page;

		$search_string = $this->getRequest->getQuery('q', '');
		$params2["fulltext"] = $search_string;

		if(isset($params['send_info_mail']) && is_int($params['send_info_mail']))
		{
			$params2["send_info_mail"] = $params["send_info_mail"];
		}

		if(isset($params['new']))
		{
			$params2["new"] = 1;
		}

		if(isset($params['autor']))
		{
			$params2["autor"] = (int) $params['autor'];
		}

		if(isset($params['adresat_autor']))
		{
			$params2["adresat_autor"] = (int) $params['adresat_autor'];
		}

		if(isset($params['adresat']))
		{
			$params2["adresat"] = (int) $params['adresat'];
		}

		$querys = array();

		$querys[] = array('title'=>'Název','url'=>'name','sql'=>'v.title');
		$querys[] = array('title'=>'Popis','url'=>'desc','sql'=>'v.description');
		$orderFromQuery = $this->orderFromQuery($querys, 'm.TimeStamp DESC');
		$params2["order"] = $orderFromQuery;

		if(isset($params['order']))
		{
			$params2["order"] = $params['order'];
		}

		$l = $model->getList($params2);
	//	print $model->getLastQuery();
		$this->total = $model->total;





		for($i=0;$i<count($l);$i++)
		{
			if ($l[$i]->autor_prihlasen == 1 && ($l[$i]->autor_casnaposledy + 60*6) > time()){
				$autor_status = "online";
			} else {
				$autor_status = "offline";
			}

			if ($l[$i]->adresat_prihlasen == 1 && ($l[$i]->adresat_casnaposledy + 60*6) > time()){
				$adresat_status = "online";
			} else {
				$adresat_status = "offline";
			}
			$l[$i]->autor_nick = '<span class="'. $autor_status . '">' . $l[$i]->autor . '</span>';
			$l[$i]->adresat_nick = '<span class="'. $adresat_status . '">' . $l[$i]->adresat . '</span>';

			$l[$i]->autor_jmeno = '<span class="'. $autor_status . '">' . $l[$i]->autor_jmeno . '</span>';
			$l[$i]->adresat_jmeno = '<span class="'. $adresat_status . '">' . $l[$i]->adresat_jmeno . '</span>';

		}
		//print_r($l);
		return $l;
	}
}
?>