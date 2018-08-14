<?php

/**
 * Funkce obrátí pořadí pole
 * @return array;
 */

function tree_menu($pole, $id, $vnoreni, $element_id="", $changeLevel = "category", $url = 'admin/cat.php'){


	if (count($pole)) {

	}
	$tree_menu = '<ul'.$element_id.'>';

//	print_r($pole);
	for ($i=0;$i<count($pole);$i++)
	{
		if ($pole[$i]->category_id == $id) {


			$level = ($pole[$i]->level > 0) ? "+".$pole[$i]->level : $pole[$i]->level;
			$tree_menu .= '<li>';
			$tree_menu .= '<a title="'.$pole[$i]->title.'" class="'.$pole[$i]->vnoreni.'" href="'.URL_HOME.$url .'?id='.$pole[$i]->id.'">'.$pole[$i]->title.'</a>';
 if ($changeLevel)
 {
 	$tree_menu .= ' <a class="arrow_up" href="javascript:changePageLevel('.$pole[$i]->id.',\'up\',\'' . $changeLevel .'\')"><span>up</span></a> <a class="arrow_down" href="javascript:changePageLevel('.$pole[$i]->id.',\'down\',\'' . $changeLevel .'\')"><span>down</span></a><span>'.$level.'</span>';

 }
			//if ($pole[$i]->vnoreni <> $vnoreni) {
			$tree_menu .= tree_menu($pole,$pole[$i]->id,$pole[$i]->vnoreni,"",$changeLevel,$url);
			//}

			$tree_menu .= '</li>';
		}
	}

	$tree_menu .='</ul>';

	$tree_menu = str_replace('<ul></ul>', '', $tree_menu);
	return $tree_menu;
}