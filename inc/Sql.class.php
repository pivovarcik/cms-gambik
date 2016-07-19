<?php
define("MYSQL_VERSION", "1.02");

define('T_REFERER', DB_PREFIX . 'refer');
define('T_TRANSLATOR', DB_PREFIX . 'translator');
define('T_CATEGORY_I', DB_PREFIX . 'category_i');
define('T_INZERT', DB_PREFIX . 'inzert');
define('T_MENU', DB_PREFIX . 'sys_category');
define('T_POCASI', '0_pocasi');
define('T_UZIV', DB_PREFIX . 'uziv');
define('T_PERMS', DB_PREFIX . 'pristupy');
define('T_CUSTOMER', DB_PREFIX . 'eshop_customer');
define("T_SHOP_STAVY","shop_stavy");
define("T_SHOP_SKLADY","shop_sklady");
define("T_SHOP_POHYBY","shop_pohyby");
define("T_SHOP_CUSTOMER","mm_shop_customer");
define('T_CENY', DB_PREFIX . 'shop_ceny');
define('T_CENIKY', DB_PREFIX . 'shop_ceniky');

class Sql
{
	private static  $debug_all = false;  // Debug SQL ? false true true
	private static  $benchmark = false;  // Debug SQL ? false true true
	private static  $debug_called;
	private static  $vardump_called;
	private static  $escape_string = true;
	private static  $show_errors = true;
	private static  $commit = true;
	private static  $num_queries = 0;
	private static  $last_query;
	private static  $last_result;
	private static  $col_info;
	private static $querycount = 0;
	private static $func_call;
	private static $result;
	private static  $mysqli;
	public static  $insert_id;
	private static  $all_query_ok = true; // parametr jestli prošel příkaz


	private static  $protokol = false;

	private static $start_transaction = false;
	private static $_select = "";
	private static $_from = "";
	private static $_where = array();
	private static $_orderBy;
	private static $_limit;
	private static $_name;
	private static $_groupBy;
	private static $num_rows;
	public static $rows_affected;
	private static $_primary = "id";
	private static $_data = array();

	private static $instance;
	private static $pripojeni;
	// Prevent this class from being directly instantiated externally.
	private function __construct() {}
	private function __clone() {}

	public static function instance()
	{
		if( !isset( self::$instance ) )
		{
			$c = __CLASS__;
			self::$instance = new $c();
			self::$instance->spojit();
		}
		return self::$instance;
	}

	public static function getLastQuery()
	{
		return self::$last_query;
	}

	public static function getCommit()
	{
		return self::$commit;
	}
	public static function setSelect($slct)
	{
		self::$_select = $slct;
	}

	public static function getSelect()
	{
		return "SELECT " . self::$_select;
	}
	public static function setFrom($frm)
	{
		self::$_from = $frm;
	}

	public static function addWhere($where){
		if (empty($where)) {
			return;
		}
		self::$_where[] = trim($where);
	}

	public static function getFrom()
	{
		//print "===" . self::$_from . "===";
		if (!strpos(strtolower(self::$_from),"from")) {
			return " FROM " . self::$_from . " ";
		}
		return " " . self::$_from . " ";


	}
	public static function setWhere($whr)
	{
		self::$_where = $whr;
	}

	public static function getWhere()
	{
		$whr = "";
		if (count(self::$_where)>0) {
			foreach (self::$_where as $key => $value) {
				$whr .="(" . $value . ") AND";
			}
			if (substr($whr, -3) =="AND"){
				$whr = substr($whr,0,strLen($whr)-3);
			}
			return " WHERE " . $whr;
		}
		return $whr;
	}

	public static function spojit()
	{
		self::$pripojeni = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		if (self::$pripojeni === false) {
			print "Chyba při pokusu o připojení k DB!";
			exit;
		}
		self::$instance->query("SET NAMES 'utf8';");
		self::$instance->query("SET SQL_BIG_SELECTS=1;");

	//	var_dump( get_magic_quotes_gpc() );

		if(get_magic_quotes_gpc()){
			self::$escape_string = false;
	//		print "vypinam escapovaní";
		}

		//mysqli_rollback($this->pripojeni);
	}

