<?php namespace Sircamp\Xenapi\Connection;

use GuzzleHttp\Client as Client;
use Respect\Validation\Validator as Validator;
use Sircamp\Xenapi\Exception\XenConnectionException as XenConnectionException;

class XenConnection
{


	private $url;
	private $session_id;
	private $user;
	private $password;

	function __construct()
	{

		$this->session_id = null;
		$this->url        = null;
		$this->user       = null;
		$this->password   = null;

	}

	/**
	 * Gets the value of url.
	 *
	 * @return mixed
	 */
	public function getUrl()
	{
		return $this->url;
	}

	/**
	 * Sets the value of url.
	 *
	 * @param mixed $url the url
	 *
	 * @return self
	 */
	private function _setUrl($url)
	{
		$this->url = $url;

		return $this;
	}

	/**
	 * Gets the value of session_id.
	 *
	 * @return mixed
	 */
	public function getSessionId()
	{
		return $this->session_id;
	}

	/**
	 * Sets the value of session_id.
	 *
	 * @param mixed $session_id the session id
	 *
	 * @return self
	 */
	private function _setSessionId($session_id)
	{
		$this->session_id = $session_id;

		return $this;
	}

	/**
	 * Gets the value of user.
	 *
	 * @return mixed
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * Sets the value of user.
	 *
	 * @param mixed $user the user
	 *
	 * @return self
	 */
	private function _setUser($user)
	{
		$this->user = $user;

		return $this;
	}

	/**
	 * Gets the value of password.
	 *
	 * @return mixed
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * Sets the value of password.
	 *
	 * @param mixed $password the password
	 *
	 * @return self
	 */
	private function _setPassword($password)
	{
		$this->password = $password;

		return $this;
	}

	/**
	 * Sets all values of object.
	 *
	 * @param       $url
	 * @param       $session_id
	 * @param       $user
	 * @param mixed $password the password, mixed $url the url,
	 *                        mixed $session_id the session_id and mixed 4user the user
	 *
	 * @return XenConnection
	 */

	function _setAll($url, $session_id, $user, $password)
	{

		$this->_setPassword($password);
		$this->_setSessionId($session_id);
		$this->_setUrl($url);
		$this->_setUser($user);

		return $this;
	}

	/**
	 * Sets and initialize xen server connection
	 *
	 * @param mixed $url the ip, mixed $user the user and mixed $password the password,
	 *
	 *
	 * @param       $user
	 * @param       $password
	 *
	 * @return XenResponse
	 * @throws XenConnectionException
	 */

	function _setServer($url, $user, $password)
	{
		$rpc_method = $this->xenrpc_method('session.login_with_password', array($user, $password));
		$response   = $this->xenrpc_request($url, $rpc_method);

		if (Validator::arrayType()->validate($response) && Validator::key('Status', Validator::equals('Success'))->validate($response))
		{

			$this->_setAll($url, $response['Value'], $user, $password);

		}
		else
		{

			throw new XenConnectionException("Error during contact Xen, check your credentials (user, password and ip)", 1);

		}
	}

	/**
	 * This parse the xml response and return the response obj
	 *
	 * @param mixed $response ,
	 *
	 *
	 * @return XenResponse
	 */

	function xenrpc_parseresponse($response): XenResponse
	{


		if (!Validator::arrayType()->validate($response) && !Validator::key('Status')->validate($response))
		{

			return new XenResponse($response);
		}
		else
		{

			if (Validator::key('Status', Validator::equals('Success'))->validate($response))
			{
				return new XenResponse($response);
			}
			else
			{

				if ($response['ErrorDescription'][0] == 'SESSION_INVALID')
				{

					$response = $this->xenrpc_request($this->url, $this->xenrpc_method('session.login_with_password',
						array($this->user, $this->password)));

					if (Validator::arrayType()->validate($response) && Validator::key('Status', Validator::equals('Success'))->validate($response))
					{
						$this->_setSessionId($response['Value']);
					}
					else
					{
						return new XenResponse($response);
					}
				}
				else
				{
					//TODO: add error handling
					return new XenResponse($response);

				}
			}
		}


		return new XenResponse($response);
	}


	/**
	 * This encode the request into a xml_rpc
	 *
	 * @param mixed $name the method name and mixed $params the arguments,
	 *
	 *
	 * @return mixed
	 */

	function xenrpc_method($name, $params)
	{

		$encoded_request = xmlrpc_encode_request($name, $params);

		return $encoded_request;
	}


	/**
	 * This make the curl request for communication with xen
	 *
	 * @param $url
	 * @param $request
	 *
	 * @return XenResponse
	 * @internal param mixed $usr the url and mixed $req the request,
	 *
	 *
	 */

	function xenrpc_request($url, $request)
	{

		$client = new Client();

		$response = $client->post($url,
			[

				'headers' => [
					'Content-type'   => 'text/xml',
					'Content-length' => strlen($request),
				],
				'body'    => $request,
				'timeout' => 60,
				'verify'  => false,

			]);

		$body = $response->getBody();
		$xml  = "";

		while (!$body->eof())
		{
			$xml .= $body->read(1024);
		}

		return xmlrpc_decode($xml);
	}


	/**
	 * This halde every non-declared class method called on XenConnectionObj
	 *
	 * @param mixed $name the name of method and $args the argument of method,
	 *
	 *
	 * @param array $args
	 *
	 * @return XenResponse
	 */

	function __call($name, $args = array()): XenResponse
	{
		if (!Validator::arrayType()->validate($args))
		{
			$args = array($args);
		}

		list($mod, $method) = explode('__', $name);

		$rpc_method   = $this->xenrpc_method($mod . '.' . $method, array_merge(array($this->getSessionId()), $args));
		$response     = $this->xenrpc_request($this->getUrl(), $rpc_method);
		$xen_response = $this->xenrpc_parseresponse($response);

		return $xen_response;
	}

}

?>
