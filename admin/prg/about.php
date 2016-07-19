<?php
include dirname(__FILE__) . "/../inc/init_admin.php";
$pagetitle = "Redakční systém Gambik!";
define('AKT_PAGE',URL_HOME . 'admin/about.php');

$GHtml->setPagetitle($pagetitle);
$GHtml->setPagedescription($pagedescription);
$GHtml->printHtmlHeader();
include PATH_TEMP . "admin_body_header.php";
?>
<section>
<div class="wraper">
<h1><?php echo $pagetitle; ?></h1>
<p class="tip">Děkujeme, že používáte redakční systém RS Gambik. Jeho užíváním přispíváte k dalšímu rozvoji systému. Aktuální informace o novinkách a změnách naleznete vždy na našich domovských stránkách <a href="http://www.pivovarcik.cz">www.pivovarcik.cz</a>.</p>
<form class="standard_form">
<fieldset>
<label>Verze systému:</label><input readonly="readonly" style="width:300px;" class="textbox readonly" type="text" value="<?php print VERSION_RS; ?>" /><span class="check_version"></span>
<p class="desc"></p>
<br />
<label>Licenční klíč:</label><input readonly="readonly" class="textbox readonly" type="text" style="width:300px;" name="LICENCE_KEY" value="<?php print $settings->get("LICENCE_KEY"); ?>" /> <a href="#">Validace</a>
<p class="desc">Licenční číslo k užívání systému.</p>
<br />
<label>Datum sestavení:</label><input readonly="readonly" class="textbox readonly" type="text" style="width:300px;" value="<?php print date("j.n.Y",strtotime(VERSION_DATE)); ?>" />
<p class="desc"></p>
<br />
<label>Datum instalace:</label><input readonly="readonly" class="textbox readonly" type="text" style="width:300px;" value="<?php print date("j.n.Y",strtotime(INSTALL_DATE)); ?>" />
<p class="desc"></p>
<br />
<label>Verze PHP:</label><input readonly="readonly" class="textbox readonly" type="text" style="width:300px;" value="<?php print phpversion(); ?>" />
<p class="desc"></p>
<br />
<?php
$filename = PATH_ROOT. "robots.txt";
$file = file_get_contents($filename);
if(is_file($filename))
{
  $robots_txt= "Existuje";
} else
{
  $robots_txt= "Neexistuje";
}
?>
<label>Robots.txt:</label><input readonly="readonly" class="textbox readonly" style="width:300px;"  type="text" value="<?php print $robots_txt; ?>" />
<p class="desc"></p>
<br />
<label>Obsah:</label>
<textarea class="textarea" style="height:100px" name="" cols="55" rows="3">
<?php print_r($file); ?></textarea>
<p class="desc">Obsah Robots.txt</p>
<br />
<label>Systém vytvořil:</label><input disabled="disabled" class="textbox" type="text" value="<?php print AUTOR_RS; ?>" />
<p class="desc"></p>
<br />
<label>Helpdesk:</label><input disabled="disabled" class="textbox" type="text" value="<?php print CONTACT_RS; ?>" />
<p class="desc"></p>
<br />
<?php
$filename = PATH_ROOT. ".htaccess";
$file = file_get_contents($filename);
if(is_file($filename))
{
  $robots_txt= "Existuje";
} else
{
  $robots_txt= "Neexistuje";
}
//print $robots_txt;
$file = file_get_contents($filename);

?>
<label>Obsah:</label>
<textarea class="textarea" style="height:150px" name="" cols="55" rows="8">
<?php print_r($file); ?></textarea>
<p class="desc">Obsah .htaccess</p>
<br />

</fieldset>

<h2>Ceník systému</h2>
<fieldset>
<label>Základní cena:</label><input disabled="disabled" style="text-align:right;width:100px;" class="textbox" type="text" value="59.00" />Kč / měsíc
<p class="desc"></p>
<br />
</fieldset>
</form>
</div>
</section>
	<script>
$(document).ready(function(){
	check_version();
});
	</script>
<?php
include PATH_TEMP . "admin_body_footer.php";