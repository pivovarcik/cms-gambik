<?php

class SettingsTabs extends G_Tabs {

	protected $form;
	protected $logo_file;
	public function __construct($pageForm)
	{
		parent::__construct("left");
		$this->form = $pageForm;


		$logo_id = $this->form->page["LOGO_FILE_ID"];
		//print_r($form->page);
		//print $logo_id;
		if ($logo_id > 0) {
			$fotoController = new FotoController();
			$fotoDetail = $fotoController->getFoto($logo_id);
			//$imageController = new ImageController();

			if (!empty($fotoDetail->file)) {

				$this->logo_file = URL_IMG . $fotoDetail->file;

			}
		}

	}

	protected function MainTabs()
	{
		$form = $this->form;
		$contentMain = '';
		$contentMain .= $form->getElement("SERVER_TITLE")->render();
		$contentMain .= '<p class="desc">Bude doplněn jako titulek stránky.</p>';
		$contentMain .= $form->getElement("SERVER_DESCRIPTION")->render();
		$contentMain .= '<p class="desc">Popis bude doplněn do hlavičky stránky "Description".</p>';
		$contentMain .= $form->getElement("SERVER_KEYWORDS")->render();
		$contentMain .= '<p class="desc">Klíčová slova budou doplněna do hlavičky stránky "Keywords".</p>';
    

    		$contentMain .= '<div class="row">';
    		$contentMain .= '<div class="col-xs-12 col-sm-4">';
		$contentMain .= $form->getElement("google_analytics_key")->render();
		$contentMain .= '<p class="desc">API klíč pro audit návštěvnosti stránek.<a target="_blank" href="http://www.google.com/analytics/">Google Analytics</a></p>';
           		$contentMain .= '</div>';
              
                  		$contentMain .= '<div class="col-xs-12 col-sm-4">';
		$contentMain .= $form->getElement("GOOGLE_ANALYTICS_POS")->render();
	//	$contentMain .= '<p class="desc">API klíč pro audit návštěvnosti stránek.<a target="_blank" href="http://www.google.com/analytics/">Google Analytics</a></p>';
           		$contentMain .= '</div>';
           		$contentMain .= '</div>';

  		$contentMain .= '<div class="row">';
    		$contentMain .= '<div class="col-xs-12 col-sm-4">';
		$contentMain .= $form->getElement("GOOGLE_TAGMANAGER_KEY")->render();
		$contentMain .= '<p class="desc">API klíč pro audit návštěvnosti stránek.<a target="_blank" href="http://www.google.com/analytics/">Google Analytics</a></p>';
           		$contentMain .= '</div>';
              
                  		$contentMain .= '<div class="col-xs-12 col-sm-4">';
		$contentMain .= $form->getElement("GOOGLE_TAGMANAGER_POS")->render();
	//	$contentMain .= '<p class="desc">API klíč pro audit návštěvnosti stránek.<a target="_blank" href="http://www.google.com/analytics/">Google Analytics</a></p>';
           		$contentMain .= '</div>';
           		$contentMain .= '</div>';
                             
              
		$contentMain .= $form->getElement("GOOGLE_SITE_VERIFICATION")->render();
    
    
		$contentMain .= $form->getElement("SERVER_CSS")->render();
		$contentMain .= '<p class="desc">Tyto CSS budou inicializovány při načtení stránek. Jednotlivé styly oddělujte čárkou.</p>';
          $contentMain .= '<div>';
    $hodnota =  $form->getElement("SERVER_CSS")->getValue();
    $pole = explode(",", $hodnota);
		for($i=0;$i<count($pole);$i++)
		{
			$js = trim($pole[$i]);
			if (!empty($js))
			{ 
      $contentMain .= '<a href="' . $js  . '" target="_blank"><label class="label label-default">' . $js  . '</label></a> ';
            
       }
		}
    
      $contentMain .= '</div>';
     		$contentMain .= '<br />'; 
      
    
		$contentMain .= $form->getElement("SERVER_JS")->render();
         		$contentMain .= '<p class="desc">Javascripty budou inicializovány při načtení stránek. Jednotlivé scripty oddělujte znakem [].</p>';

     $contentMain .= '<div>';
    $hodnota =  $form->getElement("SERVER_JS")->getValue();
    $pole = explode("[]", $hodnota);
		for($i=0;$i<count($pole);$i++)
		{
			$js = trim($pole[$i]);
			if (!empty($js))
			{ 
      $contentMain .= '<a href="' . $js  . '" target="_blank"><label class="label label-default">' . $js  . '</label></a> ';
            
       }
		}
    
      $contentMain .= '</div>';

    
       $contentMain .= '<br />'; 
    
    		$contentMain .= $form->getElement("SERVER_JS_FOOT")->render();

         $contentMain .= '<p class="desc">Javascripty budou inicializovány při načtení stránek. Jednotlivé scripty oddělujte znakem [].</p>';
     $contentMain .= '<div>';
    $hodnota =  $form->getElement("SERVER_JS_FOOT")->getValue();
    $pole = explode("[]", $hodnota);
		for($i=0;$i<count($pole);$i++)
		{
			$js = trim($pole[$i]);
			if (!empty($js))
			{ 
      $contentMain .= '<a href="' . $js  . '" target="_blank"><label class="label label-default">' . $js  . '</label></a> ';
            
       }
		}
    
      $contentMain .= '</div>';
      
     		    $contentMain .= '<br />'; 
        
//		$contentMain .= $form->getElement("FOOTER_JS")->render();
//		$contentMain .= '<p class="desc"></p>';

	//	$contentMain .= $form->getElement("avatar")->render();
	//	$contentMain .= '<p class="desc">Nastavení defaultní velikosti miniatur. Např. 100x100, 150x150.</p><br />';
		$contentMain .= $form->getElement("URL_DOMAIN")->render();
		$contentMain .= '<p class="desc">Přesný název domény pro prezentaci obsahu stránek.</p>';
		$contentMain .= $form->getElement("PAGETITLE_PREFIX")->render();
		$contentMain .= '<p class="desc">Text, který se umístí na konec titulku každé stránky. Např. název web, zaměření, SEO.</p>';
    
    
    
		$contentMain .= $form->getElement("SERVER_FAVICON")->render();
		$contentMain .= '<p class="desc">Url adresa ikonky (např. loga webu). Doporučujeme 16x16 a typ ICO/PNG.</p>';
		$value = $form->getElement("SERVER_FAVICON")->getValue();
		if ( !empty($value) ) { $contentMain .= '<dl><label></label><dt></dt><dd><img src="' . $value . '" /></dd></dl><br />'; }

		$contentMain .= $form->getElement("SERVER_FAVICON32")->render();
		$contentMain .= '<p class="desc">Url adresa ikonky (např. loga webu). Doporučujeme 32X32 a typ ICO/PNG.</p>';
		$value = $form->getElement("SERVER_FAVICON32")->getValue();
		if ( !empty($value) ) { $contentMain .= '<dl><label></label><dt></dt><dd><img src="' . $value . '" /></dd></dl><br />'; }

		$contentMain .= $form->getElement("SERVER_FAVICON96")->render();
		$contentMain .= '<p class="desc">Url adresa ikonky (např. loga webu). Doporučujeme 96X96 a typ ICO/PNG.</p>';
		$value = $form->getElement("SERVER_FAVICON96")->getValue();
		if ( !empty($value) ) { $contentMain .= '<dl><label></label><dt></dt><dd><img src="' . $value . '" /></dd></dl><br />'; }


		$contentMain .= $form->getElement("LICENCE_KEY")->render();
		$contentMain .= $form->getElement("FOOTER_CODE")->render();
		return $contentMain;

	}

