<?php

use RlyBadBB\Routing\EntryPoint;

require __DIR__ . '/../vendor/autoload.php';

$entry = new EntryPoint();

$entry->resolve();
