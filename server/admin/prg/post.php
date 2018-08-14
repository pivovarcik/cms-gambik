<?php


$pagetitle = "Detail článku";

$publishController = new PublishController();
$main = $publishController->getPublish();

$params = array(
'buttons1'=>"",
'buttons2'=>"",
'buttons3'=>"",
'valid'=>$settings->get("TINY_VALID"),
'width'=>$settings->get("TINY_WIDTH"),
'height'=>$settings->get("TINY_HEIGHT"),
'plugins'=>$settings->get("TINY_PLUGINS"),
);
$script = tinyMceInit($params);
$GHtml->setCokolivToHeader($script);
$GHtml->setCokolivToHeader($script);

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";?>
<section>
<div class="wraper">
<h1><?php echo $smazano; ?></h1>
<div class="standard_form">
	<fieldset>


	<div style="color:#0C0C17;">
<div style="border: 1px solid #E4E4E4;padding: 3px;margin-top:10px">

				<?php
				// Verzování dle jazyků
				$first = true;
				foreach ($languageList as $key => $val)
				{
				if ($first) {
					$style="display:block;";
				} else {
					$style="display:none;";
				}
				?>
					<h1 class="lang lang_<?php print $val->code;?>" style="<?php print $style;?>">
					<?php
					$name ="title_" . $val->code;
					print $main->$name; ?>
					</h1>

					<div id="text_cs">
										<?php
										$name ="description_" . $val->code; ?>
					<textarea class="textarea mceEditor" name="clanek_cs" cols="55" rows="3"><?php print htmlentities($main->$name,ENT_COMPAT, 'UTF-8'); ?></textarea>
					</div>
															<?php
															$name ="link_" . $val->code;?>
					<p>Veřejná adresa: <a target="_blank" href="<?php echo $main->$name; ?>"><?php echo $main->$name; ?></a></p>
				<?php
				$first = false;
				}
			//print_r($main);
				?>
</div>
  </div>


		<p>Vloženo: <strong><?php echo $main->autor;?> <?php echo date("j.n.Y H:i:s", strtotime($main->PageTimeStamp)); ?></strong></p>
    	<p>Publikováno: <strong><?php echo date("j.n.Y H:i:s", strtotime($main->publicDate)); ?></strong></p>
		<p>Poslední změna: <strong><?php echo $main->editor;?> <?php echo date("j.n.Y H:i:s", strtotime($main->PageChangeTimeStamp)); ?></strong> verze: <?php echo $main->version;?></p>
		<?php if ($clanek->kos==0) { ?>
	<p><a href="<?php print URL_HOME; ?>admin/post_edit.php?id=<?php print $main->id; ?>" class="tlac" />Upravit</a></p>
	<?php } ?>
</fieldset>
</div>

</div>
</section>
<?php
include PATH_TEMP . "admin_body_footer.php";