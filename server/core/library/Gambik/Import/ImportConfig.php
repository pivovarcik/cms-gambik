<?php
/**
 *  Modul:   ImportConfig
 *
 *  @author  Aleš Hájek <ales-hajek@seznam.cz>
 *  @version 1.0
 *
 *  LICENCE:
 *
 *  NEVÝHRADNÍ LICENCE DLE AUTORSKÉHO ZÁKONA. KOPÍROVÁNI A MODIFIKACE BEZ VĚDOMÍ AUTORA
 *  JSOU ZAKÁZANY!
 *
 *  VYLOUČENÍ NÁHRADY ŠKODY: PROGRAM JE POSKYTOVÁN TAK JAK JE, AUTOR NEODPOVÍDÁ ZA ŽÁDNÉ
 *  AŤ UŽ DOMĚLÉ, ČI SKUTEČNÉ ŠKODY ZPǓSOBENÉ POUŽÍVÁNÍM PROGRAMU.
 *
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 *
 * Konfigurační soubor
 *
 */
class ImportConfig
{
    private static $__filename = 'import.cfg';
    private static $__params = NULL;

	/**
	 * Nastaví konfigurační soubor
	 *
	 * @param String $uri Cesta ke konfiguračnímu souboru
	 */
	public static function setFile($uri)
	{
		self::$__filename = $uri;
	}

    /**
     * Načte konfigurace
     *
     */
	public static function load()
    {
        if (file_exists(self::$__filename))
            self::$__params = parse_ini_file(self::$__filename);
        else
            self::$__params = array();
    }

    /**
     * Vrací konfigurační parametr
     *
     * @param string $name    Název parametru
     * @param object $default Implicitní hodnota parametru
     * @return object
     */
    public static function get($name, $default=NULL)
    {
        if (! self::$__params) ImportConfig::load();

        if (key_exists($name = strtolower($name), self::$__params))
            return self::$__params[$name];

        elseif (! is_null($default))
            return $default;

        else
            return NULL;
    }

    /**
     * Vrací deskriptor importu vytvořený z parametrů uložených
     * v konfiguračním souboru
     *
     * @return ImportDescriptor
     */
    public static function getDescriptor()
    {
        if (! self::$__params) ImportConfig::load();

        if (($format = ImportConfig::get('type', 'XML')) == 'CSV')
        {
            $descriptor = ImportDescriptor::CSV(
                ImportConfig::get('url'),
                ImportConfig::get('key_field'),
                ImportConfig::get('field', array())
            );
        }
        elseif ($format == 'XML')
        {
            $descriptor = ImportDescriptor::XML(
                ImportConfig::get('url'),
                ImportConfig::get('domain', array()),
                ImportConfig::get('filter', NULL)
            );
        }
        else
        {
            throw new Exception('Neznámý formát souboru ('.$format.')!');
        }
        return $descriptor;
    }
}
