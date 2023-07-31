Shopware SQL Logger
-------------------

Returns all SQL queries into console of a Browser or cli.

## Install

`composer require --dev tumtum/sw6-sql-logger`

## Usage

Just set the function `StartSQLLog()` somewhere and from that point on all SQLs will be logged.

```php
\StartSQLLog();

$criteria = new Criteria();
$result = $this->productRepository->search($criteria, Context::createDefaultContext());

\StopSQLLog();
```

## Screenshots

CLI:

![Example CLI](https://raw.githubusercontent.com/TumTum/sw6-sql-logger/master/img/screenshot-cli.png)

