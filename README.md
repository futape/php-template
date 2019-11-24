# futape/php-template

This library offers a template engine, which uses PHP files as templates.

## Install

```bash
composer require futape/php-template
```

## Usage

**template.php**

```php
Hello <?php echo $name; ?>,

this is an usage example of futape/php-template.
Your installed PHP version is <?php echo PHP_VERSION; ?>.

Here's a list of all defined variables:

<?php
foreach (get_defined_vars() as $name => $value) {
    echo $name . ': ' . (string)$value . "\n";
}
?>
```

**renderer.php**

```php
use Futape\PhpTemplate\Template;

$template = (new Template('template.php'))
    ->addVariable('name', 'Stranger');

echo $template->render()
/* Hello Stranger,

this is an usage example of futape/php-template.
Your installed PHP version is 7.2.0.

Here's a list of all defined variables:

name: Stranger
... */
```

The template file is executed in its own variable scope and has access to the defined variables only, as well as
superglobals and variables made accessible via `global`.  
Moreover it can access constants and can utilize *any* PHP functionality you an use in other PHP files as well.

## Testing

The library is tested by unit tests using PHP Unit.

To execute the tests, install the composer dependencies (including the dev-dependencies), switch into the `tests`
directory and run the following command:

```bash
../vendor/bin/phpunit
```