	protected function TinyTabs()
	{
		$form = $this->form;

		$contentVarianty = '';
		$contentVarianty .= $form->getElement("TINY_PLUGINS")->render();
		$contentVarianty .= '<p class="desc">rozšíření pro tiny editor</p><br />';
		$contentVarianty .= $form->getElement("TINY_PLUGINS")->render();
		$contentVarianty .= '<p class="desc">rozšíření pro tiny editor</p><br />';
		$contentVarianty .= $form->getElement("TINY_BUTTONS1")->render();
		$contentVarianty .= '<p class="desc">Definice 1. nástrojové lišty</p><br />';
		$contentVarianty .= $form->getElement("TINY_BUTTONS2")->render();
		$contentVarianty .= '<p class="desc">Definice 2. nástrojové lišty</p><br />';
		$contentVarianty .= $form->getElement("TINY_BUTTONS3")->render();
		$contentVarianty .= '<p class="desc">Definice 3. nástrojové lišty</p><br />';
		$contentVarianty .= $form->getElement("TINY_WIDTH")->render();
		$contentVarianty .= '<p class="desc">Velikost editoru</p><br />';
		$contentVarianty .= $form->getElement("TINY_HEIGHT")->render();
		$contentVarianty .= '<p class="desc">Velikost editoru</p><br />';
    
    $contentVarianty .= $form->getElement("TINY_A_CLASS")->render();
    		$contentVarianty .= '<p class="desc">Zapisujte ve formátu: Název třídy1,třída1|Název třídy2,třída2</p><br />';
		$contentVarianty .= $form->getElement("TINY_VALID")->render();
		$contentVarianty .= '<p class="desc">Validace vstupu od uživatele.</p><br />';
		$contentVarianty .= $form->getElement("TINY_CSS")->render();
		$contentVarianty .= '<p class="desc">Definice stylů pro Tiny editor. Obsah souboru <em>editor_css.php</em></p><br />';
		return $contentVarianty;

	}


