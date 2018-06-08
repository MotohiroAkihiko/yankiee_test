<?php
/**
 * The development database settings. These get merged with the global settings.
 */

return array(
	'default' => array(
		'type'	=> 'pdo',
		'connection'=> array(
			'dsn'		=> 'pgsql:host=localhost;dbname=yankee_test',
			'username'	=> 'postgres',
			'password'	=> '',
			),
		'charset'	=> NULL,
		'identifier' => "\"" /* for PostgreSQL */
	),
);
