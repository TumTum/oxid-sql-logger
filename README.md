Oxid eShop SQL Logger
---------------------

[![Build Status](https://travis-ci.org/TumTum/oxid-sql-logger.svg?branch=master)](https://travis-ci.org/TumTum/oxid-sql-logger)

Returns all SQL queries into console of a Browser.

## Install

`composer require --dev tumtum/oxid-sql-logger`

## Usage

Just set the function `StartSQLLog()` somewhere and from that point on all SQLs will be logged.

```php
\StartSQLLog();

$db = \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC);
$list = $db->getAll('SELECT * FROM oxarticles WHERE oxprice < ? LIMIT 100', [49.99]);

\StopSQLLog();
```

## Screenshots

Browser:

![Example only one range](https://raw.githubusercontent.com/TumTum/oxid-sql-logger/master/img/screenshot-b.png)

CLI:

![Example CLI](https://raw.githubusercontent.com/TumTum/oxid-sql-logger/master/img/screenshot-cli.png)

