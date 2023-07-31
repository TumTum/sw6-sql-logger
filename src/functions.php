<?php
/**
 * Autor: Tobias Matthaiou <developer@tobimat.eu>
 * Date: 2019-08-20
 * Time: 23:11
 */

function StartSQLLog() {
    \tm\sw6\sql\logger\ShopwareConnectionConfiguration::enableLogger();
}

function StopSQLLog() {
    \tm\sw6\sql\logger\ShopwareConnectionConfiguration::disableLogger();
}