	protected function SeoTabs()
	{
		$form = $this->form;

		$contentParametry = '';
		/*
		$contentParametry .= $form->getElement("truncate")->render();
		$contentParametry .= '<p class="desc">Délka textu při zkrácení.</p><br />';
		$contentParametry .= $form->getElement("SERVER_REFRESH")->render();
		$contentParametry .= '<p class="desc">Automatický reaload stránek v sekundách (0 = vypnuto)</p><br />';
		*/
		$contentParametry .= $form->getElement("MENU_ROOT_ID")->render();
		$contentParametry .= '<p class="desc">Id výchozí rubriky, která začátek stromu webu</p><br />';
		$contentParametry .= $form->getElement("limit")->render();
		$contentParametry .= '<p class="desc">Počet zobrazovaných řádků, při stránkování</p><br />';
		$contentParametry .= $form->getElement("SERVER_ROBOTS")->render();
		$contentParametry .= '<p class="desc">Nastavení indexování stránek. (index,follow)</p><br />';
		$contentParametry .= $form->getElement("SERVER_GOOGLEBOT")->render();
		$contentParametry .= '<p class="desc">Nastavení indexování stránek speciálné pro google. (index,follow,snippet,archive)</p><br />';
		$contentParametry .= $form->getElement("SERVER_AUTHOR")->render();
		$contentParametry .= '<p class="desc">Autor stránek.</p><br />';

		$contentParametry .= '<fieldset class="well">';
		$contentParametry .= $form->getElement("FACEBOOK_API_ID")->render();
		$contentParametry .= '<p class="desc">id aplikace provázání na fb</p>';
		$contentParametry .= $form->getElement("FACEBOOK_SECRET")->render();
		$contentParametry .= '<p class="desc">Tajný klíč</p>';
		$contentParametry .= $form->getElement("FACEBOOK_PAGE")->render();
		$contentParametry .= '<p class="desc">Stránka na FB</p>';
		$contentParametry .= '</fieldset>';
		return $contentParametry;

	}

