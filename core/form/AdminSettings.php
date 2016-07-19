<?php
/**
 * Společný předek pro formuláře typu Katalog
 * */
class Application_Form_AdminSettings extends G_Form
{

	public $pageModel;
	public $page;
	public $page_id;

	public $languageModel;
	public $languageList;

	public $attributes;

	function __construct()
	{
		parent::__construct();
		$this->setStyle(BootstrapForm::getStyle());
		$this->loadPage();
		//$this->loadElements();
		$this->init();
	}

	// načte datový model
	public function loadPage()
	{

		$eshop = new SettingsController();
		$this->page = $eshop->setting;
	}
	// načte datový model
	public function init()
	{

		$this->setAction($_SERVER["PHP_SELF"]);
		$this->setClass("standard_form");

		$set = $this->page;

	/*	$nextid = new models_NextId();
		$nextidOrderList = $nextid->getList(array("limit"=>1000, "tabulka"=>T_SHOP_ORDERS));
		$nextidFakturyList = $nextid->getList(array("limit"=>1000, "tabulka"=>T_FAKTURY));
		$nextidProductList = $nextid->getList(array("limit"=>1000, "tabulka"=>T_SHOP_PRODUCT));
*/



		$name = "SERVER_TITLE";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Název webu:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name = "SERVER_DESCRIPTION";
		$elem = new G_Form_Element_Textarea($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Popis webu:');
		$elem->setAttribs('class','textarea');
		$this->addElement($elem);


		$name = "SERVER_KEYWORDS";
		$elem = new G_Form_Element_Textarea($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Klíčová slova:');
		$elem->setAttribs('class','textarea');
		$this->addElement($elem);

		$name = "SERVER_CSS";
		$elem = new G_Form_Element_Textarea($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Styly:');
		$elem->setAttribs('class','textarea');
		$this->addElement($elem);

		$name = "SERVER_JS";
		$elem = new G_Form_Element_Textarea($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Javascripty:');
		$elem->setAttribs('class','textarea');
		$this->addElement($elem);


		$name = "TINY_VALID";
		$elem = new G_Form_Element_Textarea($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Validační pravidla:');
		$elem->setAttribs('class','textarea');
		$elem->setAttribs('style','height:150px;');
		$this->addElement($elem);

		$name = "TINY_CSS";
		$elem = new G_Form_Element_Textarea($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','TinyMCE styly:');
		$elem->setAttribs('class','textarea');
		$elem->setAttribs('style','height:150px;');
		$this->addElement($elem);




		$name = "google_analytics_key";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Google Analytics klíč:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);



		$name = "URL_DOMAIN";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Doména:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);


		$name = "avatar";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Avatar:');
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('style','width:100px;');
		$this->addElement($elem);

		$name = "TINY_WIDTH";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Šířka editoru:');
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('style','width:50px;text-align:right;');
		$this->addElement($elem);

		$name = "TINY_HEIGHT";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Výška editoru:');
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('style','width:50px;text-align:right;');
		$this->addElement($elem);


		$name = "PAGETITLE_PREFIX";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Prefix titulku:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);


		$name = "SERVER_FAVICON";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','favicon:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);


		$name = "TINY_PLUGINS";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Tiny Pluginy:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);


		$name = "TINY_BUTTONS1";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Buttons1:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name = "TINY_BUTTONS2";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Buttons2:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name = "TINY_BUTTONS3";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Buttons3:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);


		$name = "truncate";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Truncate text:');
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('style','width:50px;text-align:right;');
		$this->addElement($elem);



		$name = "SERVER_REFRESH";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Obnovení stránky po:');
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('style','width:50px;text-align:right;');
		$this->addElement($elem);



		$name = "MENU_ROOT_ID";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Avatar:');
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('style','width:50px;text-align:right;');
		$this->addElement($elem);


		$name = "limit";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Počet záznamů na stránku:');
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('style','width:100px;');
		$this->addElement($elem);

		$name = "SERVER_ROBOTS";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Indexace stránek (robots):');
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('style','width:100px;');
		$this->addElement($elem);


		$name = "SERVER_GOOGLEBOT";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Indexace stránek (goglebot):');
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('style','width:100px;');
		$this->addElement($elem);


		$name = "SERVER_AUTHOR";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Autor:');
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('style','width:250px;');
		$this->addElement($elem);


		$name = "FACEBOOK_API_ID";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Facebook Apps ID:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);


