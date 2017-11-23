<?php namespace Sircamp\Xenapi\Connection;

use GuzzleHttp\Client;
use Respect\Validation\Validator;
use Sircamp\Xenapi\Exception\XenConnectionException;
use Sircamp\Xenapi\Exception\XenException;

class XenConnection
{


	private $url;
	private $session_id;
	private $user;
	private $password;

	public static $debug = false;

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
	 * @return String
	 */
	public function getUrl()
	{
		return $this->url;
	}

	/**
	 * Sets the value of url.
	 *
	 * @param String $url
	 *
	 * @return $this
	 */
	private function _setUrl(String $url)
	{
		$this->url = $url;

		return $this;
	}

	/**
	 * Gets the value of session_id.
	 *
	 * @return String
	 */
	public function getSessionId()
	{
		return $this->session_id;
	}

	/**
	 * Sets the value of session_id.
	 *
	 * @param String $session_id
	 *
	 * @return $this
	 */
	private function _setSessionId(String $session_id)
	{
		$this->session_id = $session_id;

		return $this;
	}

	/**
	 * @return String
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * Sets the value of user.
	 *
	 * @param String $user
	 *
	 * @return $this
	 */
	private function _setUser(String $user)
	{
		$this->user = $user;

		return $this;
	}

	/**
	 * Sets the value of password.
	 *
	 * @param String $password
	 *
	 * @return $this
	 */
	private function _setPassword(String $password)
	{
		$this->password = $password;

		return $this;
	}

	/**
	 * Sets all values of object.
	 *
	 * @param String $url
	 * @param String $session_id
	 * @param String $user
	 * @param String $password
	 *
	 * @return XenConnection
	 */

	function _setAll(String $url, String $session_id, String $user, String $password)
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
	 * @param String $url
	 * @param String $user
	 * @param String $password
	 *
	 * @throws XenConnectionException
	 */

	function _setServer(String $url, String $user, String $password)
	{
		$rpc_method = $this->xenRPC_method('session.login_with_password', array($user, $password));
		$response   = $this->xenRPC_request($url, $rpc_method);

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
	 * This encode the request into a xml_rpc
	 *
	 *
	 * @param String $name
	 * @param array  $params
	 *
	 * @return String
	 */

	function xenRPC_method(String $name, array $params)
	{

		$encoded_request = xmlrpc_encode_request($name, $params);

		return $encoded_request;
	}


	/**
	 * This make the curl request for communication with xen
	 *
	 * @param String $url
	 * @param String $request
	 *
	 * @return mixed
	 */

	function xenRPC_request(String $url, String $request)
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
		return xmlrpc_decode((string) $body);
	}


	/**
	 * This parse the xml response and return the response obj
	 *
	 *
	 * @param array $response
	 *
	 * @return XenResponse
	 * @throws XenException
	 */

	function xenRPC_parse_response(array $response): XenResponse
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

					$response = $this->xenRPC_request($this->url, $this->xenRPC_method('session.login_with_password',
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
					throw new XenException($response['ErrorDescription'], 1);
				}
			}
		}


		return new XenResponse($response);
	}


	/**
	 * This handles every non-declared class method called on XenConnection
	 *
	 * @param String $name
	 * @param array  $args
	 *
	 * @return XenResponse
	 */

	public function __call(String $name, array $args = array()): XenResponse
	{
		if (!Validator::arrayType()->validate($args))
		{
			$args = array($args);
		}

		list($mod, $method) = explode('__', $name);

		$rpc_method   = $this->xenRPC_method($mod . '.' . $method, array_merge(array($this->getSessionId()), $args));
		$response     = $this->xenRPC_request($this->getUrl(), $rpc_method);
		$xen_response = $this->xenRPC_parse_response($response);

		return $xen_response;
	}



	/**
	 * Handles incoming regular call to the xen api and trows a XenException if the request fails
	 *
	 * @param string $name
	 * @param array  $args
	 *
	 * @return mixed
	 * @throws XenException
	 */
	public function call(string $name, array $args = array())
	{
		//Set the session to the first place
		array_unshift($args, $this->getSessionId());
		//Generate XenResponse
		$rpcMethod   = $this->xenRPC_method($name, $args);
		$response     = $this->xenRPC_request($this->getUrl(), $rpcMethod);
		$xenResponse = $this->xenRPC_parse_response($response);

		if(XenConnection::$debug){
			//Debug messages
			echo "Called: ".$name;
			echo " Value: ".$xenResponse->getValue();
			echo " Status: ".$xenResponse->getStatus();
			if(!empty($xenResponse->getErrorDescription())){
				echo " Error: ".print_r($xenResponse->getErrorDescription(), true)."\n";
			}else{
				echo "\n";
			}
		}

		//Test if the request was successful
		if (Validator::equals('Failure')->validate($xenResponse->getStatus()))
		{
			throw new XenException($xenResponse->getErrorDescription(), 1);
		}

		return $xenResponse->getValue();
	}

	/**
	 * The best practice is to logout the current user if session ends
	 */
	function __destruct()
	{
		//Only logout if we are logged in
		if(!isset($this->session_id)){
			return false;
		}
		$status = $this->__call('session__logout')->getStatus();

		return Validator::equals('Success')->validate($status);
	}

}

?>
