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

## Usage with VarDumper::dump()

If you want to dump the SQLs into the `VarDumper::dump()` and put out the result into  a HTML file, you can use the following step:

Configure the Shopware 6 (one time):

```yaml
# config/packages/dev/debug.yml
debug:
    dump_destination: tcp://%env(VAR_DUMPER_SERVER)%
```

Start the VarDumper server:

```shell
./bin/console server:dump --format html > ./public/debug.html
```

open in Browser: http://local-shopware:8000/debug.html

Start the SQL logger:

```php
\StartSQLLog(useVarDumper: true);
```

## Screenshots

CLI:

![Example CLI](https://raw.githubusercontent.com/TumTum/sw6-sql-logger/master/img/screenshot-cli.png)

