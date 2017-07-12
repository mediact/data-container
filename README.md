# Data Container

This package provides a data container. A data container can contain any data.
The data can be accessed using dot-notation.

# Installation

```shell
$ composer require mediact/data-container
```

# Usage

## Creating a container

A container can be created directly or using a factory.

```php
<?php
use Mediact\DataContainer\DataContainer;
use Mediact\DataContainer\DataContainerFactory;

$data = [
    'categories' => [
        'foo' => ['name' => 'Foo'],
        'bar' => ['name' => 'Bar']
    ]
];

// Directly
$container = new DataContainer($data);

// Using a factory
$factory   = new DataContainerFactory();
$container = $factory->create($data);
```

## Checking whether a value has been set with has()

```php
<?php
/** @var Mediact\DataContainer\DataContainer $container */
var_dump($container->has('categories.foo')); // true
var_dump($container->has('categories.qux')); // false
```

## Getting a value with get()

```php
<?php
/** @var Mediact\DataContainer\DataContainer $container */
var_dump($container->get('categories.foo.name'));            // Foo
var_dump($container->get('categories.qux.name'));            // null
var_dump($container->get('categories.qux.name', 'Default')); // Default
```

## Setting a value with set()

```php
<?php
/** @var Mediact\DataContainer\DataContainer $container */
$container->set('categories.qux', ['name' => 'Qux']);
var_dump($container->get('categories.qux.name')); // Qux
```

## Removing a value with remove()

```php
<?php
/** @var Mediact\DataContainer\DataContainer $container */
$container->remove('categories.qux');
var_dump($container->has('categories.qux')); // false
```

The remove method also supports wildcards, for example `remove('bar.*')`;

## Getting paths that match a pattern with glob()

The glob method returns a list of paths that match the given pattern.

```php
<?php
/** @var Mediact\DataContainer\DataContainer $container */
var_dump($container->glob('categories.*'));      // ['categories.foo', 'categories.bar']
var_dump($container->glob('categories.ba?'));    // ['categories.bar']
var_dump($container->glob('categories.ba[zr]')); // ['categories.bar']
```

## Getting branches that match a pattern with branch()

The branch method returns the paths that are matched by a pattern as a list of
data containers.

```php
<?php
/** @var Mediact\DataContainer\DataContainer $container */
foreach ($container->branch('categories.*') as $category) {
    var_dump($category->get('name')); // Foo, Bar
}
```

## Copying data with copy()

```php
<?php
/** @var Mediact\DataContainer\DataContainer $container */
$container->copy('categories.foo', 'categories.qux');
var_dump($container->get('categories.qux')); // ['name' => 'Foo']
```

The copy method supports wildcards. The matches of the wildcards can be used
in the destination in a similar way as in preg_replace().

```php
<?php
/** @var Mediact\DataContainer\DataContainer $container */
$container->copy('categories.*', 'copied_categories.$1');
var_dump($container->get('copied_categories.foo')); // ['name' => 'Foo']
var_dump($container->get('copied_categories.bar')); // ['name' => 'Bar']
```

## Moving data with move()

```php
<?php
/** @var Mediact\DataContainer\DataContainer $container */
$container->move('categories.foo', 'categories.qux');
var_dump($container->has('categories.foo')); // false
var_dump($container->get('categories.qux')); // ['name' => 'Foo']
```

The move methods supports wildcards just like the copy method.

```php
<?php
/** @var Mediact\DataContainer\DataContainer $container */
$container->move('categories.*', 'moved_categories.$1');
var_dump($container->has('categories.foo'));       // false
var_dump($container->has('categories.bar'));       // false
var_dump($container->get('moved_categories.foo')); // ['name' => 'Foo']
var_dump($container->get('moved_categories.bar')); // ['name' => 'Bar']
```

# Creating a decorator

Decorators of a data container can be created using
`DataContainerDecoratorTrait`.

```php
<?php
use Mediact\DataContainer\DataContainer;
use Mediact\DataContainer\DataContainerInterface;
use Mediact\DataContainer\DataContainerDecoratorTrait;

class FooDataContainer implements DataContainerInterface
{
    use DataContainerDecoratorTrait;

    public function __construct(array $data = [])
    {
        $this->setData($data);
    }
}

class BarDataContainer implements DataContainerInterface
{
    use DataContainerDecoratorTrait;

    public function __construct(DataContainerInterface $storage = null)
    {
        $this->setStorage($storage ?: new DataContainer());
    }
}
```

Both implementations contain all methods of `DataContainerInterface`.
