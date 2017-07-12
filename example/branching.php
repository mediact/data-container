<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

use Mediact\DataContainer\DataContainerFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$factory = new DataContainerFactory();

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