		$name = "FACEBOOK_SECRET";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Facebook tajný klíč:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name = "FACEBOOK_PAGE";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Domovská stránka na FB:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);


		$name = "PATH_WATERMARK";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Vodoznak v obrázcích:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name = "SERVER_POZN";
		$elem = new G_Form_Element_Textarea($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Interní poznámka:');
		$elem->setAttribs('class','textarea');
		$elem->setAttribs('style','height:150px;');
		$this->addElement($elem);











		$name = "BCC_EMAIL";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Skrytá kopie objednávky:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);



		$name = "EMAIL_SMTP_SERVER";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','SMTP server:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);



		$name = "EMAIL_SMTP_PORT";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','SMTP port:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);



		$name = "EMAIL_SMTP_CERT";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','SMTP zabezpečení:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);


		$name = "EMAIL_ORDER";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Emailová adresa:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name = "EMAIL_ORDER_ALIAS";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Alias odesílatele:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);


		$elem = new G_Form_Element_Checkbox("EMAIL_SMTP_AUTH");
		$elem->setAttribs(array("id"=>"EMAIL_SMTP_AUTH"));
		$value = $this->getPost("EMAIL_SMTP_AUTH", $set["EMAIL_SMTP_AUTH"]);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}


		//$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Vyžadování autorizace:');
		//$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name = "EMAIL_SMTP_SEND";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}


		//$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Použít SMTP:');
		//$elem->setAttribs('class','textbox');
		$this->addElement($elem);


		$name = "EMAIL_USERNAME";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Uživ. jméno:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);


		$name = "EMAIL_PWD";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Heslo:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);



		$name = "SMSBRANA";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','SMS brána:');
		$elem->setAttribs('disabled','disabled');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name = "SMSBRANA_LOGIN";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Přihlašovací jméno:');
	//	$elem->setAttribs('disabled','disabled');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);


		$name = "SMSBRANA_PWD";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Přihlašovací heslo:');
		//	$elem->setAttribs('disabled','disabled');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name = "KURZY_IMPORT_LIST";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Měny k natažení:');
		//	$elem->setAttribs('disabled','disabled');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);





		$name = "KURZY_IMPORT_CRON";
		$elem = new G_Form_Element_Select($name);

		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);

		$elem->setAttribs('value',trim($value));
		$elem->setAttribs('label','Doba pro stahování kurz.lístku:');
		$pole = array();

		$attrib = array();

		for ($i=0;$i<24;$i++)
		{

			if ($i<10) {
				$label = "0".$i.":00";
			}else {
				$label = $i.":00";
			}
			$pole[$i] = $label;
		}
		$pole[99] = "Nenastaveno";

		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);


		$name="MENU_CATEGORY_LIST";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('is_numeic',true);
		$elem->setAttribs('label','Hlavní menu:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);


		$name="reCAPTCHA_SITE_KEY";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','reCAPTCHA site key:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name="reCAPTCHA_SECRET_KEY";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','reCAPTCHA secret key:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);


		$name="FOOTER_JS";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('label','Umístit JS na konec:');
		$this->addElement($elem);


		$name="IS_RESPONSIVE";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('label','Responzivní web:');
		$this->addElement($elem);

		$name="VERSION_CATEGORY";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('label','Verzování rubrik');
		$this->addElement($elem);

		$name="VERSION_POST";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('label','Verzování rubrik');
		$this->addElement($elem);



		$name="VERSION_CATALOG";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('label','Verzování rubrik');
		$this->addElement($elem);

		$name="VERSION_PRODUCT";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('label','Verzování rubrik');
		$this->addElement($elem);

		$name = "MAX_WIDTH";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Max. šířka obrázku:');
		$elem->setAttribs('style','width:100px;');
		$this->addElement($elem);

		$name = "MAX_HEIGHT";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Max. výška obrázku:');
		$elem->setAttribs('style','width:100px;');
		$this->addElement($elem);

		$name = "DATA_EXTENSION_WHITELIST";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Povolené typy souborů:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name = "IMAGE_EXTENSION_WHITELIST";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Povolené typy obrázků:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name = "SLIDER_CATEGORY";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Slider kategorie ID:');
//		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name = "SLIDER_CATEGORY_LIMIT";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Max. počet článků slideru:');
//		$elem->setAttribs('class','textbox');
		$this->addElement($elem);


		$name = "COOKIES_EU";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('label','Vyžadovat souhlas uživatele s využíváním Cookies');

		$this->addElement($elem);



		$name = "LOGO_FILE";
		$elem = new G_Form_Element_File($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Nahrát logo');

		$this->addElement($elem);



		$name = "LICENCE_KEY";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Licenční číslo CMS Gambik');
		//		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$elem = new G_Form_Element_Button("upd-setting-eshop");
		$elem->setAttribs(array("id"=>"upd-setting-eshop"));
		$elem->setAttribs('value','Ulož');
		$elem->setAttribs('class','tlac');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}
}