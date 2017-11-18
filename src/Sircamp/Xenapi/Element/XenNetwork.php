<?php namespace Sircamp\Xenapi\Element;

class XenNetwork extends XenElement
{

	private $name;
	private $networkId;

	public function __construct($xenConnection, $name, $networkId)
	{
		parent::__construct($xenConnection);
		$this->name      = $name;
		$this->networkId = $networkId;
	}

	/**
	 * Gets the value of name.
	 *
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Sets the value of name.
	 *
	 * @param mixed $name the name
	 *
	 * @return self
	 */
	private function _setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * Return a list of all the Networks known to the system.
	 *
	 * @param
	 *
	 * @return mixed
	 */
	public function getAll()
	{
		return $this->getXenConnection()->network__get_all();
	}
}

?>
	