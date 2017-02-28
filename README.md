# Data Container

This package provides a data container. A data container can contain any data.
The data can be accessed using dot-notation.

## Interface synopsis

```php
<?php
DataContainerInterface {
    /**
     * Check whether a path exists.
     */
    public function has(string $path): bool;

    /**
     * Get a value of a path.
     */
    public function get(string $path, mixed $default = null): mixed;

    /**
     * Return a container with a value set on a path.
     */
    public function with(string $path, mixed $value = null): DataContainerInterface;

    /**
     * Return a container with a path removed.
     */
    public function without(string $path): DataContainerInterface;

    /**
     * Find paths that match a pattern.
     */
    public function glob(string $pattern): array;
}
```

## Examples

```php
<?php
$factory = new DataContainerFactory();

$container = $factory->createContainer()
    ->with('some.path', 'some value')
    ->without('some.unset.path');

print_r($container->get('some.path')); // some value
print_r($container->get('some.unset.path')); // null
print_r($container->get('some.unset.path', 'default value')); // default value

print_r($container->has('some.path')); // true
print_r($container->has('some.unset.path')); // false

print_r($container->glob('*.path')); // ['some.path']
```
