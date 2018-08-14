<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class G_Controller_Action
{
	public $translator;
	function __construct()
	{
		$this->getRequest = new G_Html();


		//$this->user = new Users();
	}

	public function afterLoad()
	{
		$this->translator = G_Translator::instance();
	}
	public function formLoad($form)
	{
		$form = (string) $form;
		$formName = 'F_' . ucfirst($form);
		$class = new $formName();
		return $class;
	}

	public function orderFromQuery($querys, $default, $order = 'order', $sort = 'sort')
	{

		$result = "";
		foreach ($querys as $key => $value){
			if ($value['url'] == $this->getRequest->getQuery($order, '')) {

				$sort_default = isset($value[$sort]) ? $value[$sort] : '';
				if ($this->getRequest->getQuery($sort, $sort_default) == 'desc') {
					$sort = 'desc';
				} else {
					$sort = 'asc';
				}


				 $result = $value['sql'] . " " . $sort;
			}
		}
		if (empty($result) && !empty($default)) {
			$result = $default;
		}
		return $result;
	}





}