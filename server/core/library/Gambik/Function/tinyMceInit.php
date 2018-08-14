<?php
//menubar : edit tools table format view insert
//toolbar1: "undo redo |  bold italic underline strikethrough subscript superscript removeformat | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent  | table | fontsize formatselect fontsizeselect styleselect | link image media inserttime | forecolor backcolor hilitecolor | blockquote hr charmap | code",
function tinyMceInit($params = array())
{
	//document_base_url: "'.URL_HOME_SITE.'",

   $settings = G_Setting::instance();

	$res ='<script  type="text/javascript">tinymce.init({
			selector: "textarea.mceEditor",
			document_base_url: "'.URL_HOME_SITE.'",
	convert_urls: false,
			language : "cs",
			plugins: [
			"advlist autolink lists link image charmap anchor",
			"searchreplace visualblocks code fullscreen",
			"insertdatetime media table contextmenu paste"
			],';

	$menubar = "";
	if (isset($params["menubar"]) && !empty($params["menubar"])) {
		$menubar = $params["menubar"];
	}

	$res .= 'menubar: "'.$menubar.'",' . PHP_EOL;

	$toolbar1 = "undo redo |  bold italic underline strikethrough subscript superscript removeformat | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent  | table | fontsize formatselect fontsizeselect styleselect | link image media inserttime | forecolor backcolor hilitecolor | blockquote hr charmap | code";
	if (isset($params["toolbar1"]) && !empty($params["toolbar1"])) {
		$toolbar1 = $params["toolbar1"];
	}
	$res .= 'toolbar1: "'.$toolbar1.'",' . PHP_EOL;


	$valid = isset($params["valid"]) ? $params["valid"] : "*[*]";

	//	{title: \'Žádné\', value: \'\'},
	$res .='valid_elements : "' . $valid . '",' . PHP_EOL;
	$res .='image_class_list: [
		{title: \'Žádné\', value: \'\'},
		{title: \'Obtékání textu zleva\', value: \'zleva\'},
		{title: \'Obtékání textu zprava\', value: \'zprava\'}
		],';
    
    
  $tinyClass = $settings->get("TINY_A_CLASS");
  
  
  //"Lightbox,lightbox|Button,button";  
  
  $tinyClassA = explode("|",$tinyClass);
  
  
 // print_r($tinyClassA);
  	$res .='link_class_list: [
	{title: \'Žádné\', value: \'\'}';
  foreach ($tinyClassA as $cl)
  {
    $clA = explode(",",$cl);
    
    if (count($clA)==2)
    {
      $title =  $clA[0];
      $value =  $clA[1];      
    } else {
      $title =  $clA[0];
      $value =  $clA[0];
    }
    
  	$res .=",{title: '" . $title . "', value: '" . $value . "'}";  
  }
  
  	$res .='],';
    
   /* 
	$res .='link_class_list: [
	{title: \'Žádné\', value: \'\'},
		{title: \'Lightbox\', value: \'lightbox\'}
		],'; */
	$res .='table_class_list: [
	{title: \'Žádné\', value: \'\'},
		{title: \'Na celou stránku\', value: \'full-width\'}
		],';


	// kvuli newsletterum !!
	$res .='relative_urls : true,' . PHP_EOL;
	$res .='remove_script_host : false,' . PHP_EOL;
	//	$res .='convert_urls : true,' . PHP_EOL;

	//$res .='relative_urls : "false",' . PHP_EOL;
	$res .='formats : {' . PHP_EOL;
	$res .='alignleft   : {selector : \'div,p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img\', classes : \'text-left\'},' . PHP_EOL;
	$res .='alignright  : {selector : \'div,p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img\', classes : \'text-right\'},' . PHP_EOL;
	$res .='alignfull   : {selector : \'div,p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img\', classes : \'text-full\'},' . PHP_EOL;
	$res .='aligncenter   : {selector : \'div,p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img\', classes : \'text-center\'}' . PHP_EOL;
	$res .='},' . PHP_EOL;
	// . rand() .
	//$css = isset($params["css"]) ? $params["css"] : URL_HOME2 . "admin/style/editor.css";
	$css = isset($params["css"]) ? $params["css"] : URL_HOME2 . "admin/editor_css.php?";
	$res .='content_css : "' . $css . '" + new Date().getTime(),' . PHP_EOL;

	$res .='entity_encoding : "raw",' . PHP_EOL;

	$width = isset($params["width"]) ? $params["width"] : "670";
	$res .='width : "' . $width . '",' . PHP_EOL;

	$height = isset($params["height"]) ? $params["height"] : "800";
	$res .='height : "' . $height . '"' . PHP_EOL;



	$res .=',paste_as_text: true,
	paste_auto_cleanup_on_paste : true,
	        paste_remove_spans: true,
	        paste_remove_styles: true,
	        paste_retain_style_properties: false,';


	$res .='});</script>' . PHP_EOL;
	return $res;


}
