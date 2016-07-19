<?php

$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;


$params = array();
$params["odkazy"] = $cat->serial_cat_url;
$params["nazvy"] = $cat->serial_cat_title;
$params["oddelovac"] = " &#155; ";
$Breadcrumb =  getBreadcrumb($params);

define('AKT_PAGE',URL_HOME . 'add_comment');


$messageController = new CommentsController();
$messageController->createAction();
$form = new Application_Form_CommentsCreate();


$pagetitle = "Nový příspěvek";

$limit = 100;



$script = "<script type=\"text/javascript\">
<!--
function load_captcha()
{
		var a = Math.ceil(Math.random() * 10001);
    $('.captcha').attr('src','" . URL_HOME . "inc/library/image/captcha.php?rand='+a);

}
//-->
</script>";
$g->setCokolivToHeader($script);

$g->set_pagetitle($pagetitle);
$g->set_pagedescription($pagedescription);
$g->print_html_header();
include PATH_TEMP . "admin_body_header.php";
?>


<section>
<div class="wraper">
	<form class="standard_form" id="requiredfield" method="post" action="<?php print AKT_PAGE; ?>">
<?php
//print $print_result;
print $g->get_result_message2();
?>


<h1><?php echo $pagetitle; ?></h1>

	<p>Napište rychlou zprávu</p>
	<?php print $form->getElement("ins_message")->render();?>
<div class="product_tabs ui-tabs">
<?php
$select_desc = ' class="ui-tabs-selected"';
$ul_hlavni = '';
?>
	<ul class="ui-tabs-nav">
		<li<?php print $select_desc; ?>><a href="<?php print AKT_PAGE; ?>#TabDesc">Hlavní</a></li>
	</ul>
	<div class="clear"> </div>
	<div id="TabDesc" class="ui-tabs-panel<?php print $ul_hlavni; ?>">
  		<div class="container_content_labels">
			<div class="container_parameters">
				<?php print $form->getElement("category_id")->render();?>
				<p class="desc">Výstižný název článku - Povinný údaj.</p>
				<?php print $form->getElement("message")->render();?>
				<p class="desc">Výstižný název článku - Povinný údaj.</p>
				<br />
			</div>
		</div>
	</div>
</div>


</form>
</div>
</section>
<?php
include PATH_TEMP . "admin_body_footer.php";
?>