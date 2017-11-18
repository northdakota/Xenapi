<?php namespace Sircamp\Xenapi\Element;

use Sircamp\Xenapi\Connection\XenConnection;


class XenElement
{

	private $xenConnection;


	function __construct(XenConnection $xenConnection)
	{
		$this->xenConnection = $xenConnection;
	}

	/**
	 * Gets the value of xenconnection.
	 *
	 * @return mixed
	 */
	public function getXenConnection(): XenConnection
	{
		return $this->xenConnection;
	}

	/**
	 * Sets the value of xenconnection.
	 *
	 * @param mixed $xenconnection the xenconnection
	 *
	 * @return self
	 */
	private function _setXenconnection($xenconnection)
	{
		$this->xenConnection = $xenconnection;

		return $this;
	}
}

?>