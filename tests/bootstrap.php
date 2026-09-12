<?php

putenv('APP_ENV=testing');
putenv('DB_HOST=127.0.0.1');
putenv('DB_NAME=testing');
putenv('DB_USER=testing');
putenv('DB_PASSWORD=testing');

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/TestCase.php';
