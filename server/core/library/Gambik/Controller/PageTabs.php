<?php

require_once(dirname(__FILE__).'/../G_Tabs.php');
class PageTabs extends G_Tabs {

	protected $form;
	protected $languageList;
	protected $entityName;
	public function __construct($pageForm, $entityName=null)
	{

		$this->form = $pageForm;
		//	$form = new F_CategoryEdit();
		$this->entityName = $entityName;
		$languageModel = new models_Language();
		$this->languageList = $languageModel->getActiveLanguage();

		$tab = array("name" => "Foto", "title" => '<span id="fotoCountTab">Fotogalerie</span>',"content" => $this->FotoTabs());
		$this->addTab($tab);

		$tab = array("name" => "Files", "title" => '<span id="filesCountTab">Soubory</span>',"content" => $this->FileTabs());
		$this->addTab($tab);

		$tab = array("name" => "Seo", "title" => "SEO","content" => $this->SeoTabs());
		$this->addTab($tab);

	//	$tab = array("name" => "Access", "title" => "Přístup","content" => $this->AccessTabs());
	//	$this->addTab($tab);
	}

	protected function MainTabs()
	{

	}
	protected function SeoTabs()
	{
		$contentSeo = '';
		$form = $this->form;
		$languageList = $this->languageList;
		// Verzování dle jazyků
		$first = true;

	//	print_R($form);
//		print_r($form->getElement("title", "Post"));

//		$elements = $form->getElement("PostVersion[][pagetitle]");

	//	print_r($elements);
		foreach ($languageList as $key => $val)
		{
			$style = ($first) ? "display:block;" : "display:none;";$first = false;
			$contentSeo .= '<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("pagetitle_$val->code")->render()  . '</div>';
		}
		if ($form->getElement("id")) {
			$contentSeo .=$form->getElement("id")->render();
		}

		$contentSeo .= '<p class="desc"></p><br />';


		$first = true;
		foreach ($languageList as $key => $val)
		{
			$style = ($first) ? "display:block;" : "display:none;";$first = false;
			$contentSeo .= '<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("pagekeywords_$val->code")->render() . '</div>';
		}
		$contentSeo .= '<p class="desc"></p><br />';


		$first = true;
		foreach ($languageList as $key => $val)
		{
			$style = ($first) ? "display:block;" : "display:none;";$first = false;
			$contentSeo .= '<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("pagedescription_$val->code")->render() . '</div>';
		}
		$contentSeo .= '<p class="desc"></p><br />';

		$first = true;
		foreach ($languageList as $key => $val)
		{
			$style = ($first) ? "display:block;" : "display:none;";$first = false;
			$contentSeo .= '<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("tags_$val->code")->render() . '</div>';
		}
		$contentSeo .= '<p class="desc"></p><br />';

		$first = true;
		foreach ($languageList as $key => $val)
		{
			if ($form->getElement("url_$val->code")) {


				$style = ($first) ? "display:block;" : "display:none;";$first = false;
				$contentSeo .= '<div class="lang lang_' .$val->code. '" style="' .$style. '">'; 
        
        $contentSeo .=$form->getElement("url_$val->code")->render();
        
        if (count($languageList) > 1) {
          $name = "link_" . $val->code; 
          
          
          
          $contentSeo .= '<div class="form-group"><label for="url_cs" class="control-label">Odkaz</label>';
$contentSeo .= '<input value="' . $form->page->$name . '" style="font-weight:bold;" class="textbox form-control" name="" type="text" onclick="select();" readonly></div> ';
 $contentSeo .= '<p class="desc"><a target="_blank" href="' . $form->page->$name . '">' . $form->page->$name . '</a></p>';

         // $contentSeo .= $form->page->$name;        
        }

        
        $contentSeo .='</div>';
			}
	
  
  
  	}
    
    if (count($languageList) == 1) {
      
          $contentSeo .= '<div class="form-group"><label for="url_cs" class="control-label">Odkaz</label>';
$contentSeo .= '<input value="' . $form->page->link . '" style="font-weight:bold;" class="textbox form-control" name="" type="text" onclick="select();" readonly></div> ';

$contentSeo .= '<p class="desc"><a target="_blank" href="' . $form->page->link . '">' . $form->page->link . '</a></p>';
    }
		


		return $contentSeo;

	}
	protected function FotoTabs()
	{
		$contentFoto = '';

		$form = $this->form;




		//	$contentSeo .= '<p class="desc"></p><br />';

		if ($form->getElement("id")) {
               /*
			$filesUploadAdapter = new PageFotoUploaderAdapter($form->getElement("id")->getValue(),$this->entityName);
			$contentFoto = '
				<div class="fieldset flash" id="fsUploadProgress'.$filesUploadAdapter->getInstanceId() . '">
					<span class="legend">Fronta nahrávaných souborů</span>
				</div>
				<div id="divStatus'.$filesUploadAdapter->getInstanceId() . '">0 Nahraných souborů</div>
				<div>
					<span id="spanButtonPlaceHolder'.$filesUploadAdapter->getInstanceId().'"></span>
					<input id="btnCancel'.$filesUploadAdapter->getInstanceId() . '" type="button" value="Přerušit nahrávání" onclick="swfu'.$filesUploadAdapter->getInstanceId() . '.cancelQueue();" disabled="disabled" style="margin-left: 2px; font-size: 8pt; height: 29px;" />
				</div>';
			$contentFoto .= '<div id="gallery_items"></div>';
			$contentFoto .= $filesUploadAdapter->scriptRender();
           */
      
			$contentFoto = jqueryUploadInit($form->getElement("id")->getValue(),$this->entityName);
      	$contentFoto .= '<div id="gallery_items"></div>';
		}

		return $contentFoto;
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

	protected function AccessTabs()
	{
		$contentFoto = '';
		$form = $this->form;

		$contentFoto .=$form->getElement("pristup")->render();
		$contentFoto .= '<div>';
		if ($form->getElement("user_assoc_id[]")) {


			$categoryA = $form->getElement("user_assoc_id[]");
			//print_r($form->elements);
			foreach ($categoryA as $key => $val)
			{
				//print_r($val);
				$contentFoto .= $val->render();

				$contentFoto .= '<p class="desc"></p><br />';
			}
		}
		$contentFoto .= '</div>';
		return $contentFoto;

	}

	public function makeTabs($tabs = array()) {


/*
		array_push($tabs, array("name" => "Foto", "title" => '<span id="fotoCountTab">Fotogalerie</span>',"content" => $this->FotoTabs()));
		array_push($tabs, array("name" => "Files", "title" => '<span id="filesCountTab">Soubory</span>',"content" => $this->FileTabs()));
		array_push($tabs, array("name" => "Seo", "title" => "SEO","content" => $this->SeoTabs()));
		array_push($tabs, array("name" => "Access", "title" => "Přístup","content" => $this->AccessTabs()));
*/
		return parent::makeTabs($tabs);
	}
}