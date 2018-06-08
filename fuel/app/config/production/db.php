<?php
/**
 * The development database settings. These get merged with the global settings.
 */

return array(
    'default' => array(
        'type'	=> 'pdo',
        'connection'=> array(
            'dsn'		=> 'pgsql:host=localhost;dbname=yankiee_test',
            'username'	=> 'postgres',
            'password'	=> '4qualia',
        ),
        'charset'	=> NULL,
        'identifier' => "\"" /* for PostgreSQL */
    ),
);
