<?php
/**
 *  Modul:   ImportManager
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
 *  Manažer importu
 *
 */
class ImportManager
{
    /**
     * Vrací fiktivní manažer
     *
     */
    public static function ghost()
    {
        return ImportGhostManager::instance();
    }

    /**
     * Vrátí manažera, který používá k zřetězení knihovnu CURL
     *
     */
    public static function CURL()
    {
        return ImportCURLManager::instance();
    }

    /**
     * Vrátí manažera, který k zřetězení používá AJAX
     *
     */
    public static function AJAX()
    {
        return ImportAJAXManager::instance();
    }

    /**
     * Vrátí instanci manažera na základě konfiguračního souboru
     *
     */
    public static function instance()
    {
        if (ImportConfig::get('manager', 'one_step') == 'one_step')
           return ImportManager::ghost();

        elseif (strtoupper($manager=ImportConfig::get('manager')) == 'CURL')
           return ImportManager::CURL();

        elseif (strtoupper($manager=ImportConfig::get('manager')) == 'AJAX')
           return ImportManager::AJAX();

        else
           throw new Exception('Neznámý typ manažera importu ('.$manager.')!');
    }
}