	public static function donation()
	{
		return "";
	}
	// ==================================================================
	// Nastavit zobrazeni / skryti vypisu SQL chyb

	public static function show_errors()
	{
		self::$show_errors = true;
	}

	public static function hide_errors()
	{
		self::$show_errors = false;
	}

	// ==================================================================
	//	Kill cached query results

	function flush()
	{

		// Get rid of these
		self::$last_result = null;
		self::$col_info = null;
		self::$last_query = null;

	//	self::$last_query = null;


	}

	// ==================================================================

	public static function escape($string)
	{

	//	print "pred:".$string . " > ";
		if (self::$escape_string) {
			$string = mysqli_real_escape_string(self::$pripojeni, $string);
		} else {
			//$string = stripslashes($string);
		}
	//	print $string . "<br />";

		return $string;
	}
	public static function query($query,$multi = false)
	{
		//$query = strtolower($query);
		$query = str_replace("  "," ",$query);
		$query = str_replace("select select","select",$query);
		$query = str_replace("SELECT SELECT","select",$query);

		$query = str_replace("from from","FROM",$query);
		$query = str_replace("from FROM","FROM",$query);
		$query = str_replace("FROM FROM","FROM",$query);

/*		print "<br />========<br />";
		print $query;
		print "<br />========<br />";
*/
		//print mysqli_error($this->pripojeni);
		// číslovaní dotazu
		self::$querycount = self::$querycount + 1;

		// Flush cached values..
		self::$instance->flush();

		// Log how the function was called
		self::$func_call = "\$db->query(\"$query\")";

		// Keep track of the last query for debug..
		self::$last_query = $query;

		$stopky = new GStopky();
		$stopky->start();

		if ($multi) {
			self::$result = mysqli_multi_query(self::$pripojeni,$query);
		} else {

			self::$result = mysqli_query(self::$pripojeni,$query);
		}


		//self::$result = mysqli_query(self::$pripojeni,$query);

		//	self::$result = mysqli_multi_query(self::$pripojeni,$query);

		$casQuery = $stopky->konec();
		if ($casQuery > 0.1) {
		//	print $stopky->konec();

		//	print self::$last_query;

		}

	//	print_r(self::$result);
		self::$commit = true;
		if (false == self::$result)
		{
			self::$commit = false;
//			print "chyba!!!!!!!!!!!!!!!!!!!!!!!!";
		//	print self::$last_query;

			//var_dump(mysqli_error(self::$pripojeni));


			$akce = "error";

			$query_protokol = SERVER_NAME . "


" . self::$last_query . "

" .
				(mysqli_error(self::$pripojeni)). "

" .
				$_SERVER["SCRIPT_FILENAME"] . "?" . $_SERVER["QUERY_STRING"]. "
" .
				$_SERVER["REMOTE_ADDR"];

			mail("rudolf.pivovarcik@centrum.cz",$akce,$query_protokol);
			return false;
		}
		//self::$result ? null : self::$all_query_ok = false;

		//print_r(mysqli_error());

		//self::$result = mysqli_query(self::$pripojeni,$query);// ? null : $all_query_ok=false;

		$query_type = array("insert", "delete", "update", "replace");

		// loop through the above array
		foreach ( $query_type as $word )
		{
			// This is true if the query starts with insert, delete or update
			if ( preg_match("/^\\s*$word /i",$query) )
			{
				self::$rows_affected = mysqli_affected_rows(self::$pripojeni);

				// This gets the insert ID
				if ( $word == "insert" || $word == "replace" )
				{
					self::$insert_id = mysqli_insert_id(self::$pripojeni);
					//print self::$insert_id;
					// Vrací ID insert řádku
					return self::$insert_id;
				}

				// Set to false if there was no insert id
				self::$result = false;

			}
		}
		//  zaznameni chyb
		if ( mysqli_error(self::$pripojeni) )
		{
			// If there is an error then take note of it..
			//print "chyba";
			if (self::$start_transaction) {

				//self::$konec_transakce(false);
			}
			self::$instance->print_error();
			//self::$error_num = mysqli_errno(self::$pripojeni);
		}
		else
		{

			// In other words if this was a select statement..
			if ( self::$result && is_object(self::$result))
			{
				/*
				print "==========================<br />";
				print_r(self::$result);
				print "==========================<br />";
				*/
				// =======================================================
				// Take note of column info

				$i=0;
				while ($i < mysqli_num_fields(self::$result))
				{
					self::$col_info[$i] = mysqli_fetch_field(self::$result);
					$i++;
				}

				// =======================================================
				// Store Query Results

				$i=0;
				while ( $row = mysqli_fetch_object(self::$result) )
				{

					// Store relults as an objects within main array
					self::$last_result[$i] = $row;

					$i++;
				}

				// Log number of rows the query returned
				self::$num_rows = $i;

				mysqli_free_result(self::$result);

				// If debug ALL queries
				self::$debug_all ? self::$instance->debug() : null ;

				// If there were results then return true for $db->query
				if ( $i )
				{
					return true;
				}
				else
				{
					return false;
				}

			}
			else
			{
				// If debug ALL queries
				self::$debug_all ? self::$instance->debug() : null ;

				// Update insert etc. was good..
				return true;
			}
		}
	}
	public static function start_transakce($auto)
	{
		//	print "start transsakce";
		//	mysqli_autocommit(self::$pripojeni, false);

		if( phpversion() < '5.5.0' ) { self::query( 'START TRANSACTION' ); } else { mysqli_begin_transaction(self::$pripojeni, false); }
		self::$start_transaction = true;
	}
	public static function konec_transakce($all_query_ok)
	{
		//if (self::$start_transaction)
		//{
		/*
			if ($all_query_ok) {
				print "prošel";
			} else {
				print "neprošel";
			}*/
			//mysqli_rollback(self::$pripojeni);
			$all_query_ok ? mysqli_commit(self::$pripojeni) : mysqli_rollback(self::$pripojeni);
			self::$start_transaction = false;
			return $all_query_ok;
		//}
	}

