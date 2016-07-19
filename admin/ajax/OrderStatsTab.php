<?php

/**
 * Statistika objednávek na nástěnku
 *
 * @version $Id$
 * @copyright 2013
 */
//include dirname(__FILE__) . "/../../inc/init_admin.php";
include dirname(__FILE__) . "/../../inc/init_admin_ajax.php";

$model = new models_Orders();

$params = new ListArgs();

$date = date("Y-m-d H:i:s");
$params->TimeStampTo = $date;
$params->TimeStampFrom = date("Y-m-d",strtotime ( '-1 month' , strtotime($date) ) );
$stats = $model->getStats($params);

?>

	<h5>Měsíční aktivita<a href="#" class="right refresh"><i class="fa fa-refresh"></i></a></h5>
	<table style="width:100%;" class="table_info_details">
			<colgroup>
				<col width="">
				<col width="80px">
			</colgroup>
		<tbody><tr class="tr_odd">
			<td class="td_align_left">
			Prodáno
			</td>
			<td>
				<?php print numberFormat($stats->cost_total); ?>
			</td>
		</tr>
		<tr class="tr_odd">
			<td class="td_align_left">
				Počet objednávek
			</td>
			<td>
				<?php print ($stats->count_total); ?>
			</td>
			</td>
		</tr>
	</tbody></table>
