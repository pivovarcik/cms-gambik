<?php

function vsort($array, $id="id", $sort_ascending=true, $is_object_array = true) {

	//print_r($array);
	$temp_array = array();
	while(count($array)>0) {
		$lowest_id = 0;
		$index=0;
		if($is_object_array){
			foreach ($array as $item) {
				if (isset($item->$id)) {
					if ($array[$lowest_id]->$id) {
						if ($item->$id<$array[$lowest_id]->$id) {
							$lowest_id = $index;
						}
					}
				}
				$index++;
			}
		}else{
			foreach ($array as $item) {
				if (isset($item[$id])) {
					if ($array[$lowest_id][$id]) {
						if ($item[$id]<$array[$lowest_id][$id]) {
							$lowest_id = $index;
						}
					}
				}
				$index++;
			}
		}
		$temp_array[] = $array[$lowest_id];
		$array = array_merge(array_slice($array, 0,$lowest_id), array_slice($array, $lowest_id+1));
	}
	if ($sort_ascending) {

		//print_R($temp_array);
		return $temp_array;
	} else {
		return array_reverse($temp_array);
	}
}