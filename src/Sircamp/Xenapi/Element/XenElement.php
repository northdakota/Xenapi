<?php namespace Sircamp\Xenapi\Element;

use Sircamp\Xenapi\Connection\XenConnection;
use Sircamp\Xenapi\Exception\XenException;


abstract class XenElement
{

	protected $xenConnection;
	protected $refID;

	protected $async = false;
	protected $callPrefix;


	/**
	 * XenElement constructor.
	 *
	 * @param XenConnection $xenConnection
	 * @param String        $refID
	 */
	function __construct(XenConnection $xenConnection, String $refID)
	{
		$this->_setXenConnection($xenConnection)->_setRefID($refID);
	}

	/**
	 * @param String $name
	 * @param array  $args
	 *
	 * @return mixed
	 * @throws XenException
	 */
	public function call(String $name, array $args = array())
	{
		//Assign the refID of the VM
		array_unshift($args, $this->getRefID());

		$methodName = $this->callPrefix . '.' . $name;

		//Check if the request should be done asynchronos
		if($this->async){
			$methodName = "Async.".$methodName;
			//TODO: return a task object
			throw new XenException(["Not implemented yet!"], 1);
		}

		return $this->getXenConnection()->call($methodName, $args);
	}

	/**
	 * Assert something, this will throw an exception if the assert fails
	 * @param string $name
	 * @param array  $args
	 */
	public function assert(string $name, array $args=array())
	{
		$this->call('assert_'.$name, $args);
	}

	/**
	 * change the value of field X (only if it is read-write);
	 *
	 * @param String $X
	 * @param mixed $value
	 *
	 * @internal param String $name
	 */
	public function set(String $X, $value)
	{
		$this->call('set_'.$X, [$value]);
	}

	/**
	 * retrieve the value of field X;
	 *
	 * @param String $X
	 *
	 * @return mixed
	 */
	public function get(String $X)
	{
		return $this->call('get_'.$X);
	}

	/**
	 * add a key/value pair (only if field has type set or map)
	 *
	 * @param String $X
	 * @param String $key
	 * @param String $value
	 */
	public function addTo(String $X, String $key, String $value)
	{
		$this->call('add_to_' . $X, [$key, $value]);
	}

	/**
	 * remove a key (only if a field has type set or map)
	 *
	 * @param String $X
	 * @param String $key
	 */
	public function removeFrom(String $X, String $key)
	{
		$this->call('remove_from_'.$X, [$key]);
	}

	/**
	 * Gets the value of xenConnection.
	 *
	 * @return mixed
	 */
	public function getXenConnection(): XenConnection
	{
		return $this->xenConnection;
	}

	/**
	 * @return mixed
	 */
	public function getRefID()
	{
		return $this->refID;
	}

	/**
	 * Sets the value of xenConnection.
	 *
	 * @param mixed $xenConnection the xenConnection
	 *
	 * @return self
	 */
	private function _setXenConnection($xenConnection)
	{
		$this->xenConnection = $xenConnection;

		return $this;
	}

	/**
	 * @param mixed $refID
	 *
	 * @return XenElement
	 */
	private function _setRefID($refID)
	{
		$this->refID = $refID;

		return $this;
	}

}

?>