	// ==================================================================
	//	Print SQL/DB error.


	// ==================================================================
	public function debug()
	{


		$end_app = explode(" ", microtime());
		$rd = "10000"; // zaokrouhlování
		echo ((round((($end_app[1] + $end_app[0]) - START_APPLICATION) * $rd)) / $rd) . "sec";

		$print ='<div style="position:relative;top:0;left:0;">';

		// Only show ezSQL credits once..
		if ( ! self::$debug_called )
		{
			$print .= "<font color=800080 face=arial size=2><strong>MySQL</strong> (v" . MYSQL_VERSION . ") <strong>Debug mod..</strong></font><p>\n";
		}
		$print .=  "<font face=arial size=2 color=000099><strong>Query</strong> [" . self::$num_queries . "] <strong>--</strong> ";
		$print .=  "[<font color=000000><strong>" . self::$last_query . "</strong></font>]</font><p>";

		$print .=  "<font face=arial size=2 color=000099><strong>Query Result..</strong></font>";
		$print .=  "<blockquote>";
/*
		if ( self::$col_info )
		{

			// =====================================================
			// Results top rows

			$print .=  "<table cellpadding=5 cellspacing=1 bgcolor=555555>";
			$print .=  "<tr bgcolor=eeeeee><td nowrap valign=bottom><font color=555599 face=arial size=2><strong>(row)</strong></font></td>";


			for ( $i=0; $i < count(self::$col_info); $i++ )
			{
				$print .=  "<td nowrap align=left valign=top><font size=1 color=555599 face=arial>(" . self::$col_info[$i]->type . " " . self::$col_info[$i]->max_length . ")</font><br /><span style='font-family: arial; font-size: 10pt; font-weight: bold;'>" . self::$col_info[$i]->name . "</span></td>";
			}

			$print .=  "</tr>";

			// ======================================================
			// print main results

			if ( self::$last_result )
			{

				$i=0;
				foreach ( self::$instance->get_results(null,"ARRAY_N") as $one_row )
				{
					$i++;
					$print .=  "<tr bgcolor=ffffff><td bgcolor=eeeeee nowrap align=middle><font size=2 color=555599 face=arial>" . $i . "</font></td>";

					foreach ( $one_row as $item )
					{
						$print .=  "<td nowrap><font face=arial size=2>" . $item . "</font></td>";
					}

					$print .=  "</tr>";
				}

			} // if last result
			else
			{
				$print .=  "<tr bgcolor=ffffff><td colspan=".(count(self::$col_info)+1)."><font face=arial size=2>No Results</font></td></tr>";
			}

			$print .=  "</table>";

		} // if col_info
		else
		{
			$print .=  "<font face=arial size=2>No Results</font>";
		}
*/
		$print .=  "</blockquote></div>".self::$instance->donation()."<hr noshade color=dddddd size=1>";

		print $print;
		self::$debug_called = true;



	}

