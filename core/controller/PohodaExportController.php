<?php

class PohodaExportController{


	public function exportObjednavek()
	{


		$model = new models_Orders();

		$args = new ObjednavkaListArgs();

		$args->limit = 10;
		$list = $model->getList($args);

		print_r($list);
		exit;
		$res='<?xml version="1.0" encoding="utf-8"?>
';
		// id
		$res.='<dat:dataPack id="ob001" ico="12345678" application="StwTest" version = "2.0" note="Import Objednávky"
';
		$res.='xmlns:dat="http://www.stormware.cz/schema/version_2/data.xsd"
';
		$res.='xmlns:ord="http://www.stormware.cz/schema/version_2/order.xsd"
';
		$res.='xmlns:typ="http://www.stormware.cz/schema/version_2/type.xsd"
';
		$res.='>
';

		for ($i=0;$i<count($list);$i++)
		{
			//$item  = $xml->add_node($root, 'SHOPITEM');
			$res.='<dat:dataPackItem id="' . $id_objednavky. '" version="2.0">
';

			$res.='<ord:order version="2.0">
';

			$res.='<ord:orderHeader>
';
			$res.='<ord:orderType>receivedOrder</ord:orderType>
';
			$res.='<ord:numberOrder>' . $cislo_objednavky. '</ord:numberOrder>
';
			//2014-10-14
			$res.='<ord:date>' . $datum_objednavky. '</ord:date>
';
			//2014-10-14
			$res.='<ord:dateFrom>' . $datum_objednavky. '</ord:dateFrom>
';
			//2014-10-14
			$res.='<ord:dateTo>' . $datum_objednavky. '</ord:dateTo>
';
			//Objedn�v�me u V�s zbo�� dle �stn� dohody
			$res.='<ord:text>' . $popis_objednavky. '</ord:text>
';
			$res.='<ord:partnerIdentity>
';


			$res.='<typ:address>
';
			$res.='<typ:company>Otma a.s.</typ:company>
';
			$res.='<typ:division>Obchodn� odd�len�</typ:division>
';
			$res.='<typ:name>Petr Nov�k</typ:name>
';
			$res.='<typ:city>Brno</typ:city>
';
			$res.='<typ:street>Nov� 15</typ:street>
';
			$res.='<typ:zip>61900</typ:zip>
';
			$res.='<typ:ico>789456</typ:ico>
';
			$res.='<typ:dic>CZ789456</typ:dic>
';
			$res.='</typ:address>
';
			$res.='</ord:partnerIdentity>
';

			$res.='<ord:paymentType>
';
			$res.='<typ:ids>hotově</typ:ids>
';
			$res.='</ord:paymentType>
';
			$res.='<ord:priceLevel>
';
			$res.='<typ:ids>Sleva 1</typ:ids>
';
			$res.='</ord:priceLevel>
';
			$res.='</ord:orderHeader>
';


			$res.='<ord:orderDetail>
';
		//	<!--textova polozka-->
			$res.='<ord:orderItem>
';
			// Sestava PC
			$res.='<ord:text>'.$product_name.'</ord:text>
';
			// 1
			$res.='<ord:quantity>'.$qty.'</ord:quantity>
';
			$res.='<ord:delivered>0</ord:delivered>
';
			$res.='<ord:rateVAT>high</ord:rateVAT>
';
			$res.='<ord:homeCurrency>
';
			// 200
			$res.='<typ:unitPrice>'.$jednotkova_cena.'</typ:unitPrice>
';
			$res.='</ord:homeCurrency>
';
			$res.='</ord:orderItem>
';

		/*
			<!--skladova polozka-->
			<ord:orderItem>
			<ord:quantity>1</ord:quantity>
			<ord:delivered>0</ord:delivered>
			<ord:rateVAT>high</ord:rateVAT>
			<ord:homeCurrency>
			<typ:unitPrice>198</typ:unitPrice>
			</ord:homeCurrency>
			<ord:stockItem>
			<typ:stockItem>
			<typ:ids>STM</typ:ids>
			</typ:stockItem>
			</ord:stockItem>
			</ord:orderItem>
			</ord:orderDetail>
			*/



			$res.='<ord:orderSummary>
';
			$res.='<ord:roundingDocument>math2one</ord:roundingDocument>
';
			$res.='</ord:orderSummary>
';
			$res.='</ord:order>
';
			$res.='</dat:dataPackItem>
';
			$res.='</dat:dataPack>
';
		}

		return $res;
	}
}
/*
<?xml version="1.0" encoding="Windows-1250"?>
<dat:dataPack id="ob001" ico="12345678" application="StwTest" version = "2.0" note="Import Objednávky"
    xmlns:dat="http://www.stormware.cz/schema/version_2/data.xsd"
	  xmlns:ord="http://www.stormware.cz/schema/version_2/order.xsd"
	  xmlns:typ="http://www.stormware.cz/schema/version_2/type.xsd"
>

<dat:dataPackItem id="OBJ001" version="2.0">

		<ord:order version="2.0">
			<!--prijata objednavka s polozkama-->
			<ord:orderHeader>
				<ord:orderType>receivedOrder</ord:orderType>
				<ord:numberOrder>20140505A001</ord:numberOrder>
				<ord:date>2014-10-14</ord:date>
				<ord:dateFrom>2014-10-14</ord:dateFrom>
				<ord:dateTo>2014-10-14</ord:dateTo>
				<ord:text>Objedn�v�me u V�s zbo�� dle �stn� dohody</ord:text>
				<ord:partnerIdentity>
					<typ:address>
						<typ:company>Otma a.s.</typ:company>
						<typ:division>Obchodn� odd�len�</typ:division>
						<typ:name>Petr Nov�k</typ:name>
						<typ:city>Brno</typ:city>
						<typ:street>Nov� 15</typ:street>
						<typ:zip>61900</typ:zip>
						<typ:ico>789456</typ:ico>
						<typ:dic>CZ789456</typ:dic>
					</typ:address>
				</ord:partnerIdentity>
				<ord:paymentType>
					<typ:ids>hotov�</typ:ids>
				</ord:paymentType>
				<ord:priceLevel>
					<typ:ids>Sleva 1</typ:ids>
				</ord:priceLevel>
			</ord:orderHeader>

			<ord:orderDetail>
				<!--textova polozka-->
				<ord:orderItem>
					<ord:text>Sestava PC</ord:text>
					<ord:quantity>1</ord:quantity>
					<ord:delivered>0</ord:delivered>
					<ord:rateVAT>high</ord:rateVAT>
					<ord:homeCurrency>
						<typ:unitPrice>200</typ:unitPrice>
					</ord:homeCurrency>
				</ord:orderItem>

				<!--skladova polozka-->
				<ord:orderItem>
					<ord:quantity>1</ord:quantity>
					<ord:delivered>0</ord:delivered>
					<ord:rateVAT>high</ord:rateVAT>
					<ord:homeCurrency>
						<typ:unitPrice>198</typ:unitPrice>
					</ord:homeCurrency>
					<ord:stockItem>
						<typ:stockItem>
							<typ:ids>STM</typ:ids>
						</typ:stockItem>
					</ord:stockItem>
				</ord:orderItem>
			</ord:orderDetail>


			<ord:orderSummary>
				<ord:roundingDocument>math2one</ord:roundingDocument>
			</ord:orderSummary>

		</ord:order>

	</dat:dataPackItem>

</dat:dataPack>
*/

?>