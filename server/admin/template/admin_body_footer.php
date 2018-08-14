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
    
    $vesion = VERSION_RS;
    
    if (strpos(PATH_ROOT_GLOBAL,"release") !== FALSE) {
    
      $vesion .= ' <span style="color:red;">VÝVOJ</span>';
    }
	//	print '&copy; ' . date("Y") . '&nbsp;•&nbsp;<a title="' . SERVER_TITLE . '" href="' . URL_HOME . '">' . SERVER_TITLE . '</a> • &copy; Všechna práva vyhrazena.';
		print '&copy; ' . date("Y") . '&nbsp;•&nbsp;<a title="CMS gambik" href="' . URL_HOME . 'about">CMS gambik v.' . $vesion . '</a> • &copy; Všechna práva vyhrazena. Licence do: ' . $expirate_system . ', (zbývá ' . $date_diff["day"] . 'dnů)';
		?><br />
    
    
      
           
				Stránka vygenerována: <?php
				$end_app = explode(" ", microtime());
				$rd = "10000"; // zaokrouhlování
				echo (round((($end_app[1] + $end_app[0]) - $start_app) * $rd)) / $rd;
				?>sec

				<span id="rozliseni"></span>
		</div>


	</div>
	</footer>
</div><?php // end #main ?>

<?php if (defined("disabled_cms")) { ?>


<script>



function updateLicence()
{

	data = {};


	url = urlBase + '?do=updLicence';
	callbackFunction = "reloadPage";
	paramsCallbackFunction = "";
	loadModalBase(data, url, callbackFunction, paramsCallbackFunction);


}
updateLicence();
</script>
	<?php } ?>

    <?php

$modalForm = new ModalForm("myModal");
print $modalForm->getScript2();
?>

<div id="foo" style="display:none;"></div>


</body>
</html>