	protected function OtherTabs()
	{
		$form = $this->form;

		$settings = G_Setting::instance();
		$contentNastaveni = '';
    		$contentNastaveni .= '<fieldset class="well">';
		$contentNastaveni .= $form->getElement("PATH_WATERMARK")->render();
		$contentNastaveni .= '<p class="desc">vodoznak do obrázků, průsvitný png nebo gif</p><br />';
		$value = $form->getElement("PATH_WATERMARK")->getValue();
		if ( !empty($value) ) { $contentNastaveni .= '<dl><label></label><dt></dt><dd><img src="/admin/watermark.php" /></dd></dl><br />'; }
		$contentNastaveni .= '<p class="desc">Změna vodoznaku v obrázcích se projeví až po smazání cache obrázků. <a href="#">Smazat cache obrázků?</a></p><br />';


		$contentNastaveni .= '<label>Pozice vodoznaku:</label>';
		$contentNastaveni .= '<table style="width:70%;">
		<tbody><tr>
		    <td><input type="radio" value="1" name="WATERMARK_POS"' . ($settings->get("WATERMARK_POS") == 1 ? ' checked="checked"' : '') . '></td>
		    <td>&nbsp;</td>
		    <td><input type="radio" value="3" name="WATERMARK_POS"' . ($settings->get("WATERMARK_POS") == 3 ? ' checked="checked"' : '') . '></td>
		</tr>
		<tr>
		    <td>&nbsp;</td>
		    <td><input type="radio" value="5" name="WATERMARK_POS"' .($settings->get("WATERMARK_POS") == 5 ? ' checked="checked"' : '') . '></td>
		    <td>&nbsp;</td>
		</tr>
		<tr>
		    <td><input type="radio" value="2" name="WATERMARK_POS"' .($settings->get("WATERMARK_POS") == 2 ? ' checked="checked"' : '') . '></td>
		    <td>&nbsp;</td>
		    <td><input type="radio" value="4" name="WATERMARK_POS"' .($settings->get("WATERMARK_POS") == 4 ? ' checked="checked"' : '') . '></td>
		    </tr>
		</tbody></table><br />';
     $contentNastaveni .= '</fieldset>';
     
     		$contentNastaveni .= '<fieldset class="well">';
        
        
        
            		$contentNastaveni .= '<div class="row">';
    		$contentNastaveni .= '<div class="col-xs-12 col-sm-4">';
		$contentNastaveni .= $form->getElement("KURZY_IMPORT_LIST")->render();
		$contentNastaveni .= '<p class="desc">Kódy měn oddělné svislicí |</p><br />';
           		$contentNastaveni .= '</div>';
              
                  		$contentNastaveni .= '<div class="col-xs-12 col-sm-4">';
		$contentNastaveni .= $form->getElement("KURZY_IMPORT_CRON")->render();
		$contentNastaveni .= '<p class="desc">Automatické stahování kurz lístku</p><br />';
           		$contentNastaveni .= '</div>';
           		$contentNastaveni .= '</div>';
              
              


        $contentNastaveni .= '</fieldset>';
        
		$contentNastaveni .= $form->getElement("THUMB_CROP")->render();
		$contentNastaveni .= $form->getElement("MENU_CATEGORY_LIST")->render();
		$contentNastaveni .= '<p class="desc"></p><br />';

		$contentNastaveni .= '<fieldset class="well">';
		$contentNastaveni .= $form->getElement("reCAPTCHA_SITE_KEY")->render();



		$contentNastaveni .= $form->getElement("reCAPTCHA_SECRET_KEY")->render();

    $contentNastaveni .= '</fieldset>';

		$contentNastaveni .= $form->getElement("MAX_WIDTH")->render();
		$contentNastaveni .= '<p class="desc"></p><br />';

		$contentNastaveni .= $form->getElement("MAX_HEIGHT")->render();
		$contentNastaveni .= '<p class="desc"></p><br />';

		$contentNastaveni .= $form->getElement("DATA_EXTENSION_WHITELIST")->render();
		$contentNastaveni .= '<p class="desc"></p><br />';

		$contentNastaveni .= $form->getElement("IMAGE_EXTENSION_WHITELIST")->render();
		$contentNastaveni .= '<p class="desc"></p><br />';

		$contentNastaveni .= $form->getElement("IS_RESPONSIVE")->render();
		$contentNastaveni .= '<p class="desc"></p><br />';


		$contentNastaveni .= $form->getElement("SLIDER_CATEGORY")->render();
		$contentNastaveni .= '<p class="desc"></p><br />';

		$contentNastaveni .= $form->getElement("SLIDER_CATEGORY_LIMIT")->render();
		$contentNastaveni .= '<p class="desc"></p><br />';

		$contentNastaveni .= $form->getElement("SERVER_POZN")->render();
		$contentNastaveni .= '<p class="desc">Vaše interní poznámky.</p><br />';


		$contentNastaveni .= '<fieldset class="well">';
		$contentNastaveni .= $form->getElement("VERSION_CATEGORY")->render();
		$contentNastaveni .= '<p class="desc">Zapnutí verzování rubrik</p>';

		$contentNastaveni .= $form->getElement("VERSION_POST")->render();
		$contentNastaveni .= '<p class="desc">Zapnutí verzování příspěvků</p>';

		$contentNastaveni .= $form->getElement("VERSION_CATALOG")->render();
		$contentNastaveni .= '<p class="desc">Zapnutí verzování katalogu</p>';

		$contentNastaveni .= $form->getElement("VERSION_PRODUCT")->render();
		$contentNastaveni .= '<p class="desc">Zapnutí verzování produktů</p>';

		$contentNastaveni .= '</fieldset>';

		$contentNastaveni .= $form->getElement("COOKIES_EU")->render();
		$contentNastaveni .= '<p class="desc"></p>';

		$contentNastaveni .= $form->getElement("IMG_TREE")->render();
		$contentNastaveni .= '<p class="desc">Ochrana proti velkému množství souborů v jednom adresáři.</p>';

	if (!empty($this->logo_file)) {
		$contentNastaveni .= '<img src="'. $this->logo_file.'"/>';
	}



	//	$contentNastaveni .= $form->page["LOGO_FILE_ID"];
		$contentNastaveni .= $form->getElement("LOGO_FILE")->render();
		$contentNastaveni .= '<p class="desc"></p>';

  $contentNastaveni .= '<script>
    $("#LOGO_FILE").on("change", function (e) {
    var file = $(this)[0].files[0];
    var upload = new Upload(file,"/admin/ajax/form.php?action=AdminLogo");

    // maby check size or type here with upload.getSize() and upload.getType()

    // execute upload
    upload.doUpload();
});
   </script>';
		return $contentNastaveni;

	}

