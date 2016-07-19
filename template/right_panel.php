<aside>
	<div id="right-panel" class="<?php print $G_HtmlPage->getRightPanelClass(); ?>">

<?php
if ($eshopSettings->get("SEARCH_BOX_POS") == "RIGHT")
{
	include "SearchBox.php";
}
?>

<?php
if ($eshopSettings->get("ESHOP_MENU_POS") == "RIGHT")
{
	include "ProductsNav.php";
}
?>

<?php
if ($eshopSettings->get("PRODUCT_AKCE_POS") == "RIGHT")
{
	include "AkceProductList.php";
}
?>

<?php
if ($eshopSettings->get("PRODUCT_HISTORY_POS") == "RIGHT")
{
	include "HistoryProductList.php";
}
?>

	</div>
</aside>