	// ==================================================================
	//	Function to get 1 column from the cached result set based in X index
	// se docs for usage and info

	function get_col($query=null,$x=0)
	{

		// If there is a query then perform it if not then use cached results..
		if ( $query )
		{
			self::$instance->query($query);
		}

		// Extract the column values
		for ( $i=0; $i < count(self::$last_result); $i++ )
		{
			$new_array[$i] = self::$get_var(null,$x,$i);
		}

		return $new_array;
	}

	// ==================================================================
	// Function to get column meta data info pertaining to the last query
	// see docs for more info and usage

	function get_col_info($info_type="name",$col_offset=-1)
	{

		if ( self::$col_info )
		{
			if ( $col_offset == -1 )
			{
				$i=0;
				foreach(self::$col_info as $col )
				{
					$new_array[$i] = $col->{$info_type};
					$i++;
				}
				return $new_array;
			}
			else
			{
				return self::$col_info[$col_offset]->{$info_type};
			}

		}

	}

	function get_results($query=null, $output = "OBJECT")
	{

		// Log how the function was called
		self::$func_call = "\$db->get_results(\"$query\", $output)";

		// If there is a query then perform it if not then use cached results..
		if ( $query )
		{
			self::$instance->query($query);
		}

		// Send back array of objects. Each row is an object
		if ( $output == "OBJECT" )
		{
			return self::$last_result;
		}
		elseif ( $output == "ARRAY_A" || $output == "ARRAY_N" )
		{
			if ( self::$last_result )
			{
				$i=0;
				foreach( self::$last_result as $row )
				{

					$new_array[$i] = get_object_vars($row);

					if ( $output == "ARRAY_N" )
					{
						$new_array[$i] = array_values($new_array[$i]);
					}

					$i++;
				}

				return $new_array;
			}
			else
			{
				return null;
			}
		}
	}

	function get_results2($query=null, $output = "OBJECT")
	{

		// Log how the function was called
		self::$func_call = "\$db->get_results(\"$query\", $output)";

		// If there is a query then perform it if not then use cached results..
		if ( $query )
		{
			self::$instance->query($query, true);
		}

		// Send back array of objects. Each row is an object
		if ( $output == "OBJECT" )
		{
			return self::$last_result;
		}
		elseif ( $output == "ARRAY_A" || $output == "ARRAY_N" )
		{
			if ( self::$last_result )
			{
				$i=0;
				foreach( self::$last_result as $row )
				{

					$new_array[$i] = get_object_vars($row);

					if ( $output == "ARRAY_N" )
					{
						$new_array[$i] = array_values($new_array[$i]);
					}

					$i++;
				}

				return $new_array;
			}
			else
			{
				return null;
			}
		}
	}
	// ==================================================================
	//	Get one variable from the DB - see docs for more detail

	public static function get_var($query=null,$x=0,$y=0)
	{

		// Log how the function was called
		self::$func_call = "\$db->get_var(\"$query\",$x,$y)";

		// If there is a query then perform it if not then use cached results..
		if ( $query )
		{
		//	print "[".$query . "]";
			self::$instance->query($query);
		}

		// Extract var out of cached results based x,y vals
		if ( self::$last_result[$y] )
		{
			$values = array_values(get_object_vars(self::$last_result[$y]));
		}

		// If there is a value return it else return null
		return (isset($values[$x]) && $values[$x]!=='')?$values[$x]:null;
	}

	// ==================================================================
	//	Get one row from the DB - see docs for more detail

