# Data Container

This package provides a data container. A data container can contain any data.
The data can be accessed using dot-notation.

# Interface synopsis

```php
<?php
interface DataContainerInterface {
    /**
     * Check whether a path exists.
     */
    public function has(string $path): bool;

    /**
     * Get a value of a path.
     */
    public function get(string $path, mixed $default = null): mixed;
    
    /**
     * Branch into a list of data containers.
     */
    public function branch(string $path): array;

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

# Data container factory

```php
<?php
use Mediact\DataContainer\DataContainerFactory;

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

# File data container factory

In certain cases, it may be of use to create a data container based on the
contents of a given file name / URL.

A file data container factory supports encoded data from a flysystem URL:

```php
<?php
use Mediact\DataContainer\FileDataContainerFactory;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

/**
 * @var \League\Flysystem\FilesystemInterface $filesystem
 * @var \Symfony\Component\Serializer\Encoder\DecoderInterface $decoder
 */

$jsonFactory = new FileDataContainerFactory(
   $filesystem,
   $decoder,
   JsonEncoder::FORMAT
);

$container = $jsonFactory->createFromFile('storage://path/to/file.json');
```

If the contents of the `storage://path/to/file.json` JSON file are as follows:

```json
{
  "foo": {
    "bar": "baz"
  }
}
```

The following will be in the resulting data container:

```php
<?php
/** @var \Mediact\DataContainer\DataContainerInterface $container */

print_r($container->get('foo.bar')); // baz
```

# Branching data

In certain cases, the data container may hold nested structures with children,
of which the data structure is also preferred as a data container.

In that case, a branch can be used:

```php
<?php
/** @var \Mediact\DataContainer\DataContainerFactoryInterface $factory */
$container = $factory->createContainer(
    [
        'categories' => [
            'foo' => ['name' => 'Foo'],
            'bar' => ['name' => 'Bar']
        ]
    ]
);

foreach ($container->branch('categories.*') as $category) {
    var_dump($category->get('name'));
}
```
