<?php
/**
 * The PCARegistry object
 * Implements the Registry and Singleton design patterns
 * Building a PHP Ecommerce Framework
 *
 * @version 1.0
 * @author Michael Peacock
 */

class GambikFrameworkRegistry {

	/**
	 * pole objektů uložených v registru
	 * @access private
	 */
	private static $objects = array();

	/**
	 * pole nastavení uložených v registru
	 * @access private
	 */
	private static $settings = array();


	/**
	 * instance registru
	 * @access private
	 */
	private static $instance;

	private static $urlPath;
	private static $urlBits = array();

	/**
	 * Soukromý konstrutkor zabrání přímému vytvoření
	 * @access private
	 */
	private function __construct()
	{

	}

	/**
	 * metoda singleton pro přístup k objektu
	 * @access public
	 * @return
	 */
	public static function singleton()
	{
		if( !isset( self::$instance ) )
		{
			$obj = __CLASS__;
			self::$instance = new $obj;
		}

		return self::$instance;
	}

	/**
	 * zabrání kolonování objektu: vyvolá chybu E_USER_ERROR
	 */
	public function __clone()
	{
		trigger_error( 'Klonování registru není povoleno', E_USER_ERROR );
	}

	/**
	 * Uloží objekt do registru
	 * @param String $object název objektu
	 * @param String $key klíč do pole
	 * @return void
	 */
	public function storeObject( $object, $key )
	{
		if( strpos( $object, 'Sql' ) !== false )
		{
			$object_a = str_replace( '.database', 'database', $object);
			$object = str_replace( '.database', '', $object);
			require_once(PATH_ROOT . 'inc/' . $object . '.class.php');
			$object = $object_a;
		}
		else
		{
			require_once('objects/' . $object . '.class.php');
		}

		self::$objects[ $key ] = new $object( self::$instance );
	}

	/**
	 * Vrátí objekt z registru
	 * @param String $key klíč do pole použitý při uložení objektu
	 * @return object - objekt
	 */
	public function getObject( $key )
	{
		if( is_object ( self::$objects[ $key ] ) )
		{
			return self::$objects[ $key ];
		}
	}

	/**
	 * Uloží nastavení do registru
	 * @param String $data the setting we wish to store
	 * @param String $key klíč pro přístup k nastavení
	 * @return void
	 */
	public function storeSetting( $data, $key )
	{
		self::$settings[ $key ] = $data;
	}

	/**
	 * Vrátí nastavení z registru
	 * @param String $key klíč použitý pro uložení nastavení
	 * @return String nastavení
	 */
	public function getSetting( $key )
	{
		return self::$settings[ $key ];
	}


	/**
	 * Vrátí data z aktuální adresy URL
	 * @return void
	 */
	public function getURLData()
	{
		$urldata = (isset($_GET['page'])) ? $_GET['page'] : '' ;
		self::$urlPath = $urldata;
		if( $urldata == '' )
		{
			self::$urlBits[] = 'home';
			self::$urlPath = 'home';
		}
		else
		{
			$data = explode( '/', $urldata );
			//print_r($data);
			//exit;
			while ( !empty( $data ) && strlen( reset( $data ) ) === 0 )
			{
		    	array_shift( $data );
		    }
		    while ( !empty( $data ) && strlen( end( $data ) ) === 0)
		    {
		        array_pop($data);
		    }
			self::$urlBits = $this->array_trim( $data );
		}
	}

	public function redirectUser( $urlPath, $header, $message, $admin = false)
	{
		self::getObject('template')->buildFromTemplates('redirect.tpl.php');
		self::getObject('template')->getPage()->addTag( 'header', $header );
		self::getObject('template')->getPage()->addTag( 'message', $message );
		if( $admin != true )
		{
			self::getObject('template')->getPage()->addTag('url', $urlPath );
		}
		else
		{
			//
		}
	}

	public function getURLBits()
	{
		return self::$urlBits;
	}

	public function getURLBit( $whichBit )
	{
		return self::$urlBits[ $whichBit ];
	}

	public function getURLPath()
	{
		return self::$urlPath;
	}

	private function array_trim( $array )
	{
	    while ( ! empty( $array ) && strlen( reset( $array ) ) === 0)
	    {
	        array_shift( $array );
	    }

	    while ( !empty( $array ) && strlen( end( $array ) ) === 0)
	    {
	        array_pop( $array );
	    }

	    return $array;
	}

}

?>