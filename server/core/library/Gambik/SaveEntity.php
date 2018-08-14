<?php

/**
 * Obecná obálka pro ukládání Entit v transakci
 * automaticky dohledává cizí klíče z uložených entit, není nutné do uložení posílat svazané klíče!
 * přidána podpora ukládání kolekce entit
 * auto doplnění USER_ID
 * **/
class SaveEntity {


	private $saveEntityList = array();

	private $savedEntityList = array();

	private $afterQueriesList = array();

	private $beforeQueriesList = array();

	private $lastSavedEntity = null;

	private $lastSaveEntity = null;

	private $all_query_ok = true;

	public $model = null;
	public $debug = false;
	/**
	 * přidání Entity pro uložení
	 * */

	public function __construct()
	{
		$this->model = new G_Service(null);
		//	$this->model->start_transakce();
	}

	// přidá entitu do kolekce ukládaných entit, v pořádí order
	public function addSaveEntity(AEntity $saveEntita, $order = null)
	{
		$saveEntitaName = get_class($saveEntita);


		// pokud již existuje
		if (isset($this->saveEntityList[$saveEntitaName])) {

			if (is_array($this->saveEntityList[$saveEntitaName])) {
				//	$this->saveEntityList[$saveEntitaName][] = $kopieEntity;
				array_push($this->saveEntityList[$saveEntitaName], $saveEntita);
			} else {
				$kopieEntity = $this->saveEntityList[$saveEntitaName];
				$this->saveEntityList[$saveEntitaName] = array();
				array_push($this->saveEntityList[$saveEntitaName], $kopieEntity);
				array_push($this->saveEntityList[$saveEntitaName], $saveEntita);
			}

		} else {
			$this->saveEntityList[$saveEntitaName] = $saveEntita;
		}

		//$this->saveEntityList[$saveEntitaName] = $saveEntita;
	}

	/*
	 * Přidá kolekce entit do ukládání
	*/
	public function addSaveEntities($saveEntitiesList = array())
	{
		foreach ($saveEntitiesList as $saveEntita) {
			$this->addSaveEntity($saveEntita);
		}
	}

	/**
	 * Query spuštěné po uložení entit
	 * */
	public function addAfterQuery($query)
	{
		array_push($this->afterQueriesList, $query);
	}
	public function getAfterQueries()
	{
		return $this->afterQueriesList;
	}

	/**
	 * Query spuštěné před uložením entit
	 * */
	public function addBeforeQuery($query)
	{
		array_push($this->beforeQueriesList, $query);
	}
	public function getBeforeQueries()
	{
		return $this->beforeQueriesList;
	}

	public function addDeletedEntity(AEntity $saveEntita, $order = null)
	{

	}

	public function addDeletedEntityId(AEntity $saveEntita, $order = null)
	{

	}


	/***
	 * Odešle data k uložení pod transakcí
	 *   @return bool - prošlo ulož Ano/Ne
	 ***/
	public function setSaveEntity(AEntity $saveEntita)
	{
		if ( !is_subclass_of($saveEntita,"AEntity")) {
			throw new Exception('Prvek musi byt typu Entita!');
		}

		// Zpracování cizích klíčů
		// Provedu kontrolu na existenci cizích klíčů v ukládané entitě a porovnám je s již uloženými entitami, a pokusím se je automaticky provázat
		//RequestTicketEntity
		$dataEntity = $saveEntita->vratEntitu();
		foreach ($dataEntity as $key => $value) {

			$meta = $saveEntita->getMetadata($key);

			if ((isEmpty($value)) && isset($meta["default"]) && strtoupper($meta["default"])== "NOT NULL" ) {
				// nesmí nastat jinak musí nastat výjimka
				if (isset($meta["reference"])) {

					// snažím se dohledat, zda-li v uložených datech existuje vazební entita
					if ($vazebniEntita = $this->getSavedEntity($meta["reference"]."Entity")) {
						// Pozor neověřuji pravost klíče (rozsah apod.)
						$saveEntita->$key = $vazebniEntita->getId();
					} else {
						throw new Exception('Atribut  ' . get_class($saveEntita) . '.' . $key . ' musi obsahovat hodnotu! Reference: ' . get_class($vazebniEntita) . '');
						$this->all_query_ok = false;
						return false;
					}
				} else {
					throw new Exception('Atribut ' . get_class($saveEntita) . '.' . $key . ' musi obsahovat hodnotu! Reference: ' . get_class($vazebniEntita) . '');
					$this->all_query_ok = false;
					return false;
				}
			}

			// řeším automaticky přidělení User_id - Pozor platí pouze pro insert, editace je nežádoucí,
			// proto rozšířeno o kontrolu zda existuje ID
			if (is_null($saveEntita->getId()) && isEmpty($value) && $key == "user_id" ) {
				if (defined("USER_ID")) {
					$saveEntita->$key = USER_ID;
				}
			}

		}
		//array_push($this->saveEntityList,$saveEntita);
		return $this->saveData($saveEntita);
	}

	public function merge()
	{
		$model = new G_Service(null);
		$all_query_ok = true;
		$model->start_transakce();

		//	print_r($this->savedEntityList);
		//	exit;
		foreach ($this->saveEntityList as $key => $savedEntita) {
			if (!self::saveData($savedEntita)) {
				$model->konec_transakce(false);
				return false;
			}
		}

		if ($model->konec_transakce($all_query_ok)) {
			return true;
		}
	}

