<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host='.$_ENV['DATABASE_HOST'].';port=5432;dbname='.$_ENV['DATABASE_NAME'],
    'username' => $_ENV['DATABASE_USER'],
    'password' => $_ENV['DATABASE_PASS'],
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
