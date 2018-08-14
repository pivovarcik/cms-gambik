<?php

//require_once(PATH_ROOT . "core/form/CiselnikForm.php");
require_once("PublishPostForm.php");
//abstract class NewsletterForm extends PublishPostForm
abstract class NewsletterForm extends G_Form
{
	public $formName = "Newsletter";
	public $sablona = null;
	public $page_id = null;

	public $submitButtonName = "ins_nextid";
	public $submitButtonTitle = "Odeslat";
  public $newsletterList = array();
	function __construct()
	{
		// Typ Page
		parent::__construct();
    
    $this->setStyle(BootstrapForm::getStyle());
	//	$this->init();
	}
  public function loadPage($id = NULL)
  {
  		
          // parent::loadPage($id);
      
    $model = new models_Newsletter(); 
      if ($id == null) {
        $this->sablona = $model->getDetailById(1);
		    $this->page = $this->sablona;
      
      } else {
      
          $this->sablona = $model->getDetailById($id);
          $this->page = $this->sablona;
          $this->page_id = $id;
      }



      
  }
  public function loadElements()
  {
  		
      //parent::loadElements();
      
    //  $this->getElement("title_cs")->setAttribs('label',"Předmět");
      
      
        $name = "name";
  			$elem= new G_Form_Element_Text($name);
  			
        
     //  print_r($this->page); 
        $elem->setAttribs('value',$this->getPost($name, $this->page->$name));

  			$elem->setAttribs('label',"Název newsletteru");
  			$this->addElement($elem);
        
        $name = "subject";
  			$elem= new G_Form_Element_Text($name);
  			
        
     //  print_r($this->page); 
        $elem->setAttribs('value',$this->getPost($name, $this->page->$name));

  			$elem->setAttribs('label',"Předmět emailu");
  			$this->addElement($elem);
        
        
        $name = "html";
  			$elem= new G_Form_Element_Textarea($name);
  			
        
        $value = $this->getPost($name, htmlentities($this->page->$name, ENT_COMPAT, 'UTF-8'));
        $elem->setAttribs('value',$value);
        

  			$elem->setAttribs('label',"Tělo emailu");
  			$this->addElement($elem);
        
      $modelUser = new models_Users();

			$args = new ListArgs();
			$args->limit = 10000;
			$args->page = 1;
			$args->newsletter = 1;
			$args->aktivni = 1;
			$this->newsletterList = $modelUser->getList($args);
        
        
      foreach ($this->newsletterList as $key => $val)
  		{
  
  			$name = "user_id[" . $key . "]";
  			$elem= new G_Form_Element_Checkbox($name);
  			$elem->setAttribs('value',$val->id);
  			if ($val->newsletter == 1 || $this->getPost($name, false)) {
  				$elem->setAttribs('checked','checked');
  			}
  			$elem->setAttribs('label',$val->email);
  			$this->addElement($elem);
  		}
      
      
      
      $NewsletterStatus = new models_NewsletterStatus();
        			$args = new ListArgs();
			$args->limit = 10000;
			$args->page = 1;
			$args->newsletter_id = $this->page_id;
      $this->sendNewsletterList = $NewsletterStatus->getList($args);
      
  //   print $NewsletterStatus->getLastQuery();
    /*  foreach ($this->sendNewsletterList as $key => $val)
  		{
  
  			$name = "send_user_id[" . $key . "]";
  			$elem= new G_Form_Element_Checkbox($name);
  			$elem->setAttribs('value',$val->id);
  			if ($val->newsletter == 1 || $this->getPost($name, false)) {
  				$elem->setAttribs('checked','checked');
  			}
  			$elem->setAttribs('label',$val->email);
  			$this->addElement($elem);
  		}     */
      
      
      $GAuth = G_Authentification::instance();
      
      $name = "email_test";
      $elem = new G_Form_Element_Text($name);
			$elem->setAttribs('label',"testovací email");
      $value = $this->getPost($name, $GAuth->getEmail());
      $elem->setAttribs('value',$value);
			$this->addElement($elem);
      
      
      
      
      
      
      		$elem = new G_Form_Element_Submit("send_newsletter_test");
		$elem->setAttribs(array("id"=>"upd_cat"));
		$elem->setAttribs('value','Test');
		$elem->setAttribs('class','btn btn-info');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
    
    
    
    		$elem = new G_Form_Element_Hidden("action",true);
		$elem->setAnonymous();
		$elem->setAttribs('value',str_replace("F_", "" ,get_class($this) ));
		$this->addElement($elem);

  }
	public function init()
	{
  
    
		$id = (int) $this->Request->getQuery("id",false);
		$this->loadPage($id);
		$this->loadElements();
    
    
    

		$elem = new G_Form_Element_Button("upd_post");
		$elem->setAttribs(array("id"=>"upd_post"));
		$elem->setAttribs('value','Uložit');
		$elem->setAttribs('class','btn btn-sm btn-success');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);

	}
}
