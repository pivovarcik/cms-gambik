<?php
header('Content-type: text/html; charset=utf-8');

include dirname(__FILE__) . "/inc/init_spolecne.php";

$model = new GModel();

ini_set("display_errors", 1);
error_reporting(E_USER_ERROR);
error_reporting(E_ALL);

$model->zrusReferenceVse();
$model->zrusReferenceVse(dirname(__FILE__) . "/application/entity/");

$model->validTableVse();
$model->validTableVse(dirname(__FILE__) . "/application/entity/");

$model->validData();

$model->zalozReferenceVse();
$model->zalozReferenceVse(dirname(__FILE__) . "/application/entity/");

$model->insert_syscategory();

//$model->insert_category_eshop_demo();

$model->zalozView();



?>

<h2>Validace tabulek</h2>
<textarea style="width:100%;height:200px;"><?php print $model->validTableLog;?></textarea>
<h2>Zakládání vazeb</h2>
<textarea style="width:100%;height:200px;"><?php print $model->createConstraintLog;?></textarea>
<h2>Rušení vazeb</h2>
<textarea style="width:100%;height:200px;"><?php print $model->dropConstraintLog;?></textarea>