<?php

require __DIR__ . '/../../../../source/bootstrap.php';

\StartSQLLog();

$db = \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC);
$list = $db->getAll('SELECT * FROM oxarticles WHERE oxprice < ? LIMIT 100', [49.99]);

\StopSQLLog();
