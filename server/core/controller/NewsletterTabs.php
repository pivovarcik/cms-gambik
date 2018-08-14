<?php

class NewsletterTabs extends G_Tabs {


  public $form;
	public function __construct($form)
	{
		parent::__construct();


    $translator = G_Translator::instance();


		$this->form = $form;




	//	$tab = array("name" => "Param", "title" => "Parametry","content" => $this->ParametryTab() );
	//	$this->addTab($tab,true);

    $newsletterList = $this->form->newsletterList;
    //$files = $this->product->files;


    		$tab = array("name" => "Main2", "title" => "Náhled zprávy","content" => $this->MainTabs() );
    		$this->addTab($tab);
        
     		$tab = array("name" => "Test", "title" => "Zkusmo","content" => $this->ZkusmoTab() );
    		$this->addTab($tab);
    
    if (count($newsletterList)>0)
    {
    		$tab = array("name" => "Users", "title" => "Příjemci (" . count($newsletterList) . ")","content" => $this->UserTab() );
    		$this->addTab($tab);
    }

    

      
      





	}
  protected function ZkusmoTab()
	{
  
  
     $contentMain="";
   		$form = $this->form;

		$contentMain = $form->getElement("email_test")->render() . '<p class="desc"></p><br />';
		$contentMain .= $form->getElement("send_newsletter_test")->render() . '';
      return   $contentMain;
  }  
  protected function UserTab()
	{
  	$form = $this->form;
    $contentMain = "";
    $contentMain .= '<fieldset class="well">';
    $contentMain .= '<h2 class="control-label" for="">Odběratelé newsletteru (' . count($this->form->newsletterList) . ')</h2>';
		$contentMain .= '<div class="checkbox-group service-box">';
		$categoryA = $form->getElement("user_id[]");

		foreach ($categoryA as $key => $val)
		{
			$contentMain .= '<span id="sort_primary_sluzba_' .  $val->getValue(). '">' . $val->render()  . '</span>';
			//	$contentMain .= '<p class="desc"></p><br />';
		}
		$contentMain .= '<div class="clearfix"></div></div>';
    $contentMain .= '</fieldset>';
    
    
    $contentMain .= '<fieldset class="well">';
    $contentMain .= '<h2 class="control-label" for="">Odesláno (' . count($this->form->sendNewsletterList) . ')</h2>';
		$contentMain .= '<div class="">';
    
    
    foreach ($this->form->sendNewsletterList as $key => $val)
		{
       $contentMain .= '<div>' .  $val->email. ' ' . $val->TimeStamp  . '</div>';
    }

		$contentMain .= '</div>';
    $contentMain .= '</fieldset>';
    
    
    return   $contentMain;
  }
	protected function MainTabs()
	{
  		$form = $this->form;

    $property = array();
	/*	$property["NEWS_LINK"] = $form->page->link;
		$property["NEWS_LINK_ODHLASENI"] = URL_HOME . "odhlaseni-newsletter";
		$property["NEWS_EMAIL_ODBERATEL"] = "ruda@email.cz";
		$property["NEWS_EMAIL_JMENO"] = "Rudo";
		$property["NEWS_EMAIL_HASH"] = "xxxxxx";
    */
    
           $GAuth = G_Authentification::instance();


                          		$property = array();
  		$property["NEWS_LINK"] = $form->page->link;
  		$property["NEWS_LINK_ODHLASENI"] = URL_HOME . "odhlaseni-newsletter";
  		$property["NEWS_EMAIL_ODBERATEL"] = $GAuth->getEmail();
  		$property["NEWS_EMAIL_JMENO"] = $GAuth->getJmeno();
      $property["NEWS_EMAIL_PRIJMENI"] = $GAuth->getPrijmeni();
      $property["NEWS_EMAIL_HASH"] = "xxxxxx";
      
      
      $property["NEWS_LINK_ODHLASENI"] = URL_HOME_SITE . "odhlaseni-newsletter?email=" . $property["NEWS_EMAIL_ODBERATEL"]. "&v=" . $property["NEWS_EMAIL_HASH"];
      $property["NEWS_LINK_GDPR"] = URL_HOME_SITE . "gdpr?m=" . $property["NEWS_EMAIL_ODBERATEL"]. "&hash=" . $property["NEWS_EMAIL_HASH"];


		//	$contentMain = parent::MainTabs();
     $contentMain="";

     // print_r($form->sablona);
		$contentMain = $form->getElement("name")->render() . '<p class="desc"></p><br />';
    
		$contentMain .= $form->getElement("subject")->render() . '<p class="desc"></p><br />';
		$contentMain .= $form->getElement("html")->render() . '<p class="desc"></p><br />';
		
    
    
    $contentMain .= '<fieldset class="well">';
    $contentMain .= '<h2 class="">';
      $contentMain .= propertyToText($form->sablona->subject, $property);
     $contentMain .= '</h2>';
     
    $contentMain .= '<div class="desc" style="overflow:scroll;">';
   // $contentMain .= $form->sablona->html;
    $contentMain .= propertyToText($form->sablona->html, $property);
   // $contentMain .= $form->page->description;
  //  $contentMain .= $form->sablona->html_footer;
   // $contentMain .= $form->sablona->html_footer;
    $contentMain .= propertyToText($form->sablona->html_footer, $property);
    
    $contentMain .= '</div>';
    $contentMain .= '</fieldset>';
    $contentMain .= '<fieldset>';
    $contentMain .= '<div>{NEWS_EMAIL_ODBERATEL} = registrační email odběratele</div>';
    $contentMain .= '<div>{NEWS_EMAIL_JMENO} = jméno odběratele</div>';
    $contentMain .= '<div>{NEWS_EMAIL_PRIJMENI} = příjmení odběratele</div>';
    $contentMain .= '<div>{NEWS_LINK_ODHLASENI} = Url adresa pro odhlášení z odběru</div>';
    $contentMain .= '<div>{NEWS_LINK_GDPR} = Url adresa pro souhlas GDPR</div>';
    $contentMain .= '</fieldset>';

	//	$contentMain .= $form->getElement("html")->render() . '<p class="desc"></p><br />';

		if ($form->getElement("action") !== false) {
			$contentMain .= $form->getElement("action")->render();
		}


      return   $contentMain;
	}

}