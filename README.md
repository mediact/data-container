# Data Container

This package provides a data container. A data container can contain any data.
The data can be accessed using dot-notation.

# Data container factory

```php
<?php
use Mediact\DataContainer\DataContainerFactory;

$factory = new DataContainerFactory();

$container = $factory->create();
$container->set('some.path', 'some value');
$container->remove('some.unset.path');

print_r($container->get('some.path')); // some value
print_r($container->get('some.unset.path')); // null
print_r($container->get('some.unset.path', 'default value')); // default value

print_r($container->has('some.path')); // true
print_r($container->has('some.unset.path')); // false

print_r($container->glob('*.path')); // ['some.path']
```

# Branching data

In certain cases, the data container may hold nested structures with children,
of which the data structure is also preferred as a data container.

In that case, a branch can be used:

```php
<?php
/** @var \Mediact\DataContainer\DataContainerFactoryInterface $factory */
$container = $factory->create(
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