	/**
	 * Provede uložení kolekce entit v zadaném pořadí
	 * **/
	public function save()
	{
		$this->model->start_transakce();

		if ($queries = $this->getBeforeQueries()) {

			foreach ($queries as $key => $query) {

				//$this->model->query($query);
					$this->model->query($query) ? null : $this->all_query_ok = false;
				if ($this->debug) {
					print $this->model->getLastQuery() . "<br />";
				}
			}
		}




		if ($entityProUloz = $this->getSaveEntity()) {


			//print_r($entityProUloz);

			foreach ($entityProUloz as $key => $entita) {

				if (is_array($entita)) {
					foreach ($entita as $key2 => $entita2)
					{
						$this->setSaveEntity($entita2);
					}
				} else {
					$this->setSaveEntity($entita);
				}
			}
		}

		if ($queries = $this->getAfterQueries()) {

			foreach ($queries as $key => $query) {

			//	$this->model->query($query);
				$this->model->query($query) ? null : $this->all_query_ok = false;

				if ($this->debug) {
					print $this->model->getLastQuery() . "<br />";
				}
			}
		}
		if ($this->all_query_ok === false) {
			throw new Exception('Proveden ROLLBACK - Ukládání dat přerušeno - Data nebyla uložena!');
		}
	//	var_dump($this->all_query_ok);
		if ($this->model->konec_transakce($this->all_query_ok)) {
			return true;
		}
	}

	// Vrací uloženou entitu/kolekci entit
	public function getSavedEntity($entityName = null)
	{
		if (null === $entityName) {
			return $this->savedEntityList;
		}

		return (isset($this->savedEntityList[$entityName])) ? $this->savedEntityList[$entityName] : false;

		//return $this->savedEntityList;
	}

	// Vrací uloženou entitu/kolekci entit
	public function getSaveEntity($entityName = null)
	{
		if (null === $entityName) {
			return $this->saveEntityList;
		}
		/*
		   if (isset($this->saveEntityList[$entityName])) {

		   if (is_array($this->saveEntityList[$entityName]) && count($this->saveEntityList[$entityName])>0) {
		   return $this->saveEntityList[$entityName];
		   } else {

		   }

		   }*/
		return (isset($this->saveEntityList[$entityName])) ? $this->saveEntityList[$entityName] : false;

		//return $this->savedEntityList;
	}

	/**
	 * Vrací poslední uloženou entitu, v
	 * */
	public function getLastSavedEntity()
	{
		return $this->lastSavedEntity;
	}

	/**
	 * Vrací poslední ukládanou entitu, v podobě ještě před uložením
	 * */
	public function getLastSaveEntity()
	{
		return $this->lastSaveEntity;
	}
	protected function saveData($saveEntita)
	{
		$this->lastSaveEntity = $saveEntita;
		//	$all_query_ok = true;
		//	$model = new G_Service($saveEntita->getTablename());
		//	print_R($savedEntita->vratEntitu());
		//	EXIT;



		if (is_null($saveEntita->getId())) {

			//
			//	PRINT "INSERT " . $savedEntita->getTablename();
			$this->model->insertRecords($saveEntita->getTablename(),
									$saveEntita->vratEntitu());
			$entita_id = $this->model->insert_id;

			// insert
		} else {
			// update
			//	PRINT "UPDATE";
			// potřebuji ověřit zda ID entity neexituje v DB
			$detail = $this->model->get_row("select id from {$saveEntita->getTablename()} where id={$saveEntita->getId()}");

			if ($detail) {
				$this->model->updateRecords($saveEntita->getTablename(),
							$saveEntita->getChangedData(),
							"id={$saveEntita->getId()}");
				$entita_id = $saveEntita->getId();
			} else {
				//	PRINT "INSERT " . $savedEntita->getTablename();
				$this->model->insertRecords($saveEntita->getTablename(),
						$saveEntita->vratEntitu());
				$entita_id = $this->model->insert_id;
			}



		}


		if ($this->debug) {
			print $this->model->getLastQuery() . "<br />";
		}

		$this->model->commit ? null : $this->all_query_ok = false;

		if ($this->all_query_ok) {
			//	PRINT "OK";
			//$savedEntitaData = $model->getDetailById($entita_id);


			$data = $saveEntita->vratEntitu();
			$data["id"] = $entita_id;
			$saveEntitaName = get_class($saveEntita);

			// naplním saved entitu uloženými daty, včetně Id
			$savedEntita = new $saveEntitaName($data);

			$this->lastSavedEntity = $savedEntita;
			$this->savedEntityList[$saveEntitaName] = $savedEntita;
			//	array_push($this->savedEntityList,$savedEntita);
		} ELSE {
			//	PRINT "ROLLBACK";
			$data = $saveEntita->vratEntitu();
			$saveEntitaName = get_class($saveEntita);
			//	print $this->model->getLastQuery();
			throw new Exception('Entitu ' . $saveEntitaName . ' se nepodarilo ulozit!' . ' Query: ' .$this->model->getLastQuery());
		}
		/*
		   print $savedEntita->getGlobalId();
		   //	print	UUID::v4();
		   print_r($saveData);

		   print $savedEntita->getId();
		   $data = array();
		*/
		return $this->all_query_ok;
	}
}
