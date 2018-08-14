<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2012
 */

/**
 *
 *
 */


class ImportProductSettingTabs extends CiselnikTabs {


	public function __construct($pageForm)
	{

		$this->form = $pageForm;
	}

	protected function MainTabs()
	{


		$form = $this->form;

		//	print_r($form);
		$contentMain = parent::MainTabs();

		//	print "tudy";

		$contentMain .= $form->getElement("url")->render() . '<p class="desc"></p><br />';
		$contentMain .= '<div class="row">';
		$contentMain .= '<div class="col-xs-3">';
		$contentMain .= $form->getElement("deactive_product")->render() . '<p class="desc">Produkty v databázi před natažením deaktivovat?</p>';
		$contentMain .= '</div>';
		$contentMain .= '<div class="col-xs-3">';
		$contentMain .= $form->getElement("import_product_is_active")->render() . '<p class="desc">Importované produkty označit jako aktivní?.</p>';
		$contentMain .= '</div>';
		$contentMain .= '<div class="col-xs-3">';
		$contentMain .= $form->getElement("import_images")->render() . '<p class="desc"></p>';
		$contentMain .= '</div>';

    		$contentMain .= '<div class="col-xs-3">';
		$contentMain .= $form->getElement("create_category")->render() . '<p class="desc"></p>';
		$contentMain .= '</div>';
    
		$contentMain .= '</div>';


		$contentMain .= '<div class="row">';
		$contentMain .= '<div class="col-xs-4">';
		$contentMain .= $form->getElement("import_reference")->render() . '<p class="desc"></p>';
		$contentMain .= '</div>';
		$contentMain .= '<div class="col-xs-4">';
		$contentMain .= $form->getElement("shop_items")->render() . '<p class="desc"></p>';
		$contentMain .= '</div>';
		$contentMain .= '<div class="col-xs-4">';

		$contentMain .= '</div>';

		$contentMain .= '</div>';

		$contentMain .= '<div class="row">';
		$contentMain .= '<div class="col-xs-4">';
		$contentMain .= $form->getElement("nextid_product")->render() . '<p class="desc"></p>';
		$contentMain .= '</div>';
		$contentMain .= '<div class="col-xs-4">';
		$contentMain .= $form->getElement("block_size")->render() . '<p class="desc"></p>';
		$contentMain .= '</div>';
		$contentMain .= '<div class="col-xs-4">';
		$contentMain .= $form->getElement("cron_hodina")->render() . '<p class="desc"></p>';
		$contentMain .= '</div>';

		$contentMain .= '</div>';



		$contentMain .= '<div class="row">';
		$contentMain .= '<div class="col-xs-4">';
		$contentMain .= $form->getElement("sync_price")->render() . '<p class="desc"></p>';
		$contentMain .= '</div>';
		$contentMain .= '<div class="col-xs-4">';
		$contentMain .= $form->getElement("sync_stav")->render() . '<p class="desc"></p>';
		$contentMain .= '</div>';
		$contentMain .= '<div class="col-xs-4">';
		$contentMain .= $form->getElement("sync_aktivni")->render() . '<p class="desc"></p>';
		$contentMain .= '</div>';

		$contentMain .= '</div>';



		$contentMain .= '<div class="row">';
		$contentMain .= '<div class="col-xs-4">';
		$contentMain .= $form->page->syncLastId;
		$contentMain .= '</div>';
		$contentMain .= '<div class="col-xs-4">';
		$contentMain .= date("j.n.Y H:i", strtotime($form->page->syncLastTimeStamp));
		$contentMain .= '</div>';
		$contentMain .= '<div class="col-xs-4">';

		$contentMain .= '</div>';

		$contentMain .= '</div>';



    
    
	//	$contentMain .= '<a href="' . URL_HOME_SITE . 'import/' . $form->getElement("name")->getValue() . '/index.php" target="_blank" class="btn btn-primary">Spustit ručně import</a> ';
		$contentMain .= '<button type="button" onclick="importRun();" target="_blank" class="btn btn-primary">Spustit ručně import</button> ';
    
    $contentMain .= '<a href="' . URL_HOME_SITE . 'import/' . $form->getElement("name")->getValue() . '/' . $form->page->syncLastId . '.xml" target="_blank" class="btn btn-info">Zobrazit xml Feed ' . $form->page->syncLastId . '</a> ';
    
		$contentMain .= '<a href="' . URL_HOME_SITE . 'import/' . $form->getElement("name")->getValue() . '/log/import.log" target="_blank" class="btn btn-info">Zobrazit LOG importu</a>';
		$filename = PATH_ROOT. 'import/' . $form->getElement("name")->getValue() . '/log/manager.log';
    $file = file_get_contents($filename);
    $contentMain .= ' Manažer LOG: <strong id="log-manager">' . $file . '</strong>';

    		$filename = PATH_ROOT. 'import/' . $form->getElement("name")->getValue() . '/log/iterator.log';
    $file = file_get_contents($filename);
    
    $contentMain .= ' Itearátor LOG: <strong id="log-iterator">' . $file . '</strong>';
    $contentMain .= '<script>';
    $contentMain .= '
       /*   setInterval(function(){
   $("#log-count").load("' . '/import/' . $form->getElement("name")->getValue() . '/log/iterator.log");
    },1000);   */
    
    var importRun = function()
    {
      loadIteratorLog();  
      var jqxhr = $.ajax( "' . URL_HOME_SITE . 'import/' . $form->getElement("name")->getValue() . '/index.php?chain=1" )
      .done(function() {
       // alert( "success" );
      })
      .fail(function() {
        alert( "error" );
      })
      .always(function() {
       // alert( "complete" );
      });
    
    }
    var timerX = setTimeout(function(){ loadIteratorLog(); }, 1000);
    var loadIteratorLog = function(){
        
        clearTimeout(timerX);
        var rand = Math.random();
        $("#log-manager").load("' . '/import/' . $form->getElement("name")->getValue() . '/log/manager.log?"+rand);
        $("#log-iterator").load("' . '/import/' . $form->getElement("name")->getValue() . '/log/iterator.log?"+rand);
        
        
        console.log($("#log-count").length + ":" + $("#log-manager").text() );  
        console.log($("#log-manager").text() == "start" );
        if ($("#myModal").is(":visible") && $("#log-manager").text() == "start")
        {
           timerX = setTimeout(function(){ loadIteratorLog(); }, 1000);
        }
        
    };  
    
    ';
    $contentMain .= '</script>';
    
		return $contentMain;
	}


	public function makeTabs($tabs = array()) {
		//	array_push($tabs, array("name" => "Main", "title" => 'Hlavní',"content" => $this->MainTabs()));
		return parent::makeTabs($tabs);
	}

}