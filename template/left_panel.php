<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

?>

<aside id="left-panel" class="<?php print $G_HtmlPage->getLeftPanelClass(); ?>">
	<div id="left-panel-in">


<?php
if ($eshopSettings->get("SEARCH_BOX_POS") == "LEFT")
{
	include "SearchBox.php";
}
?>

<?php
if ($eshopSettings->get("ESHOP_MENU_POS") == "LEFT")
{
	include "ProductsNav.php";
}
?>



<div id="kontakt_box">
	<div class="title">Kontakt</div>
	<div class="company_name"><?php print $eshopSettings->get("COMPANY_NAME"); ?></div>
	<div class="company_adr"><?php print $eshopSettings->get("ADDRESS1"); ?></div>
	<div class="company_city"><?php print $eshopSettings->get("ZIP_CODE"); ?> <?php print $eshopSettings->get("CITY"); ?></div>

	<div class="company_email"><a href="mailto:<?php print $eshopSettings->get("KONTAKT_EMAIL"); ?>"><?php print $eshopSettings->get("KONTAKT_EMAIL"); ?></a></div>
	<div class="company_phone"><?php print $eshopSettings->get("KONTAKT_TELEFON"); ?></div>


</div>

<?php /*
   if ($settings->get("FACEBOOK_PAGE") != "") { ?>
   <div class="title">Jsme na facebooku</div>
   <div class="fb-like-box" data-href="<?php print $settings->get("FACEBOOK_PAGE"); ?>" data-width="208" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false"></div>
   <div class="fblike">
   </div>

   <?php } */ ?>
<div class="title">Jsme na facebooku</div>
<div class="fb-like" data-href="<?php print URL_HOME; ?>" data-width="210" data-layout="box_count" data-action="like" data-show-faces="false" data-share="false"></div>

<?php
if ($eshopSettings->get("PRODUCT_AKCE_POS") == "LEFT")
{
	include "AkceProductList.php";
}
?>

<?php
if ($eshopSettings->get("PRODUCT_HISTORY_POS") == "LEFT")
{
	include "HistoryProductList.php";
}
?>


				<?php /* ?>
				   <div class="fblike">
				   <div class="fb-page" data-href="https://www.facebook.com/nakupsivnemecku" data-width="280" data-hide-cover="true" data-show-facepile="false" data-show-posts="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/nakupsivnemecku"><a href="https://www.facebook.com/nakupsivnemecku">„Nakup si v Nìmecku“</a></blockquote></div></div>
				   </div>
				   <?php */ ?>




	</div>
</aside>