<?php namespace Sircamp\Xenapi;

use Respect\Validation\Validator;
use Sircamp\Xenapi\Connection\XenConnection;
use Sircamp\Xenapi\Connection\XenResponse;
use Sircamp\Xenapi\Element\XenHost;
use Sircamp\Xenapi\Element\XenVirtualMachine;

class Xen
{

	private $xenConnection = null;

	/**
	 * Xen constructor.
	 *
	 * @param $url
	 * @param $user
	 * @param $password
	 */
	public function __construct($url, $user, $password)
	{
		if (!Validator::ip()->validate($url))
		{
			throw new \InvalidArgumentException("'url' value mast be an ipv4 address", 1);
		}
		if (!Validator::stringType()->validate($user))
		{
			throw new \InvalidArgumentException("'user' value mast be an non empty string", 1);
		}

		if (!Validator::stringType()->validate($password))
		{
			throw new \InvalidArgumentException("'password' value mast be an non empty string", 1);
		}

		$this->xenConnection = new XenConnection();
		try
		{
			$this->xenConnection->_setServer($url, $user, $password);
		}
		catch (\Exception $e)
		{
			die($e->getMessage());
		}
	}

	/**
	 * Get VM inside Hypervisor from name.
	 *
	 * @param mixed $name the name of VM
	 *
	 * @return mixed
	 */
	public function getVMByNameLabel($name): XenVirtualMachine
	{
		$refID = $this->xenConnection->__call('VM__get_by_name_label', [$name])->getValue();

		return new XenVirtualMachine($this->xenConnection, $refID);
	}

	/**
	 * Get HOST from name.
	 *
	 * @param mixed $name the name of HOST
	 *
	 * @return mixed
	 */
	public function getHostByNameLabel($name): XenHost
	{
		$response = new XenResponse($this->xenConnection->host__get_by_name_label($name));

		return new XenHost($this->xenConnection, $name, $response->getValue()[0]);
	}

	/**
	 * Get all VMs from the XenServer
	 *
	 * @return array
	 */
	public function getAllVMs(): array
	{
		$refIDs = $this->xenConnection->__call('VM__get_all')->getValue();
		$vms    = array();
		foreach ($refIDs as $refID)
		{
			$vms[] = new XenVirtualMachine($this->xenConnection, $refID);
		}

		return $vms;
	}

	/**
	 * Get a VM by its UUID
	 *
	 * @param $uuid
	 *
	 * @return XenVirtualMachine
	 */
	public function getVMByUUID($uuid)
	{
		$refID = $this->xenConnection->__call('VM__get_by_uuid', [$uuid])->getValue();

		return new XenVirtualMachine($this->xenConnection, $refID);
	}
}

?>