	protected function SmsTabs()
	{
		$form = $this->form;



		$contentFaktury = '';
		$contentFaktury .= '<fieldset class="well">';
		$contentFaktury .= $form->getElement("SMSBRANA")->render();
		$contentFaktury .= '<p class="desc">SMS brána</p>';
		$contentFaktury .= $form->getElement("SMSBRANA_LOGIN")->render();
		$contentFaktury .= '<p class="desc">uživatelské jméno</p>';
		$contentFaktury .= $form->getElement("SMSBRANA_PWD")->render();
		$contentFaktury .= '<p class="desc">heslo</p>';

		$eshopSettings = G_Setting::instance();
		$this->heureka_id = $eshopSettings->get("SMSBRANA_LOGIN");

				$SmsGateController = new SmsGateController();
		if ($SmsGateController->isGateEnabled()) {



		$credit = $SmsGateController->getCreditInfo();

		$contentFaktury .= '<div class="form-group"><label class="control-label" for="SMSBRANA">Kredit</label>
		<input type="text" name="" class="textbox form-control" disabled="disabled" id="" value="' . $credit . '"></div>';

				}
		$contentFaktury .= '</fieldset>';
		return $contentFaktury;

	}


	protected function JazykyTabs()
	{
		$form = $this->form;


		$langModel = new models_Language();
		$args = new ListArgs();
		$list = $langModel->getList($args);


		$contentFaktury = '';

		$contentFaktury .= '<table>';
		for ($i=0;$i<count($list);$i++)
		{
			$disabled = "";
			if ($list[$i]->code == "cs") {
				$disabled = " disabled";
			}
			$button = ' <button type="submit"'.$disabled.' name="lang_deactive_'.$list[$i]->code.'" class="btn btn-info">Deaktivovat</button>';
			if ($list[$i]->active == 0) {
				$button = ' <button type="submit" name="lang_active_'.$list[$i]->code.'" class="btn btn-info">Aktivovat</button>';
			}
			$contentFaktury .= '<tr><td>' . $list[$i]->name . '</td><td>' . $button.  '</td></tr>';
		}
		$contentFaktury .= '</table>';

		return $contentFaktury;

	}