	function print_error($str = "")
	{

		// All erros go to the global error array $EZSQL_ERROR..
		global $EZSQL_ERROR;

		// If no special error string then use mysql default..
		if ( !$str ) $str = mysqli_error(self::$pripojeni);

		// Log this error to the global array..
		$EZSQL_ERROR[] = array
						(
							"query" => self::$last_query,
							"error_str"  => $str
						);
		require_once(PATH_ROOT . "core/controller/ProtokolController.php");
		//	$protokolController = new ProtokolController();
		//" . mysql_error() . "
		//$protokolController->setProtokol("SQL error"," [" . self::$last_query . "]");


		$protokolController = new ProtokolController();
		//" . mysql_error() . "
		$protokolController->setProtokol("SQL error"," [" . self::$last_query . "]");

		// Is error output turned on or not..
		if ( self::$show_errors )
		{
			// If there is an error then take note of it
			print "<blockquote><font face=arial size=2 color=ff0000>";
			print "<strong>SQL/DB Error --</strong> ";
			print "[<font color=000077>" . $str . "</font>]";
			print "</font></blockquote>";
		}
		else
		{
			return false;
		}
	}

	public static function get_row($query=null,$output="OBJECT",$y=0)
	{

		// Log how the function was called
		self::$func_call = "\$db->get_row(\"$query\",$output,$y)";

		// If there is a query then perform it if not then use cached results..
		if ( $query )
		{
			self::$instance->query($query);
		}

		// If the output is an object then return object using the row offset..
		if ( $output == "OBJECT" )
		{
			return self::$last_result[$y]?self::$last_result[$y]:null;
		}
		// If the output is an associative array then return row as such..
		elseif ( $output == "ARRAY_A" )
		{
			return self::$last_result[$y]?get_object_vars(self::$last_result[$y]):null;
		}
		// If the output is an numerical array then return row as such..
		elseif ( $output == "ARRAY_N" )
		{
			return self::$last_result[$y]?array_values(get_object_vars(self::$last_result[$y])):null;
		}
		// If invalid output type was specified..
		else
		{
			self::$instance->print_error(" \$db->get_row(string query, output type, int offset) -- Output type must be one of: OBJECT, ARRAY_A, ARRAY_N");
		}

	}

	///////////////////

	public static function getPrimary() {

		if (is_array(self::$_primary)) {

			return self::$_primary[1];
		} else {

			return self::$_primary;
		}
	}

	public static function getRowsAffected() {



			return self::$rows_affected;

	}

	public static function getRow($select)
	{
		if (is_numeric($select)) {
			$query = "select * from " . self::$_name . " where " . self::$_primary . " = " . $select . " LIMIT 1";
		}else {
			$query = $select;
		}

		//print $query;
		return self::$instance->get_row($query);
	}
	public static function setTableName($name) {

		//print "Nastavuju:".$name;
		self::$_name = $name;
	}
	public static function getTableName() {

		return self::$_name;
	}
	public static function setData($data)
	{
		//print_r($data);
		self::$_data = $data;
	}

	public static function setOrderBy($order,$default=''){

		$order = !empty($order) ?  $order : $default;

		self::$_orderBy = !empty($order) ?  "ORDER BY " . $order : "";
	}
	public static function getOrderBy(){

		return self::$_orderBy;
	}

	public static function setGroupBy($group){
		self::$_groupBy = !empty($group) ?  "GROUP BY " . $group : "";
	}
	public static function getGroupBy(){

		return self::$_groupBy;
	}

