<?php

class G_HtmlPage {


	private $slimLeftPanel = false;
	private $slimRightPane = false;
	private $rightPanel = false;
	private $leftPanel = false;
	private $pageType = null;
	private $topMenu = false;
	private $leftMenu = false;


	public function __construct($pageType)
	{
		$eshopSettings = G_EshopSetting::instance();
		$this->pageType = $pageType;
		switch ($this->pageType) {
			case "main":
				if ($eshopSettings->get("LEFT_PANEL_ON") == "1"){
					$this->leftPanel= true;
					if ($eshopSettings->get("LEFT_PANEL_SLIM") == "1"){
						$this->slimLeftPanel = true;
					}

				}
				if ($eshopSettings->get("RIGHT_PANEL_ON") == "1"){
					$this->rightPanel= true;
					if ($eshopSettings->get("RIGHT_PANEL_SLIM") == "1"){
						$this->slimRightPanel = true;
					}

				}
				if ($eshopSettings->get("ESHOP_MENU_MAIN_POS") == "TOP"){
					$this->topMenu = true;
				}

				if ($eshopSettings->get("ESHOP_MENU_MAIN_POS") == "LEFT"){
					$this->leftMenu = true;
				}

				break;
			case "shop":
				if ($eshopSettings->get("SHOP_LEFT_PANEL_ON") == "1"){
					$this->leftPanel= true;
					if ($eshopSettings->get("SHOP_LEFT_PANEL_SLIM") == "1"){
						$this->slimLeftPanel = true;
					}

				}
				if ($eshopSettings->get("SHOP_RIGHT_PANEL_ON") == "1"){
					$this->rightPanel= true;
					if ($eshopSettings->get("SHOP_RIGHT_PANEL_SLIM") == "1"){
						$this->slimRightPanel = true;
					}

				}
				if ($eshopSettings->get("ESHOP_MENU_POS") == "TOP"){
					$this->topMenu = true;
				}


				if ($eshopSettings->get("ESHOP_MENU_POS") == "LEFT"){
					$this->leftMenu = true;
				}

				break;
			default:
				if ($eshopSettings->get("LEFT_PANEL_ON") == "1"){
					$this->leftPanel= true;
					if ($eshopSettings->get("LEFT_PANEL_SLIM") == "1"){
						$this->slimLeftPanel = true;
					}

				}
				if ($eshopSettings->get("RIGHT_PANEL_ON") == "1"){
					$this->rightPanel= true;
					if ($eshopSettings->get("RIGHT_PANEL_SLIM") == "1"){
						$this->slimRightPanel = true;
					}

				}
		} // switch


		if ($this->isLeftPanel() && $this->isRightPanel()){
			// pokud jsou oba panely zapnuté, jsou automaticky slim
			$this->slimLeftPanel = true;
			$this->slimRightPanel = true;
		}
	}


	public function isTopMenu()
	{
		return $this->topMenu;
	}
	public function isLeftPanel()
	{
		return $this->leftPanel;
	}

	public function isLeftPanelMenu()
	{
		return $this->leftMenu;
		//print "leftmenu";
		//if ($this->leftMenu) {
		//	include PATH_TEMPLE . "ProductsNav.php";
	//	}
	}
	public function isRightPanel()
	{
		return $this->rightPanel;
	}

	public function getLeftPanelClass()
	{
		$pageClass = '';
		if ($this->isLeftPanel()){

			$pageClass = ' col-xs-12 col-md-3';
			if ($this->slimLeftPanel){
				$pageClass = ' col-xs-12 col-md-15';
			}
		}
		return $pageClass;
	}

	public function getRightPanelClass()
	{
		$pageClass = '';
		if ($this->isRightPanel()){

			$pageClass = ' col-xs-12 col-md-3';
			if ($this->slimRightPanel){
				$pageClass = ' col-xs-12 col-md-15';
			}
		}
		return $pageClass;
	}

	public function getContentClass()
	{
		$pageClass = '';


		if ($this->isLeftPanel()){

			$pageClass = ' col-xs-12 col-sm-9';
			if ($this->slimLeftPanel){
				$pageClass = ' col-xs-12 col-xs-13';
			}
		}

		if ($this->isRightPanel()){

			$pageClass = ' col-xs-12 col-sm-9';
			if ($this->slimRightPanel){
				$pageClass = ' col-xs-12 col-xs-13';
			}
		}

		if ($this->isLeftPanel() && $this->isRightPanel()){
			$pageClass = ' col-xs-12 col-sm-7';
		}

		return $pageClass;
	}
}

?>