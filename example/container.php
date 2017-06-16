<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Mediact\DataContainer\FileDataContainerFactory;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

require_once __DIR__ . '/../vendor/autoload.php';

// Create a factory for data containers based on files.
$factory = new FileDataContainerFactory(
    // Set up a file system.
    new Filesystem(
        // Use the adapter for local file systems.
        new Local(__DIR__)
    ),
    // Set up the JSON decoder.
    new JsonDecode(true),
    // Instruct the factory that incoming data is formatted as JSON.
    JsonEncoder::FORMAT
);

// Create a container based on the example.json file.
$container = $factory->createFromFile('example.json');

var_dump($container->get('foo.bar'));
