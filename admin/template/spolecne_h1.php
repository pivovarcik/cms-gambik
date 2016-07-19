<?php



?>
<div class="page-header">

<h1><?php print $cat->title; ?><?php print GoBackLink(); ?></h1>

<div class="breadcrumb"><?php print $Breadcrumb; ?>
	<div class="page-help"><a href="#"><i class="fa fa-question-circle"></i></a></div>
</div>


<div class="buttons">
<?php
if (isset($pageButtons) && is_array($pageButtons)) {
	foreach ($pageButtons as $key=>$val) {

		print $val . ' ';
	}
}
?>
</div>
<?php print getResultMessage(); ?>
</div>

