<?php
/**
 *  Modul:   ImportDescriptor
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
 * Popisovač datového souboru
 *
 */
class ImportDescriptor
{
    public $source = '';
    public $reader = NULL;
    public $items = array();
    public $filter = NULL;

    /**
     * Vytvoří instanci popisovače CSV
     *
     * @param String $source     Url zdroje
     * @param String $key_field  Název položky se jménem
     * @param Array  $columns    Názvy polí CSV souboru
     */
    public static function CSV($source, $key_field, array $columns)
    {
        return new ImportDescriptor(
            $source, ImportCSVReader::instance($columns), array('CSV:'.$key_field)
        );
    }

    /**
     * Vytvoří instanci popisovače XML
     *
     * @param String $source     URL zdroje
     * @param String $item       Název tagu položky
     * @param String $filter     Filtr pro omezení výběru položek
     * @return ImportDescriptor
     */
    public static function XML($source, $items, $filter=NULL)
    {
        return new ImportDescriptor(
            $source, ImportXMLReader::instance(), $items, $filter
        );
    }

    /**
     * Ze zadané položky vybere klíč
     *
     * @param String $item Popis položky, cesta a klíč
     * @return String
     */
    public static function getItemKey($item)
    {
        return end(explode(':', $item));
    }

    /**
     * Ze zadané položky vybere cestu domény
     *
     * @param String $item Popis položky, cesta a klíč
     * @return String
     */
    public static function getItemDomain($item)
    {
        return reset(explode(':', $item));
    }

    /**
     * Konstruktor
     *
     * @param String $items      Specifikace položky (doména:klíčové_pole)
     * @param Object $reader     Reader
     * @param String $filter     Filtr pro omezení výběru položek
     * @return ImportDescriptor
     */
    private function __construct($source, $reader, $items, $filter=null)
    {
        $this->source = $source;
        $this->reader = $reader;
        $this->filter = $filter;
        $this->items = $items;
    }
}
