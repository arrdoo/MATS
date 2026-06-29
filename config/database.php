<?php
return [
    'host' => getenv('DB_HOST') ?: 'mysql',
    'port' => getenv('DB_PORT') ?: '3306',
    'dbname' => getenv('DB_NAME') ?: 'gestion_commerciale',
    'username' => getenv('DB_USERNAME') ?: 'root',
    'password' => getenv('DB_PASSWORD') ?: 'rootpassword',
];
