<?php

class Controller_Admin extends Controller_Template
{
	public $template = 'admin/template';

	protected $auth_group = null;
	protected $account_config = null;
	protected $current_user = null;

	public function before()
	{
		parent::before();

		\Config::load('account', true);
		$this->account_config = \Config::get('account');

		Asset::add_path('assets/', 'css');
		Asset::add_path('assets/', 'js');
		Asset::add_path('assets/', 'img');

		if (Request::active()->controller !== 'Controller_Admin' or ! in_array(Request::active()->action, array('login', 'logout')))
		{
			if (!$this->auth_check()) {
				Response::redirect('admin/login');
			}

			if (!$this->auth_group_check()) {
				Response::redirect('admin/404');
			}

			$this->current_user = $this->get_auth_user();
		}

		View::set_global('current_user', $this->current_user);

	}

	public function action_login()
	{
		// ログイン済みの場合リダイレクト
		$this->auth_check() and Response::redirect('admin');

		$val = Validation::forge();

		$errors = array();
		if (Input::method() == 'POST') {

			// バリデーションルールの設定(ログインID、PW必須)
			$val->add('login_user_id', 'ログインID')
			    ->add_rule('required');

			$val->add('password', 'パスワード')
			    ->add_rule('required');

			// バリデーションの実行
			if ($val->run()) {

				if ($this->auth_login(Input::post('login_user_id'), Input::post('password'))) {
					// ダッシュボードにリダイレクト
					Response::redirect('admin/dashboard');
				}
				else
				{
					$this->template->set_global('login_error', 'ログインIDまたはパスワードが間違っています。');
				}
			}

			$errors = $val->error();
		}


		$this->template->title = 'ログイン';
		$this->template->set_global('errors', $errors, false);
		$this->template->content = View::forge('admin/login');
	}

	/**
	 * The logout action.
	 *
	 * @access  public
	 * @return  void
	 */
	public function action_logout()
	{
		$this->auth_logout();
		Response::redirect('admin');
	}

	/**
	 * The index action.
	 *
	 * @access  public
	 * @return  void
	 */
	public function action_index()
	{
		// ダッシュボードにリダイレクト
		Response::redirect('admin/dashboard');
	}

	/**
	 * auth_check
	 *
	 * @access  private
	 * @return  void
	 */
	private function auth_login($login_user_id, $password)
	{
		if ( isset($this->account_config['users'][$login_user_id]) && $this->account_config['users'][$login_user_id]['password'] == md5($this->account_config['salt'].$password) ) {

			$loginUser = array();
			$loginUser['id'] = $login_user_id;
			$loginUser['name'] = $this->account_config['users'][$login_user_id]['name'];
			$loginUser['group'] = $this->account_config['users'][$login_user_id]['group'];

			Session::set($this->account_config['session_name'], $loginUser);
			return true;
		}
		return false;
	}

	/**
	 * auth_check
	 *
	 * @access  private
	 * @return  void
	 */
	private function auth_check()
	{
		return !is_null(Session::get($this->account_config['session_name']));
	}

	/**
	 * auth_group_check
	 *
	 * @access  private
	 * @return  void
	 */
	private function auth_group_check()
	{
		$result = true;

		if ( !$this->auth_check() ) return false;

		$account_config = $this->get_auth_user();

		if (!empty($this->auth_group)) {

			if (is_array($this->auth_group)) {
				array_search($account_config['group'], $this->auth_group) === false and $result = false;
			} else {
				$this->auth_group != $account_config['group'] and $result = false;
			}
		}

		return $result;
	}

	/**
	 * get_auth_user
	 *
	 * @access  private
	 * @return  void
	 */
	private function get_auth_user()
	{
		return Session::get($this->account_config['session_name']);
	}

	/**
	 * auth_logout
	 *
	 * @access  private
	 * @return  void
	 */
	private function auth_logout()
	{
		Session::delete($this->account_config['session_name']);
	}

}

/* End of file admin.php */
