<?php
/**
 * Autor: Tobias Matthaiou <developer@tobimat.eu>
 * Date: 2019-08-20
 * Time: 23:11
 */

function StartSQLLog(bool $useVarDumper = false) {
    \tm\sw6\sql\logger\ShopwareConnectionConfiguration::enableLogger(compact('useVarDumper'));
}

function StopSQLLog() {
    \tm\sw6\sql\logger\ShopwareConnectionConfiguration::disableLogger();
}
