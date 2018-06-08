<?php
/**
 * アカウント設定ファイル
 */
return array(
		'session_name' => 'prod.login',
		'salt' => 'yankee',
		'users' => array(
			'admin' => array(
						'name' => '管理者',
						'password' => 'c61d1c0946889244393f4e8bec04fff4',
						'group' => 'admin'
					),
			'ne' => array(
						'name' => 'NEスタッフ',
						'password' => '07f82d894d76a813cd2ba73771dfde22',
						'group' => 'ne'
					),
			'4q' => array(
						'name' => '4Qスタッフ',
						'password' => '3d01fdd73e5cbe8bcebdc1ebd9434bae',
						'group' => '4q'
			),
		),
);