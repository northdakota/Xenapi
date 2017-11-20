<?php namespace Sircamp\Xenapi;

use Respect\Validation\Validator;
use Sircamp\Xenapi\Connection\XenConnection;
use Sircamp\Xenapi\Connection\XenResponse;
use Sircamp\Xenapi\Element\XenHost;
use Sircamp\Xenapi\Element\XenNetwork;
use Sircamp\Xenapi\Element\XenStorageRepository;
use Sircamp\Xenapi\Element\XenVirtualMachine;

class Xen
{

	private $xenConnection = null;

	/*
	 * Implicit methods
	 *
	 * a constructor (usually called "create"); --> is implemented in the class
	 * a destructor (usually called "destroy"); --> is implemented in the class
	 * "get_record"; --> is implemented in the class
	 *
	 * "get_by_name_label";     --> is called getXXByNameLabel()
	 * "get_by_uuid"            --> is called getXXByUUid()
	 * "get_all".               --> is called getAllXX()
	*/


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
	 * @param String $name
	 *
	 * @return array
	 */
	public function getVMByNameLabel(String $name): array
	{
		$refArray = $this->xenConnection->__call('VM__get_by_name_label', [$name])->getValue();
		$vmArray  = array();

		foreach ($refArray as $refID)
		{
			$vmArray[] = new XenVirtualMachine($this->xenConnection, $refID);
		}

		return $vmArray;
	}

	/**
	 * Get a VM by its UUID
	 *
	 * @param String $uuid
	 *
	 * @return XenVirtualMachine
	 */
	public function getVMByUUID(String $uuid): XenVirtualMachine
	{
		$refID = $this->xenConnection->__call('VM__get_by_uuid', [$uuid])->getValue();

		return new XenVirtualMachine($this->xenConnection, $refID);
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
	 * Get Host from name.
	 *
	 * @param String $name
	 *
	 * @return array
	 */
	public function getHostByNameLabel(String $name): array
	{
		$refArray  = $this->xenConnection->__call('host__get_by_name_label', [$name])->getValue();
		$hostArray = array();

		foreach ($refArray as $refID)
		{
			$hostArray[] = new XenVirtualMachine($this->xenConnection, $refID);
		}

		return $hostArray;
	}

	/**
	 * Get a Host by its UUID
	 *
	 * @param String $uuid
	 *
	 * @return XenHost
	 */
	public function getHostByUUID(String $uuid): XenHost
	{
		$xenResponse = $this->xenConnection->__call('host__get_by_uuid', [$uuid]);
		$refID       = $xenResponse->getValue();

		return new XenHost($this->xenConnection, $refID);
	}

	/**
	 * Get all Hosts from the XenServer
	 *
	 * @return array
	 */
	public function getAllHosts(): array
	{
		$refIDs = $this->xenConnection->__call('host__get_all')->getValue();
		$vms    = array();
		foreach ($refIDs as $refID)
		{
			$vms[] = new XenHost($this->xenConnection, $refID);
		}

		return $vms;
	}

	/**
	 * Get Network from name.
	 *
	 * @param String $name
	 *
	 * @return array
	 */
	public function getNetworkByNameLabel(String $name): array
	{
		$refArray     = $this->xenConnection->__call('network__get_by_name_label', [$name])->getValue();
		$networkArray = array();

		foreach ($refArray as $refID)
		{
			$networkArray[] = new XenNetwork($this->xenConnection, $refID);
		}

		return $networkArray;
	}

	/**
	 * Get a Host by its UUID
	 *
	 * @param String $uuid
	 *
	 * @return XenNetwork
	 */
	public function getNetworkByUUID(String $uuid): XenNetwork
	{
		$xenResponse = $this->xenConnection->__call('network__get_by_uuid', [$uuid]);
		$refID       = $xenResponse->getValue();

		return new XenNetwork($this->xenConnection, $refID);
	}

	/**
	 * Get all Hosts from the XenServer
	 *
	 * @return array
	 */
	public function getAllNetworks(): array
	{
		$refIDs = $this->xenConnection->__call('network__get_all')->getValue();
		$vms    = array();
		foreach ($refIDs as $refID)
		{
			$vms[] = new XenNetwork($this->xenConnection, $refID);
		}

		return $vms;
	}

	/**
	 * Return a map of network references to network records for all networks known to the system.
	 *
	 * @return array records of all objects
	 */
	public function getAllNetworkRecords(): array
	{
		return $this->xenConnection->__call('network__get_all_records')->getValue();
	}

	/**
	 * Create a new network instance,
	 *
	 * @param array $network_record All constructor arguments
	 *
	 * @return XenNetwork The newly created XenNetwork
	 */
	private function _createNetwork(array $network_record = array())
	{
		$refID = $this->xenConnection->__call('network__create', [$network_record]);

		return new XenNetwork($this->xenConnection, $refID);
	}

//	public function createNetwork(String $name_label, String $name_description, int $MTU, array $other_config, String $bridge="",bool $managed=true,String $tags="")
//	{
//
//		return $this->_createNetwork()
//	}

	/**
	 * Get Network from name.
	 *
	 * @param String $name
	 *
	 * @return array
	 */
	public function getStorageRepositoryByNameLabel(String $name): array
	{
		$refArray     = $this->xenConnection->__call('SR__get_by_name_label', [$name])->getValue();
		$networkArray = array();

		foreach ($refArray as $refID)
		{
			$networkArray[] = new XenStorageRepository($this->xenConnection, $refID);
		}

		return $networkArray;
	}

	/**
	 * Get a Host by its UUID
	 *
	 * @param String $uuid
	 *
	 * @return XenStorageRepository
	 */
	public function getStorageRepositoryByUUID(String $uuid): XenStorageRepository
	{
		$xenResponse = $this->xenConnection->__call('SR__get_by_uuid', [$uuid]);
		$refID       = $xenResponse->getValue();

		return new XenStorageRepository($this->xenConnection, $refID);
	}

	/**
	 * Get all Hosts from the XenServer
	 *
	 * @return array
	 */
	public function getAllStorageRepositories(): array
	{
		$refIDs = $this->xenConnection->__call('SR__get_all')->getValue();
		$vms    = array();
		foreach ($refIDs as $refID)
		{
			$vms[] = new XenStorageRepository($this->xenConnection, $refID);
		}

		return $vms;
	}

	/**
	 * Return a map of network references to network records for all networks known to the system.
	 *
	 * @return array records of all objects
	 */
	public function getAllStorageRepositoryRecords(): array
	{
		return $this->xenConnection->__call('SR__get_all_records')->getValue();
	}
}

?>