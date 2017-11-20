<?php namespace Sircamp\Xenapi;

use Respect\Validation\Validator;
use Sircamp\Xenapi\Connection\XenConnection;
use Sircamp\Xenapi\Element\XenHost;
use Sircamp\Xenapi\Element\XenNetwork;
use Sircamp\Xenapi\Element\XenPhysicalInterface;
use Sircamp\Xenapi\Element\XenStorageRepository;
use Sircamp\Xenapi\Element\XenVirtualDiskImage;
use Sircamp\Xenapi\Element\XenVirtualInterface;
use Sircamp\Xenapi\Element\XenVirtualLAN;
use Sircamp\Xenapi\Element\XenVirtualMachine;
use Sircamp\Xenapi\Exception\XenException;

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


	//VirtualMachine
//	/**
//	 * NOT RECOMMENDED and not implemented use $vm->clone or $vm->copy
//	 */
//	public function createVirtualMachine()
//	{
//
//	}

	/**
	 * Return a list of all the VMs known to the system
	 *
	 * @return array
	 */
	public function getAllVirtualMachines(): array
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
	 * Return a array VMs and VM records for all VMs known to the system.
	 *
	 * @return array With the Form: [0 => ['vm' => vm_object, 'record'=> record_array]]
	 */
	public function getAllVirtualMachineRecords(): array
	{
		$map   = $this->xenConnection->__call('VM__get_all_records')->getValue();
		$vmMap = array();

		foreach ($map as $refID => $record)
		{
			$vm      = new XenVirtualMachine($this->xenConnection, $refID);
			$vmMap[] = ['vm' => $vm, 'record' => $record];
		}

		return $vmMap;
	}


	/**
	 * Get all the VM instances with the given label.
	 *
	 * @param String $name Label of the object to return
	 *
	 * @return array
	 */
	public function getVirtualMachineByNameLabel(String $name): array
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
	 * Get a the VM instance with the specified UUID.
	 *
	 * @param String $uuid UUID of the object to return
	 *
	 * @return XenVirtualMachine
	 */
	public function getVirtualMachineByUUID(String $uuid): XenVirtualMachine
	{
		$refID = $this->xenConnection->__call('VM__get_by_uuid', [$uuid])->getValue();

		return new XenVirtualMachine($this->xenConnection, $refID);
	}

	/**
	 * Import an XVA from a URI
	 *
	 * @param string               $url          The URL of the XVA file
	 * @param XenStorageRepository $sr           The destination SR for the disks
	 * @param bool                 $full_restore Perform a full restore
	 * @param bool                 $force        Force the import
	 *
	 * @return array
	 */
	public function importVirtualMachines(string $url, XenStorageRepository $sr, bool $full_restore = false, bool $force = false): array
	{
		$refIDs  = $this->xenConnection->__call('VM__import', [$url, $sr->getRefID(), $full_restore, $force])->getValue();
		$vmArray = array();

		foreach ($refIDs as $refID)
		{
			$vmArray[] = new XenVirtualMachine($this->xenConnection, $refID);
		}

		return $vmArray;
	}

	/**
	 * Import using a conversion service.
	 *
	 * @param string               $type          Type of the conversion
	 * @param string               $username      Admin username on the hst
	 * @param string               $password      Password on the host
	 * @param XenStorageRepository $sr            The destination SR
	 * @param array                $remote_config Remote configuration options
	 */
	public function importConvertVirtualMachines(string $type, string $username, string $password, XenStorageRepository $sr, array $remote_config = array())
	{
		$this->xenConnection->__call('VM__import_convert', [$type, $username, $password, $sr->getRefID(), $remote_config]);
	}

	//Host

	/**
	 * Return a list of all the hosts known to the system.
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
	 * Return a with Hosts and Hosts records for all VMs known to the system.
	 *
	 * @return array With the Form: [0 => ['host' => host_object, 'record'=> record_array]]
	 */
	public function getAllHostRecords()
	{
		$map       = $this->xenConnection->__call('VM__get_all_records')->getValue();
		$hostArray = array();

		foreach ($map as $refID => $record)
		{
			$host        = new XenHost($this->xenConnection, $refID);
			$hostArray[] = ['host' => $host, 'record' => $record];
		}

		return $hostArray;
	}

	/**
	 * Get all the host instances with the given label.
	 *
	 * @param String $name label of object to return
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
	 * Get the host instance with the specified UUID.
	 *
	 * @param String $uuid UUID of object to return
	 *
	 * @return XenHost
	 */
	public function getHostByUUID(String $uuid): XenHost
	{
		$xenResponse = $this->xenConnection->__call('host__get_by_uuid', [$uuid]);
		$refID       = $xenResponse->getValue();

		return new XenHost($this->xenConnection, $refID);
	}

	//TODO: methods like local_management_reconfigure, management_disable, management_reconfigure

	/**
	 * Shuts the agent down after a 10 second pause. WARNING: this is a dangerous operation.
	 * Any operations in progress will be aborted, and unrecoverable data loss may occur.
	 * The caller is responsible for ensuring that there are no operations in progress when this method is called.
	 */
	public function shutdownAgent()
	{
		$this->xenConnection->__call('host__shutdown_agent');

	}

	//Network

	/**
	 * Create a new network instance, and return its handle.
	 * The args are: name_label, name_description, MTU, other_config*, bridge, managed, tags (* = non-optional).
	 *
	 * @param string $name_label
	 * @param string $name_description
	 * @param int    $MTU
	 * @param array  $other_config
	 * @param string $bridge
	 * @param bool   $managed
	 * @param array  $tags
	 *
	 * @return XenNetwork
	 */
	public function createNetwork(string $name_label, string $name_description = "", int $MTU = 1500, array $other_config = array(), string $bridge = '', bool $managed = true, array $tags = array())
	{

		//Generate record
		if (!array_key_exists('automatic', $other_config))
		{
			$other_config['automatic'] = 'false';
		}

		$record = compact('name_label', 'name_description', 'MTU', 'other_config', 'bridge', 'managed', 'tags');

		$xenResponse = $this->xenConnection->__call('network__create', [$record]);
		$refID       = $xenResponse->getValue();

		return new XenNetwork($this->xenConnection, $refID);
	}

	/**
	 * Return a array of all the networks known to the system.
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
	 * Return an array with networks and network records for all networks known to the system.
	 *
	 * @return array With the Form: [0 => ['network' => network_object, 'record'=> record_array]]
	 */
	public function getAllNetworkRecords(): array
	{
		$map          = $this->xenConnection->__call('network__get_all_records')->getValue();
		$networkArray = array();

		foreach ($map as $refID => $record)
		{
			$network        = new XenNetwork($this->xenConnection, $refID);
			$networkArray[] = ['network' => $network, 'record' => $record];
		}

		return $networkArray;
	}

	/**
	 * Get all the network instances with the given label.
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
	 * Get the network instance with the specified UUID.
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

	//VirtualLAN

	/**
	 * Create a VLAN mux/demuxer
	 *
	 *
	 * @param XenPhysicalInterface $xenPIF     PIF which receives the tagged traffic
	 * @param int                  $tag        VLAN tag to use
	 * @param XenNetwork           $xenNetwork Network to receive the untagged traffic
	 *
	 * @return XenVirtualLAN
	 */
	public function createVirtualLAN(XenPhysicalInterface $xenPIF, int $tag, XenNetwork $xenNetwork): XenVirtualLAN
	{
		$refID = $this->xenConnection->__call('VLAN__create', [$xenPIF->getRefID(), $tag, $xenNetwork->getRefID()]);

		return new XenVirtualLAN($this->xenConnection, $refID);
	}

	/**
	 * Return a list of all the VLANs known to the system.
	 *
	 * @return array
	 */
	public function getAllVirtualLANs(): array
	{
		$refIDs = $this->xenConnection->__call('VLAN__get_all')->getValue();
		$vms    = array();
		foreach ($refIDs as $refID)
		{
			$vms[] = new XenVirtualLAN($this->xenConnection, $refID);
		}

		return $vms;
	}

	/**
	 * Return a array with VLANs and VLAN records for all VLANs known to the system.
	 *
	 * @return array With the Form: [0 => ['network' => network_object, 'record'=> record_array]]
	 */
	public function getAllVirtualLANRecords(): array
	{
		$map       = $this->xenConnection->__call('VLAN__get_all_records')->getValue();
		$vlanArray = array();

		foreach ($map as $refID => $record)
		{
			$vlan        = new XenVirtualLAN($this->xenConnection, $refID);
			$vlanArray[] = ['vlan' => $vlan, 'record' => $record];
		}

		return $vlanArray;
	}

	/**
	 * Get a reference to the VLAN instance with the specified UUID.
	 *
	 * @param String $uuid
	 *
	 * @return XenVirtualLAN
	 */
	public function getVirtualLANByUUID(String $uuid): XenVirtualLAN
	{
		$xenResponse = $this->xenConnection->__call('VLAN__get_by_uuid', [$uuid]);
		$refID       = $xenResponse->getValue();

		return new XenVirtualLAN($this->xenConnection, $refID);
	}


	//Storage Repositories

	public function createStorageRepository()
	{
		//TODO: implement
		throw new XenException(['Not implemented yet :('], 0);
	}

	/**
	 * Return a list of all the SRs known to the system.
	 *
	 * @return array All SRs
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
	 * Return an array with StorageRepositories and Storage Repositories records for all VMs known to the system.
	 *
	 * @return array With the Form: [0 => ['sr' => sr_object, 'record'=> record_array]]
	 */
	public function getAllStorageRepositoryRecords(): array
	{
		$map     = $this->xenConnection->__call('SR__get_all_records')->getValue();
		$srArray = array();

		foreach ($map as $refID => $record)
		{
			$sr        = new XenNetwork($this->xenConnection, $refID);
			$srArray[] = ['storageRepository' => $sr, 'record' => $record];
		}

		return $srArray;
	}

	/**
	 * Get all the SR instances with the given label.
	 *
	 * @param string $name label of object to return
	 *
	 * @return array with all SR matching the name label
	 */
	public function getStorageRepositoryByNameLabel(string $name): array
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
	 * Get the SR instance with the specified UUID.
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
	 * Return a set of all the SR types supported by the system
	 *
	 * @return array
	 */
	public function getSupportedStorageRepositoriesTypes(): array
	{
		return $this->xenConnection->__call('SR__get_supported_types')->getValue();
	}

	/**
	 * Introduce a new Storage Repository into the managed system
	 *
	 * @param array  $sm_config Storage backend specific configuration options
	 * @param string $name_label
	 * @param string $name_description
	 * @param string $type
	 * @param string $content_type
	 * @param bool   $shared
	 *
	 * @return XenStorageRepository
	 * @internal param string $uuid
	 */
	public function introduceStorageRepository(array $sm_config, string $name_label, string $name_description = '', string $type = 'nfs', string $content_type = '', bool $shared = true): XenStorageRepository
	{
		$xenResponse = $this->xenConnection->__call('SR__introduce', ['', $name_label, $name_description, $type, $content_type, $shared, $sm_config]);
		$refID       = $xenResponse->getValue();

		return new XenStorageRepository($this->xenConnection, $refID);
	}

	public function probeStorageRepository()
	{
		//TODO: implement
		throw new XenException(['Not implemented yet :('], 0);
	}

	//Virtual Disk Image

	public function createVirtualDiskImage()
	{
		//TODO: implement
		throw new XenException(['Not implemented yet :('], 0);
	}

	public function dbIntroduceVirtualDiskImage()
	{
		//TODO: implement
		throw new XenException(['Not implemented yet :('], 0);
	}

	/**
	 * Return a list of all the VDIs known to the system.
	 *
	 * @return array
	 */
	public function getAllVirtualDiskImages(): array
	{
		$refIDs = $this->xenConnection->__call('VDI__get_all')->getValue();
		$vdis   = array();
		foreach ($refIDs as $refID)
		{
			$vdis[] = new XenVirtualDiskImage($this->xenConnection, $refID);
		}

		return $vdis;
	}

	/**
	 * Return a array with VDIs and VDI records for all VDIs known to the system.
	 *
	 * @return array With the Form: [0 => ['vdi' => vdi_object, 'record'=> record_array]]
	 */
	public function getAllVirtualDiskImageRecords(): array
	{
		$map      = $this->xenConnection->__call('VDI__get_all_records')->getValue();
		$vdiArray = array();

		foreach ($map as $refID => $record)
		{
			$vlan       = new XenVirtualDiskImage($this->xenConnection, $refID);
			$vdiArray[] = ['vdi' => $vlan, 'record' => $record];
		}

		return $vdiArray;
	}

	/**
	 * Get a reference to the VDI instance with the specified UUID.
	 *
	 * @param String $uuid
	 *
	 * @return XenVirtualDiskImage
	 */
	public function getVirtualDiskImageByUUID(String $uuid): XenVirtualDiskImage
	{
		$xenResponse = $this->xenConnection->__call('VDI__get_by_uuid', [$uuid]);
		$refID       = $xenResponse->getValue();

		return new XenVirtualDiskImage($this->xenConnection, $refID);
	}

	public function introduceVirtualDiskImage()
	{
		//TODO: implement
		throw new XenException(['Not implemented yet :('], 0);
	}

	//Virtual Interface

	public function createVirtualInterface()
	{

	}

	/**
	 * Return a list of all the VDIs known to the system.
	 *
	 * @return array
	 */
	public function getAllVirtualInterfaces(): array
	{
		$refIDs = $this->xenConnection->__call('VIF__get_all')->getValue();
		$vdis   = array();
		foreach ($refIDs as $refID)
		{
			$vdis[] = new XenVirtualInterface($this->xenConnection, $refID);
		}

		return $vdis;
	}

	/**
	 * Return a array with VIFs and VIF records for all VIFs known to the system.
	 *
	 * @return array With the Form: [0 => ['vdi' => vdi_object, 'record'=> record_array]]
	 */
	public function getAllVirtualInterfaceRecords(): array
	{
		$map      = $this->xenConnection->__call('VIF__get_all_records')->getValue();
		$vifArray = array();

		foreach ($map as $refID => $record)
		{
			$vif        = new XenVirtualInterface($this->xenConnection, $refID);
			$vifArray[] = ['vif' => $vif, 'record' => $record];
		}

		return $vifArray;
	}

	/**
	 * Get a reference to the VIF instance with the specified UUID.
	 *
	 * @param String $uuid
	 *
	 * @return XenVirtualInterface
	 */
	public function getVirtualInterfaceByUUID(String $uuid): XenVirtualInterface
	{
		$xenResponse = $this->xenConnection->__call('VIF__get_by_uuid', [$uuid]);
		$refID       = $xenResponse->getValue();

		return new XenVirtualInterface($this->xenConnection, $refID);
	}
}

?>