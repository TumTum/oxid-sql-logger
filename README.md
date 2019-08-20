Oxid SQL Logger
---------------

Returns all SQL queries in the console browser.

## Install

composer require --dev tumtum/oxid-sql-logger

## Usage

```php
\StartSQLLog();

$db = \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC);
$list = $db->getAll('SELECT * FROM oxarticle WHERE oxprice < ? LIMIT 100', [49.99]);

\StopSQLLog();
```
