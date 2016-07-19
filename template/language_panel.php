



<ul id="langbox" class="nav navbar-nav navbar-left">
	 <?php
   if (count($languageList) > 1) {
   	?>

	 			<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php print (LANG_TRANSLATOR_NAME); ?> <span class="caret"></span></a>
		<ul class="dropdown-menu">
	 	<?php


	 	// Verzování dle jazyků
	 	$first = true;
	 	foreach ($languageList as $key => $val)
	 	{
	 		$name = "link_".$val->code;

	 		$selected = ($val->code == LANG_TRANSLATOR) ? ' class="selected"' : '';

	 		if ($val->code != LANG_TRANSLATOR) {
	 			$link = $cat->$name;
	 			if (isset($main)) {
	 				$link = $main->$name;
	 			}

	 			?>
	 			<li><a<?php print $selected;?> id="lnkLang<?php print strtoupper($val->code);?>" href="<?php print $link; ?>"><span><?php print ($val->name);?></span></a></li>
   <?php } } ?>

</ul>
</li>
   <?php } ?>
</ul>