	public static function getValue()
	{
		$sql = "SELECT "
			. self::$instance->getSelect() . " FROM "
			. self::$instance->getFrom() . " "
			. self::$instance->getWhere() . " "
			. self::$instance->getGroupBy() . " "
			. self::$instance->getOrderBy() . " "
			. self::$instance->getLimit();

		$value = self::$instance->get_var($sql);
		self::$instance->clearWhere();

		return $value;

	}
	public static function getRows(){

		if (self::$benchmark) {
			$start_sql = explode(" ", microtime());
			$start_sql = $start_sql[1] + $start_sql[0];
		}


		$sql = ""
			. self::$instance->getSelect() . " "
			. self::$instance->getFrom() . " "
			. self::$instance->getWhere() . " "
			. self::$instance->getGroupBy() . " "
			. self::$instance->getOrderBy() . " "
			. self::$instance->getLimit();
		//	print $sql . "<br />";
		$list = self::$instance->get_results($sql);

		if (self::$benchmark) {
			$end_sql = explode(" ", microtime());
			$end_sql = $end_sql[1] + $end_sql[0];
			$rd = "10000"; // zaokrouhlování
			print "=== Start BenchMark ===<br />";
			print "Duration: " . ((round((($end_sql) - $start_sql) * $rd)) / $rd) . "sec<br />";
			print self::$instance->getLastQuery() . "<br />=== End BenchMark ===<br />";
		}


		self::$instance->clearWhere();
		self::$instance->clearGroupBy();
		return $list;

		/*
		$end_app = explode(" ", microtime());
		$rd = "10000"; // zaokrouhlování
		echo ((round((($end_app[1] + $end_app[0]) - START_APPLICATION) * $rd)) / $rd) . "sec";
		*/

	}
	public static function getLimit(){

		return self::$_limit;
	}
	public static function setLimit($page = 1, $limit = DEFAULT_LIMIT){

		$offset = ($page -1 ) * $limit;

		self::$_limit = "LIMIT " . $offset . ", " . $limit;
	}
	public static function addData($key, $value)
	{
		self::$_data[$key] = $value;
	}




	public static function clearWhere()
	{
		self::$_where = array();

		self::$_select = "";
		self::$_from = "";
		//self::$_where = array();
		self::$_orderBy = "";
		self::$_limit = "";
		//self::$_name = "";
		//self::$_groupBy = "";
	}
	public static function clearGroupBy()
	{
		self::$_groupBy = "";
	}
	/*
	public static function getWhere()
	{
		$sql = "";
		$whr = "";
		foreach self::$_where as $value) {
			$sql .="({$value})AND";
		}
		if (substr($sql, -3) =="AND"){
			$sql = substr($sql,0,strLen($sql)-3);
		}
		if (!empty($sql)) {
			$whr =" WHERE " . $sql;
		}

		return $whr;
	}
	*/
	public static function update()
	{
		$sql = "UPDATE `" . self::$instance->getTableName() . "` SET ";
		//print_r($this->_data);
		foreach (self::$_data as $key => $value) {
			if ($key !== self::$instance->getPrimary() ) {
				$sql .="`" . $key . "` = '" . $value . "',";
			}
		}
		if (substr($sql, -1) ==","){
			$sql = substr($sql,0,strLen($sql)-1);
		}
		$sql .=",`ChangeTimeStamp`=now()";
		$sql .=" WHERE `" . self::$instance->getPrimary() . "` = '" . self::$_data[self::$instance->getPrimary()] . "'";
		self::$instance->query($sql);

		//	print $sql;
		if (self::$rows_affected ==1){
			return true;
		}

	}

	public static function insert($data = null)
	{
		$sql = "INSERT `" . self::$instance->getTableName() . "` SET ";

		if (is_array($data)) {
			self::$_data = $data;
		}
		//	print_r($this->_data);
		foreach (self::$_data as $key => $value) {
			// možnost podhodit vlastní klíč
			//if ($key !== $this->getPrimary() ) {
			$value = self::$instance->escape($value);
			$sql .="`" . $key . "` = '" . $value . "',";
			//}
		}
		if (substr($sql, -1) ==","){
			$sql = substr($sql,0,strLen($sql)-1);
		}
		//$fields = substr($fields, 0, -1);
		$sql .= ",`TimeStamp`=now(),`ChangeTimeStamp`=now()";
		self::$instance->query($sql);

		//print $sql;
		if (self::$insert_id > 0){
			return self::$insert_id;
		}

	}
	/**
	 * Aktualizuje záznamy v databázi
	 * @param String název tabulky
	 * @param array pole změn sloupec => hodnota
	 * @param String podmínka
	 * @return bool
	 */
	public static function updateRecords( $table, $changes, $condition )
	{

		if (count($changes) > 0) {
			$update = "UPDATE `" . $table . "` SET ";

			foreach( $changes as $field => $value )
			{

				//print $field . ":" . is_null($value);
				//exit;

				//print $field . ":" . is_null($value);
				if (substr($value, 0, 1) == "{" && substr($value, strLen($value)-1, 1) == "}" ) {

					$value = self::$instance->escape($value);
					$value = substr($value, 0, -1);

					$value = substr($value, 1, strLen($value));
					$update .= "`" . $field . "`={$value},";

				} else {
					if (($value == "NULL" || is_null($value))  && !isInt($value)) {
						$update .= "`" . $field . "`=NULL,";
					} else {
						$value = self::$instance->escape($value);
						$update .= "`" . $field . "`='{$value}',";
					}
				}

			}

			// remove our trailing ,
			$update = substr($update, 0, -1);
			if (!empty($update)) {
				$update .= ",";

			}

			$update .="`ChangeTimeStamp`=now()";



			if( $condition != '' )
			{
				$update .= " WHERE " . $condition;
			}

			//print $update;
			return self::$instance->query( $update );
		}





		//return true;

	}

