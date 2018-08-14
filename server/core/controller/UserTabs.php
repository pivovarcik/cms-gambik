<?php


class UserTabs extends G_Tabs {

	protected $form;
	protected $entityName;
	public function __construct($pageForm)
	{

		$this->form = $pageForm;
		$this->entityName = "User";
	}

	protected function MainTabs()
	{
		$form = $this->form;
		$contentMain ='';


		$contentMain .='<div class="form-group">';
		$contentMain .=$form->getElement("nick")->render();
		$contentMain .='<p class="help-block">Uživatelské jméno musí být unikátní</p>';
		$contentMain .='</div>';


		$contentMain .=$form->getElement("email")->render();
		$contentMain .='<p class="desc"></p><br />';
		$contentMain .=$form->getElement("role")->render();
		$contentMain .='<p class="desc"></p><br />';


		$contentMain .=$form->getElement("newpassword")->render();
		$contentMain .='<p class="desc"></p><br />';

		$contentMain .=$form->getElement("aktivni")->render();
		$contentMain .='<p class="desc"></p><br />';

		$contentMain .=$form->getElement("newsletter")->render();
		$contentMain .='<p class="desc"></p><br />';


		return $contentMain;

	}

	protected function personTabs()
	{
		$form = $this->form;
		$contentMain .=$form->getElement("jmeno")->render();
		$contentMain .='<p class="desc"></p><br />';
		$contentMain .=$form->getElement("prijmeni")->render();
		$contentMain .='<p class="desc"></p><br />';
		$contentMain .=$form->getElement("titul")->render();
		$contentMain .='<p class="desc"></p><br />';
		$contentMain .=$form->getElement("sex")->render();
		$contentMain .='<p class="desc"></p><br />';
		$contentMain .=$form->getElement("telefon")->render();
		$contentMain .='<p class="desc"></p><br />';
		$contentMain .=$form->getElement("mobil")->render();
		$contentMain .='<p class="desc"></p><br />';

		return $contentMain;
	}

	protected function RoleTabs()
	{
		$form = $this->form;
		$contentRoles =$form->getElement("p1")->render();
		$contentRoles .='<p class="desc"></p><br />';
		$contentRoles .=$form->getElement("p2")->render();
		$contentRoles .='<p class="desc"></p><br />';
		$contentRoles .=$form->getElement("p3")->render();
		$contentRoles .='<p class="desc"></p><br />';
		$contentRoles .=$form->getElement("p4")->render();
		$contentRoles .='<p class="desc"></p><br />';
		$contentRoles .=$form->getElement("p5")->render();
		$contentRoles .='<p class="desc"></p><br />';
		$contentRoles .=$form->getElement("p6")->render();
		$contentRoles .='<p class="desc"></p><br />';
		$contentRoles .=$form->getElement("p7")->render();
		$contentRoles .='<p class="desc"></p><br />';
		$contentRoles .=$form->getElement("p8")->render();
		$contentRoles .='<p class="desc"></p><br />';
		$contentRoles .=$form->getElement("p9")->render();
		$contentRoles .='<p class="desc"></p><br />';
		$contentRoles .=$form->getElement("p10")->render();

		if ($form->getElement("id")) {

			$contentRoles .=$form->getElement("id")->render();
		}
		$contentRoles .='<p class="desc"></p><br />';

		return $contentRoles;
	}

	protected function ProtokolTabs()
	{
		$contentProtokol = '';

		$form = $this->form;
		if ($form->getElement("id")) {
			$params = array();
			//$params["uid_user"] = USER_ID;
			$params["order"] = "t1.TimeStamp DESC";
			$params['user'] = $form->getElement("id")->getValue();
			$protokolController = new ProtokolController();
			//$l = $predfakturyController->predfakturyList();
			$l = $protokolController->protokolListEdit($params);


			$data = array();
			$th_attrib = array();
			//$column["checkbox"] = '<input onclick="multi_check(this);" type="checkbox">';
			$column["counter"] = '#';

			$column["akce"] = 'Akce';
			$column["TimeStamp"] = 'Kdy';
			$column["nick"] = 'Uživatel';
			$column["ip"] = 'IP';
			$column["protokol"] = 'Popis';



			$th_attrib["counter"]["class"] = "check-column";
			$th_attrib["akce"]["class"] = "check-cat";
			$th_attrib["caszapsani"]["class"] = "column-date";
			$th_attrib["nick"]["class"] = "column-autor";
			$th_attrib["ip"]["class"] = "column-autor";
			$th_attrib["caszapsani"]["class"] = "column-date";


			$th_attrib["cmd"]["class"] = "column-cmd";


			$td_attrib["qty"]["class"] = "column-qty";
			$td_attrib["prodcena"]["class"] = "column-price";

			$table = new G_Table($l, $column, $th_attrib, $td_attrib);


			$table_attrib = array(
					"class" => "widefat fixed",
					"id" => "data_grid",
					"cellspacing" => "0",
					);

			$limit = 100;
			$page = isset($_GET["pg"]) ? $_GET["pg"] : 1;
			//$pager = new G_Paginator($page, count($l), $limit);
			$pager = new G_Paginator($page, $protokolController->total, $limit);
			$output = $pager->render();

			$contentProtokol = $output;
			$contentProtokol .= $table->makeTable($table_attrib);
			$contentProtokol .= $output;
		}
		return $contentProtokol;
	}
	protected function FileTabs()
	{
		$contentFoto = '';

		$form = $this->form;
		if ($form->getElement("id")) {


			$filesUploadAdapter = new PageFileUploaderAdapter($form->getElement("id")->getValue(),$this->entityName);
			//	$GHtml->setCokolivToHeader($filesUploadAdapter->scriptRender());

			$contentFoto = '
			<div class="fieldset flash" id="fsUploadProgress'.$filesUploadAdapter->getInstanceId() . '">
				<span class="legend">Fronta nahrávaných souborů</span>
			</div>
			<div id="divStatus'.$filesUploadAdapter->getInstanceId() . '">0 Nahraných souborů</div>
			<div>
				<span id="spanButtonPlaceHolder'.$filesUploadAdapter->getInstanceId().'"></span>
				<input id="btnCancel'.$filesUploadAdapter->getInstanceId() . '" type="button" value="Přerušit nahrávání" onclick="swfu'.$filesUploadAdapter->getInstanceId() . '.cancelQueue();" disabled="disabled" style="margin-left: 2px; font-size: 8pt; height: 29px;" />
			</div>';
			$contentFoto .= '<div id="files_items"></div>';


			$contentFoto .= $filesUploadAdapter->scriptRender();
			//$script = swfUploadInit($form->getElement("id")->getValue(),T_SHOP_PRODUCT);
			//$script = '<script type="text/javascript">' . swfUploadInit($form->getElement("id")->getValue(),T_SHOP_PRODUCT) . '</script>';

		}
		return $contentFoto;
	}

	public function makeTabs($tabs = array()) {


		array_push($tabs, array("name" => "Main", "title" => 'Hlavní',"content" => $this->MainTabs()));


		array_push($tabs, array("name" => "Person", "title" => 'Osobní údaje',"content" => $this->personTabs()));

		array_push($tabs, array("name" => "Files", "title" => '<span id="filesCountTab">Soubory</span>',"content" => $this->FileTabs()));
		array_push($tabs, array("name" => "Role", "title" => "Práva","content" => $this->RoleTabs()));
		array_push($tabs, array("name" => "Protokol", "title" => "Protokol","content" => $this->ProtokolTabs()));

		return parent::makeTabs($tabs);
	}

}