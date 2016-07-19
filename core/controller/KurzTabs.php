<?php

class KurzTabs extends CiselnikTabs {

	protected function MainTabs()
	{


		$form = $this->form;

		//	$contentMain = parent::MainTabs();

		$contentMain = $form->getElement("kod")->render() . '<p class="desc"></p><br />';
		$contentMain .= $form->getElement("name")->render() . '<p class="desc"></p><br />';
		$contentMain .= $form->getElement("kurz")->render() . '<p class="desc"></p><br />';
		$contentMain .= $form->getElement("mnozstvi")->render() . '<p class="desc"></p><br />';
		$contentMain .= $form->getElement("datum")->render() . '<p class="desc"></p><br />';
		$contentMain .= $form->getElement("description")->render() . '<p class="desc"></p><br />';

		if ($form->getElement("action") !== false) {
			$contentMain .= $form->getElement("action")->render();
		}

		return $contentMain;
	}

}

?>