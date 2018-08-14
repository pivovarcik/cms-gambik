<?php


function daysToExpirateCms()
{
    $settings = G_Setting::instance();
    $date_diff = diff(date("Y-m-d H:i:s"), date("Y-m-d H:i:s",strtotime($settings->get("INSTALL_DATE"))+(365 * 24 * 3600)) );
    
    return $date_diff["day"];
}