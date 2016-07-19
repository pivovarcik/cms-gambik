<?php
session_start();
header("Content-type: text/html; charset=utf-8");
header("Cache-Control: no-cache");
header("Pragma: nocache");
define('PATH_ROOT2', dirname(__FILE__));


require_once PATH_ROOT2.'/../inc/init_spolecne.php';
$productController = new ProductController();
$filter = new Application_Form_ProductsListFilter();
$params =array();
$limit = isset($_GET["lim"]) ? $_GET["lim"] : 20;
$tree = isset($_GET["t"]) ? $_GET["t"] : false;

$params["limit"] = $limit;
$params["aktivni"] = 1;
if (isset($_GET["motorcar"])) {
	$umisteni = $_GET["motorcar"];
}
//Pro pneu
/**/
	$params["child"] = $tree;


	$l = $productController->productList($params);
//print_R($l);
$page = isset($_GET["pg"]) ? $_GET["pg"] : 1;
$pager = new G_Paginator($page, $productController->total, $limit);
$output_product = $pager->render();
//print "tudy";
if (count($l)>0)
{
	$imageController = new ImageController();
	//print $output_product;
	?>
<form method="get" action="">
	<table class="filter" cellspacing="0">
	<tr>
	<td><label>řadit dle:</label>
	<?php
	print $filter->getElement("order")->render();
	?>
		<?php
		print $filter->getElement("sort")->render();
		?>
	</td>
	<td align="right"><label>položek:</label>
	<?php
	print $filter->getElement("limit")->render();
	?>
	</td>
	</tr>
	</table>
</form>
<div class="items_box">
<?php
$sudy = false;

for($i=0;$i<count($l);$i++)
{

if ($sudy)
{
	$classProSudy = ' class="sudy"';
	$sudy = false;
} else
{
	$classProSudy = ' class="lichy"';
	$sudy = true;
}
	$product_url = $l[$i]->link;
//$product_url = URL_HOME . 'product/?id=' . $l[$i]->klic_ma;
//$product_url = URL_HOME . $g->get_categorytourl($l[$i]->serial_cat_url) . $l[$i]->klic_ma .'-' . $g->url_friendly($l[$i]->nazev_mat) . '.html';
if (!empty($l[$i]->file)) {
	$PreviewUrl = '<img alt="" title="" src="' . $imageController->get_thumb($l[$i]->file,93,78) . '" class="imgobal">';
} else {
	$PreviewUrl = '<div style="width:93px;height:78px;"> Bez náhledu</div>';
}

?>

<div class="item">
	<div class="item_in">
		<h3 class="product_name"><a href="<?php print $l[$i]->link; ?>"><?php print $l[$i]->title; ?></a></h3>
		<div class="product_info">
			<div class="product_image">
				<a href="<?php print $product_url; ?>"><?php print $PreviewUrl; ?></a>
			</div>

			<div class="product_in">
				<div class="price"><?php print number_format($l[$i]->prodcena, 0, ',', ' '). '&nbsp;Kč'; ?></div>

						<div class="product_text">
					<strong class="skladovka dostupnost"><span class="t"><?php print$l[$i]->dostupnost; ?></span></strong>
					</div>

				<form method="post" action="">

					<div class="product_buy">
						<input type="hidden" class="product_id" name="product_id" value="<?php print $l[$i]->page_id; ?>" />
						<input id="qty" type="text" alt="pocetkusu" class="qty" value="<?php print round($l[$i]->qty,0); ?>" name="qty" autocomplete="off">&nbsp;<?php print $l[$i]->nazev_mj; ?>
						<a title="<?php print $l[$i]->title; ?>" class="buy" href="#"><span><?php print $translator->prelozitFrazy("detail"); ?></span></a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
	<?php
}
?>
<div class="clearfix"><!-- IE --></div>

	<?php print $output_product; ?>
</div>

<?php

}

/////////////////////////////////////////////////
?>
