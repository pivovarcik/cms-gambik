<?php

$expirate_system = (date("j.n.Y",strtotime($settings->get("INSTALL_DATE"))+(365 * 24 * 3600)));
?>
<div class="clearfix"> </div>
</div>
</section>
<div class="clearfix"> </div>

</section>
<footer>
	<div id="contentfooter">

		<div class="clearfix"> </div>
		<div id="copyright">
		<?php
		print '&copy; ' . date("Y") . '&nbsp;•&nbsp;<a title="' . SERVER_TITLE . '" href="' . URL_HOME . '">' . SERVER_TITLE . '</a> • &copy; Všechna práva vyhrazena.';
		?><br />
				Stránka vygenerována: <?php
				$end_app = explode(" ", microtime());
				$rd = "10000"; // zaokrouhlování
				echo (round((($end_app[1] + $end_app[0]) - $start_app) * $rd)) / $rd;
				?>sec

				<span id="rozliseni"></span>
		</div>

		<div id="fpanel" style="text-align:right"><div style="">Licence do: <?php print $expirate_system; ?>, (zbývá <?php print $date_diff["day"]; ?>dnů) <a style="padding: 2px 5px; text-decoration: none; color: #fff;" href="<?php print URL_HOME . "about"; ?>" title="O aplikaci">v<?php print VERSION_RS; ?></a></div></div>

	</div>
	</footer>
</div><?php // end #main ?>

<?php if (defined("disabled_cms")) { ?>


<script>



function updateLicence()
{

	data = {};


	url = '/admin?do=updLicence';
	callbackFunction = "reloadPage";
	paramsCallbackFunction = "";
	loadModalBase(data, url, callbackFunction, paramsCallbackFunction);


}
updateLicence();
</script>
	<?php } ?>

    <?php

$modalForm = new ModalForm("myModal");
print $modalForm->getScript();
?>

<div id="foo" style="display:none;"></div>


</body>
</html>