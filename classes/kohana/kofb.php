<?php defined('SYSPATH') or die('No direct script access.');

/**
* Kohana-Facebook
*
* @package        Kohana_Facebook
* @author         Jeremy Bush
* @copyright      (c) 2010 Jeremy Bush
* @license        http://www.opensource.org/licenses/isc-license.txt
*/
class Kohana_KOFB
{
	protected static $_instance;

	protected $_facebook;

	protected $_session;

	protected $_config;

	public $login_url;

	protected function __construct()
	{
		// Load config
		$this->_config = Kohana::$config->load('facebook');

		include Kohana::find_file('vendor', 'facebook/facebook');

		// Do class setup
		$this->_facebook = new Facebook(
			array(
				'appId'  => $this->_config->app_id,
				'secret' => $this->_config->secret,
				'cookie' => $this->_config->cookie,
			)
		);

		$this->_session = $this->_facebook->getSession();

	}

	public static function instance()
	{
		if ( ! isset(self::$_instance))
			Kohana_KOFB::$_instance = new Kohana_KOFB;

		return Kohana_KOFB::$_instance;
	}

	public function app_id()
	{
		return $this->_facebook->getAppId();
	}

	public function logged_in()
	{
		return $this->user_id() > 0;
	}

	public function user_id()
	{
		return $this->_facebook->getUser();
	}

	public function session()
	{
		return $this->_session;
	}

	public function get_api($params)
	{
		return $this->_facebook->api($params);
	}

	public function get($fields, $table, $key = NULL)
	{
		if ( ! $uid = $this->user_id())
		{
			$this->login_url();

			throw new Exception('User is not logged in.');
		}
		else
		{
			$fql_query  =   array(
				'method' => 'fql.query',
				'query' => 'SELECT '.$fields.' FROM '.$table.' WHERE uid = ' . $uid
			);

				$data = $this->get_api($fql_query);

			return (isset($key) ? $data[0][$key] : $data[0]);
		}
	}

	public function login_url()
	{
		return $this->login_url = $this->_facebook->getLoginUrl(
			array
			(
				'req_perms'		=> $this->_config->get('req_perms'),
				'next'			=> $this->_config->get('next'),
				'cancel_url'	=> $this->_config->get('cancel_url')
			));
	}

	public function facebook()
	{
		return $this->_facebook;
	}
}