	protected function MailTabs()
	{
		$settings = G_Setting::instance();
		$form = $this->form;

		$contentVarianty = '';
		$contentVarianty = '<fieldset class="well">';
		$contentVarianty .= '<legend>Nastavení odchozí pošty</legend>';

		$contentVarianty .= $form->getElement("EMAIL_ORDER")->render();
		$contentVarianty .= '<p class="desc">Pod tímto účtem budou odesílány emaily.</p>';
		$contentVarianty .= $form->getElement("EMAIL_ORDER_ALIAS")->render();
		$contentVarianty .= '<p class="desc">Bude uveden vedle emailové adresy. Např.: <strong>Karel Novák</strong> (info@eshop.com)</p>';

		$contentVarianty .= $form->getElement("BCC_EMAIL")->render();
		$contentVarianty .= '<p class="desc">Skrytá kopie na email</p>';

		$contentVarianty .= '</fieldset>';

		$contentVarianty .= '<fieldset class="well">';
			$contentVarianty .= $form->getElement("EMAIL_SMTP_SEND")->render();
			$contentVarianty .= '<p class="desc">K odesílání používat SMTP server</p>';
			$contentVarianty .= $form->getElement("EMAIL_SMTP_SERVER")->render();
			$contentVarianty .= '<p class="desc">např: localhost</p>';

			$contentVarianty .= $form->getElement("EMAIL_SMTP_PORT")->render();
			$contentVarianty .= '<p class="desc">např: 465</p>';

			$contentVarianty .= $form->getElement("EMAIL_SMTP_CERT")->render();
			$contentVarianty .= '<p class="desc">např: SSL</p>';
		$contentVarianty .= '</fieldset>';



$contentVarianty .= '<fieldset class="well">';
		$contentVarianty .= $form->getElement("EMAIL_SMTP_AUTH")->render();
		$contentVarianty .= '<p class="desc">Autorizace k emailové schránce</p>';
		$contentVarianty .= $form->getElement("EMAIL_USERNAME")->render();
		$contentVarianty .= '<p class="desc"></p>';
		$contentVarianty .= $form->getElement("EMAIL_PWD")->render();
		$contentVarianty .= '<p class="desc"></p>';
$contentVarianty .= '</fieldset>';


		if ($settings->get("EMAIL_ERROR") != "") {

			if ($settings->get("EMAIL_ERROR") == "!") {
				$contentVarianty .= '<p class="alert"><strong>SMTP server není ověřen<strong> Bez něj nemůže systém odesílat emaily!</p>';
			} else {
				$contentVarianty .= '<p class="alert">SMTP server ohlásil chybu <strong>' . $settings->get("EMAIL_ERROR") . '<strong> Zkontrolujte nastavení odchozí pošty!</p>';
			}

		}

		$contentVarianty .= ' <button type="submit" name="smtp_check" class="btn btn-info">Ověřit SMTP server</button>';

		return $contentVarianty;

	}

	public function makeTabs($tabs = array()) {

		array_push($tabs, array("name" => "Main", "title" => 'Hlavní',"content" => $this->MainTabs()));
		array_push($tabs, array("name" => "tiny", "title" => 'Tiny editor',"content" => $this->TinyTabs()));
		array_push($tabs, array("name" => "soe", "title" => "SEO","content" => $this->SeoTabs()));
		array_push($tabs, array("name" => "Mail", "title" => 'Pošta',"content" => $this->MailTabs()));
		array_push($tabs, array("name" => "Sms", "title" => 'SMS',"content" => $this->SmsTabs()));
		array_push($tabs, array("name" => "Lang", "title" => "Jazyky","content" => $this->JazykyTabs()));
		array_push($tabs, array("name" => "Other", "title" => "Ostatní","content" => $this->OtherTabs()));

		return parent::makeTabs($tabs);
	}
}