	public static function deleteRecords( $table, $condition )
	{
		$delete = "DELETE from `" . $table . "` ";
		if( $condition != '' )
		{
			$delete .= " WHERE " . $condition;
		}
		//print $update;
		return self::$instance->query( $delete );

		//return true;

	}

	/**
	 * Vloží záznam do databáze
	 * @param String název tabulky
	 * @param array pole dat sloupec => hodnota
	 * @return bool
	 */
	public static function insertRecords( $table, $data )
	{
		// setup some variables for fields and values
		$fields  = "";
		$values = "";

		if (!is_array($data)) {
			$data = array();
		}
		if (count($data) > 0) {


			// vyplnění proměnných
			foreach ($data as $f => $v)
			{



				$gnorujPolozkyNull = false;
				// hodnotu "0" bral jako NULL !
				if (($v == "NULL" || is_null($v)) && !isInt($v)) {

					//&& $v != 0
					if ($f != "TimeStamp" && $f != "ChangeTimeStamp" ) {
						$values .= "NULL,";
					} else {
						$gnorujPolozkyNull = true;
					}
					//print $f . " = " . is_int($v) . "<br />";

				} else {

					$v = self::$instance->escape($v);
					$values .= ( is_numeric( $v ) && ( intval( $v ) == $v ) ) ? $v."," : "'$v',";
				}

				if (!$gnorujPolozkyNull) {
					$fields  .= "`$f`,";
				} else {
					unset($data[$f]);
				}



			}
			if (!empty($fields)) {
				// odstranění koncového znaku „,“
				$fields = substr($fields, 0, -1);
				// odstranění koncového znaku „,“
				$values = substr($values, 0, -1);
			}
		}

		// upraveno pro podporu při Upsize
		if (!array_key_exists("TimeStamp", $data)) {
			//	if (!isset($data["TimeStamp"])) {
			if (!empty($fields)) {
				$fields .= ",";
				$values .=",";
			}
			$fields .= "`TimeStamp`";
			$values .="now()";
		}
		if (!array_key_exists("ChangeTimeStamp", $data)) {
			//	if (!isset($data["ChangeTimeStamp"])) {
			$fields .= ",`ChangeTimeStamp`";
			$values .=",now()";
		}
		//$fields .= ",`TimeStamp`,`ChangeTimeStamp`";



		//$values .=",now(),now()";
		$insert = "INSERT INTO `$table` ({$fields}) VALUES({$values})";
		//	print $insert;
		return self::$instance->query( $insert );
		//return true;
	}
	public static function insertData($table, $data = array())
	{
		$sql = "INSERT `" . $table . "` SET ";
		//print_r($this->_data);
		foreach ($data as $key => $value) {
			//if ($key !== $this->getPrimary() ) {
			$sql .="`" . $key . "` = '" . $value . "',";
			//	}
		}
		if (substr($sql, -1) ==","){
			$sql = substr($sql,0,strLen($sql)-1);
		}
		self::$instance->query($sql);

		//print $sql;
		if (self::$insert_id > 0){
			return self::$insert_id;
		}

	}
	public static function delete($id=null)
	{
		if ($id == null) {
			return self::$instance->query("delete from " . self::$instance->getTableName() . self::$instance->getWhere());
		}
		if (is_numeric($id)) {
			$query ="delete from " . self::$instance->getTableName() . " where " . self::$_primary . " = " . $id;
			//	print $query;
			return self::$instance->query($query);
		}
	}
}
?>
