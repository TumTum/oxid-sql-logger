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

## SQL Query Status Monitor

![Example CLI](https://raw.githubusercontent.com/TumTum/oxid-sql-logger/master/img/sql-query-status-monitor.jpg)

See how many queries and which types of queries have been added to the database.
To determine the amount.

#### Switch on

For this purpose, the parameter `$this->blSQLStatusBox = true;` must be stored in the file `config.ing.php`.
So you can turn it on and off temporarily.

Unique: Insert, at the end, the Smarty tag: `[{tm_sql_status}]` in the `base.tpl` file.

####### source/Application/views/flow/tpl/layout/base.tpl

```html
        [{tm_sql_status}]
        </body>
    </html>
```
