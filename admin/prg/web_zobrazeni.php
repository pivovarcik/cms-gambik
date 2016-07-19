<?php
$eshopController = new EshopController();

$eshopController->saveLayoutAction();
$selectedMainLayoutId = $eshopController->getLayoutMainSelected();
$selectedShopLayoutId = $eshopController->getLayoutShopSelected();
//print $selectedLayoutId;


$key = "ESHOP_MENU_POS";
$menuPos = $eshopSettings->get($key);

$key = "ESHOP_MENU_MAIN_POS";
$menuMainPos = $eshopSettings->get($key);

$key = "LOGO_MENU";
$selectedMenuPosition = $eshopSettings->get($key);


$CategoryController = new SysCategoryController();
$cat = $CategoryController->getCategory(PAGE_ID);
$pagetitle = $cat->title;

define('AKT_PAGE',$cat->link);

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($cat->pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
$pageButtons = array();

//$pageButtons[] = $form->getElement("upd-setting-eshop")->render();
$pageButtons[] = '<button class="btn btn-sm btn-success" type="submit" name="save-layout">Uložit</button>';
?>

<form class="" method="post">

<?php require_once(PATH_TEMP . 'spolecne_h1.php'); ?>



<?php
print getResultMessage();
?>


<form method="post">

<div class="row">

	<div class="col-xs-12 col-md-6">

		<fieldset class="well">
			<h2>Umístění loga</h2>
			<div class="row">
				<div class="col-xs-6 col-sm-3 zobrazeni-1 text-center">
					<label class="zobrazeni<?php if ($selectedMenuPosition == "NONE") { print ' zobrazeni-active';} ?>" for="menu_pos1">
						<div class="title">Bez loga</div>
						<div class="zobrazeni-hlavicka">[Hlavička]</div>
					</label>
					<input id="menu_pos1" type="radio"<?php if ($selectedMenuPosition == "NONE") { print ' checked="checked"';} ?> name="LOGO_MENU" value="NONE">
				</div>


				<div class="col-xs-6 col-sm-3 zobrazeni-2 text-center">
					<label class="zobrazeni<?php if ($selectedMenuPosition == "WITHOUT_LOGO") { print ' zobrazeni-active';} ?>" for="menu_pos2">
					<div class="title">Logo samostatně nad menu</div>
					<div class="zobrazeni-hlavicka">
					<div class="zobrazeni-logo">[LOGO]</div>
					<div class="zobrazeni-menu">[MENU]</div>
					</div>
					</label>
					<input id="menu_pos2" type="radio"<?php if ($selectedMenuPosition == "WITHOUT_LOGO") { print ' checked="checked"';} ?> name="LOGO_MENU" value="WITHOUT_LOGO">
				</div>

				<div class="col-xs-6 col-sm-3 zobrazeni-3 text-center">
					<label class="zobrazeni<?php if ($selectedMenuPosition == "WITHOUT_LOGO_BOTTOM") { print ' zobrazeni-active';} ?>" for="menu_pos3">
					<div class="title">Logo samostatně pod menu</div>
					<div class="zobrazeni-hlavicka">
					<div class="zobrazeni-menu">[MENU]</div>
					<div class="zobrazeni-logo">[LOGO]</div>

					</div>

					</label>
					<input id="menu_pos3" type="radio"<?php if ($selectedMenuPosition == "WITHOUT_LOGO_BOTTOM") { print ' checked="checked"';} ?> name="LOGO_MENU" value="WITHOUT_LOGO_BOTTOM">
				</div>


				<div class="col-xs-6 col-sm-3 zobrazeni-4 text-center">
					<label class="zobrazeni<?php if ($selectedMenuPosition == "WITH_LOGO") { print ' zobrazeni-active';} ?>" for="menu_pos4">
					<div class="title">Logo vedle menu</div>
					<div class="zobrazeni-hlavicka">

					[LOGO] + [MENU]

					</div>
					</label>
					<input id="menu_pos4" type="radio"<?php if ($selectedMenuPosition == "WITH_LOGO") { print ' checked="checked"';} ?> name="LOGO_MENU" value="WITH_LOGO">
				</div>
			</div>
		</fieldset>
	</div>
</div>


<div class="row">
	<div class="col-xs-12 col-md-6">

	<fieldset class="well">
<h2>Rozvržení úvodní stránky</h2>
<div class="row">
	<div class="col-xs-6 col-sm-3 zobrazeni-1 text-center">
		<label class="zobrazeni<?php if ($selectedMainLayoutId == 1) { print ' zobrazeni-active';} ?>" for="main_layout1">
			<div class="title">Třísloupcový</div>
			<div class="zobrazeni-hlavicka">[Hlavička]</div>
			<div class="zobrazeni-body">
				<div class="zobrazeni-levy-panel"><div>[Levý panel] 20%</div></div>
				<div class="zobrazeni-hlavni-panel">[Obsah]<br />60%</div>
				<div class="zobrazeni-pravy-panel">[pravý panel]<br />20%</div>
			</div>
			<div class="zobrazeni-paticka">[Patička]</div>
		</label>
		<input id="main_layout1" type="radio"<?php if ($selectedMainLayoutId == 1) { print ' checked="checked"';} ?> name="main_layout" value="1">
	</div>


	<div class="col-xs-6 col-sm-3 zobrazeni-2 text-center">
		<label class="zobrazeni<?php if ($selectedMainLayoutId == 2) { print ' zobrazeni-active';} ?>" for="main_layout2">
		<div class="title">2 sloupce - levý</div>
		<div class="zobrazeni-hlavicka">[Hlavička]</div>
		<div class="zobrazeni-body">
			<div class="zobrazeni-levy-panel">[Levý panel] 25%</div>
			<div class="zobrazeni-hlavni-panel">[obsah] 75%</div>
		</div>
		<div class="zobrazeni-paticka">[Patička]</div>
		</label>
		<input id="main_layout2" type="radio"<?php if ($selectedMainLayoutId == 2) { print ' checked="checked"';} ?> name="main_layout" value="2">
	</div>

	<div class="col-xs-6 col-sm-3 zobrazeni-3 text-center">
		<label class="zobrazeni<?php if ($selectedMainLayoutId == 3) { print ' zobrazeni-active';} ?>" for="main_layout3">
		<div class="title">2 sloupce - pravý</div>
		<div class="zobrazeni-hlavicka">[Hlavička]</div>
		<div class="zobrazeni-body">
			<div class="zobrazeni-hlavni-panel">[obsah] 75%</div>
			<div class="zobrazeni-pravy-panel">[pravý panel] 25%</div>
		</div>
		<div class="zobrazeni-paticka">[Patička]</div>
		</label>
		<input id="main_layout3" type="radio"<?php if ($selectedMainLayoutId == 3) { print ' checked="checked"';} ?> name="main_layout" value="3">
	</div>


	<div class="col-xs-6 col-sm-3 zobrazeni-4 text-center">
		<label class="zobrazeni<?php if ($selectedMainLayoutId == 4) { print ' zobrazeni-active';} ?>" for="main_layout4">
		<div class="title">1 sloupec</div>
		<div class="zobrazeni-hlavicka">[Hlavička]</div>
		<div class="zobrazeni-body">
			<div class="zobrazeni-hlavni-panel">[obsah] 100%</div>
		</div>
		<div class="zobrazeni-paticka">[Patička]</div>
		</label>
		<input id="main_layout4" type="radio"<?php if ($selectedMainLayoutId == 4) { print ' checked="checked"';} ?> name="main_layout" value="4">
	</div>
</div>

</fieldset>
</div>
	<div class="col-xs-12 col-md-6">

		<fieldset class="well">
<h2>Umístění menu na úvodní stránce</h2>

<div class="row">
<div class="col-xs-6 col-sm-3 zobrazeni-2 text-center">
	<label class="zobrazeni<?php if ($menuMainPos == "LEFT") { print ' zobrazeni-active';} ?>" for="menu_main_pos1">
		<div class="title">Menu vlevo</div>
		<div class="zobrazeni-hlavicka"></div>
		<div class="zobrazeni-body">
			<div class="zobrazeni-levy-panel active">[MENU]</div>
			<div class="zobrazeni-hlavni-panel"></div>
		</div>
		<div class="zobrazeni-paticka"></div>
	</label>
	<input id="menu_main_pos1" type="radio"<?php if ($menuMainPos == "LEFT") { print ' checked="checked"';} ?> name="ESHOP_MENU_MAIN_POS" value="LEFT">
</div>


<div class="col-xs-6 col-sm-3 zobrazeni-3 text-center">
	<label class="zobrazeni<?php if ($menuMainPos == "RIGHT") { print ' zobrazeni-active';} ?>" for="menu_main_pos2">
	<div class="title">Menu vpravo</div>
	<div class="zobrazeni-hlavicka"></div>
	<div class="zobrazeni-body">
		<div class="zobrazeni-pravy-panel active">[MENU]</div>
		<div class="zobrazeni-hlavni-panel"></div>
	</div>
	<div class="zobrazeni-paticka"></div>
	</label>
	<input id="menu_main_pos2" type="radio"<?php if ($menuMainPos == "RIGHT") { print ' checked="checked"';} ?> name="ESHOP_MENU_MAIN_POS" value="RIGHT">
</div>

<div class="col-xs-6 col-sm-3 zobrazeni-4 text-center">
	<label class="zobrazeni<?php if ($menuMainPos == "TOP") { print ' zobrazeni-active';} ?>" for="menu_main_pos3">
	<div class="title">Menu nahoře</div>
	<div class="zobrazeni-hlavicka active">[MENU]</div>
	<div class="zobrazeni-body">
		<div class="zobrazeni-hlavni-panel"></div>
	</div>
	<div class="zobrazeni-paticka"></div>
	</label>
	<input id="menu_main_pos3" type="radio"<?php if ($menuMainPos == "TOP") { print ' checked="checked"';} ?> name="ESHOP_MENU_MAIN_POS" value="TOP">
</div>


<div class="col-xs-6 col-sm-3 zobrazeni-4 text-center">
	<label class="zobrazeni<?php if ($menuMainPos == "BOTTOM") { print ' zobrazeni-active';} ?>" for="menu_main_pos4">
	<div class="title">Menu dole</div>
	<div class="zobrazeni-hlavicka"></div>
	<div class="zobrazeni-body">
		<div class="zobrazeni-hlavni-panel"></div>
	</div>
	<div class="zobrazeni-paticka active">[MENU]</div>
	</label>
	<input id="menu_main_pos4" type="radio"<?php if ($menuMainPos == "BOTTOM") { print ' checked="checked"';} ?> name="ESHOP_MENU_MAIN_POS" value="BOTTOM">
</div>

</div>
</fieldset>
</div>
</div>
<div class="row">




	<div class="col-xs-12 col-md-6">

		<fieldset class="well">
			<h2>Rozvržení eshop stránek</h2>
			<div class="row">
				<div class="col-xs-6 col-sm-3 zobrazeni-1 text-center">
					<label class="zobrazeni<?php if ($selectedShopLayoutId == 1) { print ' zobrazeni-active';} ?>" for="shop_layout1">
						<div class="title">Třísloupcový</div>
						<div class="zobrazeni-hlavicka">[Hlavička]</div>
						<div class="zobrazeni-body">
							<div class="zobrazeni-levy-panel"><div>[Levý panel] 20%</div></div>
							<div class="zobrazeni-hlavni-panel">[Obsah]<br />60%</div>
							<div class="zobrazeni-pravy-panel">[pravý panel]<br />20%</div>
						</div>
						<div class="zobrazeni-paticka">[Patička]</div>
					</label>
					<input id="shop_layout1" type="radio"<?php if ($selectedShopLayoutId == 1) { print ' checked="checked"';} ?> name="shop_layout" value="1">
				</div>


				<div class="col-xs-6 col-sm-3 zobrazeni-2 text-center">
					<label class="zobrazeni<?php if ($selectedShopLayoutId == 2) { print ' zobrazeni-active';} ?>" for="shop_layout2">
					<div class="title">2 sloupce - levý</div>
					<div class="zobrazeni-hlavicka">[Hlavička]</div>
					<div class="zobrazeni-body">
						<div class="zobrazeni-levy-panel">[Levý panel] 25%</div>
						<div class="zobrazeni-hlavni-panel">[obsah] 75%</div>
					</div>
					<div class="zobrazeni-paticka">[Patička]</div>
					</label>
					<input id="shop_layout2" type="radio"<?php if ($selectedShopLayoutId == 2) { print ' checked="checked"';} ?> name="shop_layout" value="2">
				</div>

				<div class="col-xs-6 col-sm-3 zobrazeni-3 text-center">
					<label class="zobrazeni<?php if ($selectedShopLayoutId == 3) { print ' zobrazeni-active';} ?>" for="shop_layout3">
					<div class="title">2 sloupce - pravý</div>
					<div class="zobrazeni-hlavicka">[Hlavička]</div>
					<div class="zobrazeni-body">
						<div class="zobrazeni-hlavni-panel">[obsah] 75%</div>
						<div class="zobrazeni-pravy-panel">[pravý panel] 25%</div>
					</div>
					<div class="zobrazeni-paticka">[Patička]</div>
					</label>
					<input id="shop_layout3" type="radio"<?php if ($selectedShopLayoutId == 3) { print ' checked="checked"';} ?> name="shop_layout" value="3">
				</div>


				<div class="col-xs-6 col-sm-3 zobrazeni-4 text-center">
					<label class="zobrazeni<?php if ($selectedShopLayoutId == 4) { print ' zobrazeni-active';} ?>" for="shop_layout4">
					<div class="title">1 sloupec</div>
					<div class="zobrazeni-hlavicka">[Hlavička]</div>
					<div class="zobrazeni-body">
						<div class="zobrazeni-hlavni-panel">[obsah] 100%</div>
					</div>
					<div class="zobrazeni-paticka">[Patička]</div>
					</label>
					<input id="shop_layout4" type="radio"<?php if ($selectedShopLayoutId == 4) { print ' checked="checked"';} ?> name="shop_layout" value="4">
				</div>
			</div>
		</fieldset>
	</div>
	<div class="col-xs-12 col-md-6">

			<fieldset class="well">
<h2>Umístění menu produktů v sekci shopů</h2>

<div class="row">
<div class="col-xs-6 col-sm-3 zobrazeni-2 text-center">
	<label class="zobrazeni<?php if ($menuPos == "LEFT") { print ' zobrazeni-active';} ?>" for="menu_pos1">
		<div class="title">Menu vlevo</div>
		<div class="zobrazeni-hlavicka"></div>
		<div class="zobrazeni-body">
			<div class="zobrazeni-levy-panel active">[MENU]</div>
			<div class="zobrazeni-hlavni-panel"></div>
		</div>
		<div class="zobrazeni-paticka"></div>
	</label>
	<input id="menu_pos1" type="radio"<?php if ($menuPos == "LEFT") { print ' checked="checked"';} ?> name="ESHOP_MENU_POS" value="LEFT">
</div>


<div class="col-xs-6 col-sm-3 zobrazeni-3 text-center">
	<label class="zobrazeni<?php if ($menuPos == "RIGHT") { print ' zobrazeni-active';} ?>" for="menu_pos2">
	<div class="title">Menu vpravo</div>
	<div class="zobrazeni-hlavicka"></div>
	<div class="zobrazeni-body">
		<div class="zobrazeni-pravy-panel active">[MENU]</div>
		<div class="zobrazeni-hlavni-panel"></div>
	</div>
	<div class="zobrazeni-paticka"></div>
	</label>
	<input id="menu_pos2" type="radio"<?php if ($menuPos == "RIGHT") { print ' checked="checked"';} ?> name="ESHOP_MENU_POS" value="RIGHT">
</div>

<div class="col-xs-6 col-sm-3 zobrazeni-4 text-center">
	<label class="zobrazeni<?php if ($menuPos == "TOP") { print ' zobrazeni-active';} ?>" for="menu_pos3">
	<div class="title">Menu nahoře</div>
	<div class="zobrazeni-hlavicka active">[MENU]</div>
	<div class="zobrazeni-body">
		<div class="zobrazeni-hlavni-panel"></div>
	</div>
	<div class="zobrazeni-paticka"></div>
	</label>
	<input id="menu_pos3" type="radio"<?php if ($menuPos == "TOP") { print ' checked="checked"';} ?> name="ESHOP_MENU_POS" value="TOP">
</div>


<div class="col-xs-6 col-sm-3 zobrazeni-4 text-center">
	<label class="zobrazeni<?php if ($menuPos == "BOTTOM") { print ' zobrazeni-active';} ?>" for="menu_pos4">
	<div class="title">Menu dole</div>
	<div class="zobrazeni-hlavicka"></div>
	<div class="zobrazeni-body">
		<div class="zobrazeni-hlavni-panel"></div>
	</div>
	<div class="zobrazeni-paticka active">[MENU]</div>
	</label>
	<input id="menu_pos4" type="radio"<?php if ($menuPos == "BOTTOM") { print ' checked="checked"';} ?> name="ESHOP_MENU_POS" value="BOTTOM">
</div>

</div>
	</fieldset>
</div>
</div>

<h2>Výpis produktů</h2>
<div class="row">

	<div class="col-xs-6 col-sm-3 product-list-1">
		<div class="title">2 produkty</div>
		<div class="product"></div>
		<div class="product"></div>
	</div>

	<div class="col-xs-6 col-sm-3 product-list-2">
		<div class="title">3 produkty</div>
		<div class="product"></div>
		<div class="product"></div>
		<div class="product"></div>
	</div>

	<div class="col-xs-6 col-sm-3 product-list-3">
		<div class="title">4 produkty</div>
		<div class="product"></div>
		<div class="product"></div>
		<div class="product"></div>
		<div class="product"></div>
	</div>
	<div class="col-xs-6 col-sm-3 product-list-4">
		<div class="title">5 produktů</div>
		<div class="product"></div>
		<div class="product"></div>
		<div class="product"></div>
		<div class="product"></div>
		<div class="product"></div>
	</div>
</div>
<?php

//$GTabs = new SettingsTabs($form);

?>
<div id="tabs-nested-left">
<?php
//print $GTabs->makeTabs();
?>
</div>
<div class="clearfix"> </div>
	</form>

<?php
include PATH_TEMP . "admin_body_footer.php";