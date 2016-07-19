<?php

class NewsletterTabs extends CiselnikTabs {

	protected function MainTabs()
	{


		$form = $this->form;

		//	$contentMain = parent::MainTabs();



		$contentMain = $form->getElement("name")->render() . '<p class="desc"></p><br />';
		$contentMain .= $form->getElement("description")->render() . '<p class="desc"></p><br />';


		$contentMain .= $form->getElement("html")->render() . '<p class="desc"></p><br />';

		if ($form->getElement("action") !== false) {
			$contentMain .= $form->getElement("action")->render();
		}

		return $contentMain;
	}

}

?>