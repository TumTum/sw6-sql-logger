Shopware SQL Logger
-------------------

Returns all SQL queries into console of a Browser or cli.

## Install

`composer require --dev tumtum/sw6-sql-logger`

## Usage

Just set the function `StartSQLLog()` somewhere and from that point on all SQLs will be logged.

```php
\StartSQLLog();

$result = $this->productRepository->search(new Criteria(['product.id']), $context);

\StopSQLLog();
```

## Usage with VarDumper::dump()

If you want to dump the SQLs into the `VarDumper::dump()` and put out the result into  a HTML file, you can use the following step:

##### Configure the Shopware 6 (one time):

```yaml
# config/packages/dev/debug.yml
debug:
    dump_destination: tcp://%env(VAR_DUMPER_SERVER)%
```

##### Start the VarDumper server:

```shell
./bin/console server:dump --format html > ./public/debug.html
```

open in Browser: http://local-shopware:8000/debug.html

##### Start the SQL logger:

```php
\StartSQLLog(useVarDumper: true);
```

## Usage with Ray

[Ray](https://myray.app/) is a powerful debugging tool for PHP developers. 


#####  Call in Ray Style:

```php
ray()->showQueries()

// This query will be displayed.
$this->productRepository->search(new Criteria(['product.id']), $context);

ray()->stopShowingQueries();

// This query won't be displayed.
$this->productRepository->search(new Criteria(['product.id']), $context);
```

Alternatively, you can pass a callable to showQueries. Only the queries performed inside that callable will be displayed in Ray. If you include a return type in the callable, the return value will also be returned.

```php
// This query won't be displayed.
$this->productRepository->search(new Criteria(['product.id']), $context);

ray()->showQueries(function() {
    // This query will be displayed.
    $this->productRepository->search(new Criteria(['product.id']), $context); 
});

$users = ray()->showQueries(function () {
    // This query will be displayed and the collection will be returned.
    return $this->productRepository->search(new Criteria(['product.id']), $context);
});

$this->productRepository->search(new Criteria(['product.id']), $context); // this query won't be displayed.
```

##### Call Classic

```php
#Classic
\StartSQLLog(useRayDumper: true);
```

To ensure Ray works correctly, you need to install the corresponding package:

```bash
composer require --dev spatie/ray
```

## Screenshots

CLI:

![Example CLI](https://raw.githubusercontent.com/TumTum/sw6-sql-logger/master/img/screenshot-cli.png)

