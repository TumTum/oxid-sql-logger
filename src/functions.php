<?php
/**
 * Autor: Tobias Matthaiou <developer@tobimat.eu>
 * Date: 2019-08-20
 * Time: 23:11
 */

function StartSQLLog() {
    \tm\oxid\sql\logger\OxidEsalesDatabase::enableLogger();
}

function StopSQLLog() {
    \tm\oxid\sql\logger\OxidEsalesDatabase::disableLogger();
}
