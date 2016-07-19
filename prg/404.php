<?php
header('HTTP/1.0 404 Not Found', true, 404);
$pagetitle = "Stránka nebyla nalezena";

define('AKT_PAGE',URL_HOME . '');

$Breadcrumb = '<a href="' . URL_HOME . '" title="Přejít na Hlavní stránku">Úvod</a> › ' . $pagetitle . '';
$GHtml->setPageTitle($pagetitle);
$GHtml->setPageDescription($pagedescription);
$GHtml->setPageKeywords($cat->pagekeywords);
$GHtml->printHtmlHeader();
?>

<div style="margin: 25px auto 0px; background: none repeat scroll 0% 0% #fff; width: 690px;">
	<div style="padding: 15px; line-height: 1.6;">
			<h1><?php print $pagetitle; ?></h1>

<div class="text-box">
<p>Vámi požadovaná stránka byla pravděpodobně odstraněna, změnil se její název, není dočasně k dispozici nebo jste zadali špatné uživatelské jméno a heslo.</p>
<h2>Vyzkoušejte následující možnosti řešení:</h2>
<ul>
<li>Jestliže jste adresu stránky zadali na panelu Adresa ručně, mohli jste udělat překlep či jinou chybu. Zkuste adresu zadat ještě jednou.</li>
<li>Otevřete domovskou stránku <a href="<?php print URL_HOME  ; ?>"><?php print URL_HOME; ?></a> a hledejte odkazy na požadované informace.</li>
<li>Zkuste najít danou stránku či sekci v <a href="<?php print URL_HOME ."mapa-webu/" ; ?>">Mapě webu</a>.</li>
<li>Můžete také použít vyhledávací formulář v horním rohu stránky.</li>
</ul>

</div>

</div>
</div>
</body>
</html>
<?php
//include PATH_TEMPLE . "body_footer2.php";
?>