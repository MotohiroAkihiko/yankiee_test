<?php
/**
 * アカウント設定ファイル
 */
return array(
		'session_name' => 'dev.login',
		'salt' => 'yankee',
		'users' => array(
			'admin' => array(
						'name' => '[DEV]管理者',
						'password' => '3f3b089d948c050de54d51c5346b6ddc',
						'group' => 'admin'
					),
			'ne' => array(
						'name' => '[DEV]NEスタッフ',
						'password' => '07f82d894d76a813cd2ba73771dfde22',
						'group' => 'ne'
					),
			'4q' => array(
						'name' => '[DEV]4Qスタッフ',
						'password' => '3f3b089d948c050de54d51c5346b6ddc',
						'group' => '4q'
			),
		),
);