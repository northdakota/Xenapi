<?php namespace Sircamp\Xenapi\Element;

use GuzzleHttp\Client;
use Respect\Validation\Validator;
use Sircamp\Xenapi\Connection\XenResponse;
use Sircamp\Xenapi\Exception\XenException;

class XenVirtualMachine extends XenElement
{

	protected $callPrefix = "VM";


	/**
	 * @deprecated
	 * @inheritdoc
	 */
//	private function create()
//	{
//	}

	/**
	 * It is a destructor for the server to destroy the vm
	 */
	public function destroy()
	{
		$this->call('destroy');
	}

	// API messages

	/**
	 * Add the given value to the tags field of the given VM. If the value is already in that Set, then do nothing.
	 *
	 * @param String $tag
	 */
	public function addTags(String $tag)
	{
		$xenResponse = $this->call('add_tags', [$tag]);
	}

	/**
	 * Add the given key-value pair to the HVM/boot_params field of the given VM.
	 *
	 * @param String $key
	 * @param String $value
	 */
	public function addToHVMBootParams(String $key, String $value)
	{
		$this->addTo('HVM_boot_params', $key, $value);
	}

	/**
	 * Add the given key-value pair to the VCPUs/params field of the given VM.
	 *
	 * @param String $key
	 * @param String $value
	 */
	public function addToVCPUsParams(String $key, String $value)
	{
		$this->addTo('VCPUs_params', $key, $value);
	}

	/**
	 * Add the given key-value pair to VM.VCPUs_params, and apply that value on the running VM
	 *
	 * @param String $key
	 * @param        $value
	 */
	public function addToVSPUsParamsLive(String $key, $value)
	{
		$this->addTo('VCPUs_params', $key, $value);
	}

	//TODO: Make enums

	/**
	 * Add the given key-value pair to the blocked_operations field of the given VM.
	 *
	 * @param String $vm_operations
	 * @param String $value
	 */
	public function addToBlockedOperations(String $vm_operations, String $value)
	{
		$this->addTo('blocked_operations', $vm_operations, $value);
	}

	/**
	 * Add the given key-value pair to the other_config field of the given VM.
	 *
	 * @param String $key
	 * @param String $value
	 */
	public function addToOtherConfig(String $key, String $value)
	{
		$this->addTo('other_config', $key, $value);
	}

	/**
	 * Add the given key-value pair to the platform field of the given VM.
	 *
	 * @param String $key
	 * @param String $value
	 */
	public function addToPlatform(String $key, String $value)
	{
		$this->addTo('platform', $key, $value);
	}

	/**
	 * Add the given key-value pair to the xenstore_data field of the given VM.
	 *
	 * @param String $key
	 * @param String $value
	 */
	public function addToXenstoreData(String $key, String $value)
	{
		$this->addTo('xenstore_data', $key, $value);
	}

	//TODO: implement assert messages

	/**
	 * Call a XenAPI plugin on this vm
	 *
	 * @param String $name
	 * @param String $fn
	 * @param array  $args
	 *
	 * @return string
	 * @throws XenException
	 */
	public function callPlugin(String $name, String $fn, array $args = array()): string
	{
		return $this->call('call_plugin', [$name, $fn, $args])->getValue();
	}

	/**
	 * Checkpoints the specified VM, making a new VM. Checkpoint automatically exploits the capabilities of the underlying storage repository in which the VM's disk images are stored (e.g. Copy on Write) and saves the memory image as well.
	 *
	 * @param String $name
	 *
	 * @return XenVirtualMachine
	 * @throws XenException
	 */
	public function checkpoint(String $name): XenVirtualMachine
	{
		$refID = $this->call('checkpoint', $name)->getValue();

		return new XenVirtualMachine($this->getXenConnection(), $refID);
	}


	/**
	 * Attempt to cleanly shutdown the specified VM (Note: this may not be supported---e.g. if a guest agent is not installed). This can only be called when the specified VM is in the Running state.
	 *
	 * Errors:    VM_BAD_POWER_STATE                You attempted an operation on a VM that was not in an appropriate power state at the time; for example, you attempted to start a VM that was already running. The parameters returned are the VM's handle, and the expected and actual VM state at the time of the call.
	 *            OTHER_OPERATION_IN_PROGRESS        Another operation involving the object is currently in progress
	 *            OPERATION_NOT_ALLOWED            You attempted an operation that was not allowed.
	 *            VM_IS_TEMPLATE                    The operation attempted is not valid for a template VM
	 *
	 * @throws XenException
	 */
	public function cleanReboot()
	{
		$this->call('clean_reboot');
	}


	/**
	 * Attempt to cleanly shutdown the specified VM. (Note: this may not be supported---e.g. if a guest agent is not installed). This can only be called when the specified VM is in the Running state.
	 *
	 * Errors:    VM_BAD_POWER_STATE            You attempted an operation on a VM that was not in an appropriate power state at the time; for example, you attempted to start a VM that was already running. The parameters returned are the VM's handle, and the expected and actual VM state at the time of the call.
	 *          OTHER_OPERATION_IN_PROGRESS    Another operation involving the object is currently in progress
	 *          OPERATION_NOT_ALLOWED        You attempted an operation that was not allowed.
	 *          VM_IS_TEMPLATE                The operation attempted is not valid for a template VM
	 */
	public function cleanShutdown()
	{
		$this->call('clean_shutdown');
	}

	/**
	 * Clones the specified VM, making a new VM. Clone automatically exploits the capabilities of the underlying storage repository in which the VM's disk images are stored (e.g. Copy on Write). This function can only be called when the VM is in the Halted State.
	 *
	 * @param String $name
	 *
	 * @return XenVirtualMachine
	 */
	public function clone(String $name): XenVirtualMachine
	{
		$refID = $this->call('clone', [$name])->getValue();

		return new XenVirtualMachine($this->getXenConnection(), $refID);
	}

	/**
	 * Computes the virtualization memory overhead of a VM.
	 *
	 * @return int
	 */
	public function computeMemoryOverhead(): int
	{
		return $this->call('compute_memory_overhead')->getValue();
	}

	/**
	 * Copied the specified VM, making a new VM. Unlike clone, copy does not exploits the capabilities of the underlying storage repository in which the VM's disk images are stored. Instead, copy guarantees that the disk images of the newly created VM will be 'full disks' - i.e. not part of a CoW chain. This function can only be called when the VM is in the Halted State.
	 *
	 * @param String                    $name
	 * @param XenStorageRepository|null $xenStorageRepository
	 *
	 * @return XenVirtualMachine
	 */
	public function copy(String $name, XenStorageRepository $xenStorageRepository = null): XenVirtualMachine
	{
		$refID = "";
		if (!is_null($xenStorageRepository))
		{
			$refID = $xenStorageRepository->getRefID();
		}

		$vmRefID = $this->call('copy', [$name, $refID])->getValue();

		return new XenVirtualMachine($this->xenConnection, $vmRefID);
	}


	/**
	 * Copy the BIOS strings from the given host to this VM
	 *
	 * @param XenHost $xenHost
	 */
	public function copyBiosStrings(XenHost $xenHost)
	{
		$this->call('copy_bios_strings', [$xenHost->getRefID()]);
	}

	//TODO implement create new blob

	/**
	 * Forget the recorded statistics related to the specified data source
	 *
	 * @param String $data_source
	 */
	public function forgetDataSourceArchives(String $data_source)
	{
		$this->call('forget_data_source_archives', [$data_source]);
	}


	//TODO: implement get methods


	public function hardReboot()
	{
		$this->call('hard_reboot');
	}

	public function hardShutdown()
	{
		$this->call('hard_shutdown');
	}

	public function import($url, XenStorageRepository $xenStorageRepository, bool $full_restore, bool $force)
	{
		$refIDs  = $this->call('import', [$url, $xenStorageRepository->getRefID(), $full_restore, $force])->getValue();
		$vmArray = array();

		foreach ($refIDs as $refID)
		{
			$vmArray[] = new XenVirtualMachine($this->getXenConnection(), $refID);
		}

	}


	public function importConvert(String $type, String $username, String $password, XenStorageRepository $xenStorageRepository, array $remote_config)
	{
		$this->call('import_convert', [$type, $username, $password, $xenStorageRepository->getRefID(), $remote_config]);
	}


	public function maximiseMemory(int $total, bool $approximate)
	{
		return $this->call('maximiseMemory', [$total, $approximate])->getValue();
	}

	//TODO: implement migrate_send
	public function migrateSend(array $dest, bool $live, array $vdi_map, array $vif_map, array $options, array $vgpu_map)
	{
		$refID = $this->call('migrate_send', [$dest, $live, $vdi_map, $vif_map, $options, $vgpu_map])->getValue();

		return new XenVirtualMachine($this->getXenConnection(), $refID);
	}


	public function pause()
	{
		$this->call('pause');
	}

	public function poolMigrate(XenHost $xenHost, array $options = array())
	{
		$this->call('pool_migrate', [$xenHost->getRefID(), $options]);
	}

	public function powerStateReset()
	{
		$this->call('power_state_reset');
	}

	public function provision()
	{
		$this->call('provision');
	}

	public function queryDataSource(String $data_source): float
	{
		return $this->call('query_data_source', [$data_source])->getValue();
	}

	public function queryServices(): array
	{
		//TODO: Check i this is a system domain
		return $this->call('query_services')->getValue();
	}


	//TODO: implement
	public function recover()
	{

	}

	//TODO: implement remove functions

	public function resume(bool $start_paused = false, bool $force = true)
	{
		$this->call('resume', [$start_paused, $force]);
	}

	public function resumeOn(XenHost $xenHost, bool $start_paused = false, bool $force = true)
	{
		$this->call('resume_on', [$xenHost->getRefID(), $start_paused, $force]);
	}

	//TODO implement retrieve_wlb_recommendations

	public function revert()
	{
		$this->call('revert');
	}

	public function sendSysrq(String $key)
	{
		$this->call('send_sysrq', [$key]);
	}

	public function sendTrigger(String $trigger)
	{
		$this->call('send_trigger', [$trigger]);
	}


	//TODO: Implement set messages

	public function shutdown()
	{
		$this->call('shutdown');
	}

	public function snapshot(String $name): XenVirtualMachine
	{
		$refID = $this->call('snapshot', [$name])->getValue();

		return new XenVirtualMachine($this->getXenConnection(), $refID);
	}

	public function snapshotWithQuiesce(String $name): XenVirtualMachine
	{
		$refID = $this->call('snapshot_with_quiesce', [$name])->getValue();

		return new XenVirtualMachine($this->getXenConnection(), $refID);
	}

	public function start(bool $start_pause = false, bool $force = true)
	{
		$this->call('start', [$start_pause, $force]);
	}

	public function startOn(XenHost $xenHost, bool $start_paused = false, bool $force = true)
	{
		$this->call('start_on', [$xenHost->getRefID(), $start_paused, $force]);
	}

	public function suspend()
	{
		$this->call('suspend');
	}

	public function unpause()
	{
		$this->call('unpause');
	}

	public function updateAllowedOperation()
	{
		$this->call('update_allowed_operations');
	}

	public function waitMemoryTargetLive()
	{
		$this->call('wait_memory_target_live');

	}

	/**
	 * Get the UUID of a VM .
	 *
	 * @param
	 *
	 * @return mixed
	 */
	public function getUUID()
	{
		return $this->getXenConnection()->VM__get_uuid($this->getRefID())->getValue();
	}

	/**
	 * Get name label VM.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getNameLabel()
	{
		return $this->getXenConnection()->VM__get_name_label($this->getRefID())->getValue();
	}


	public function getRecord(): array
	{
		return $this->call('get_record')->getValue();
	}


	public function getTags(): array
	{
		$xenResponse = $this->call('get_tags');
		$tags        = $xenResponse->getValue();

		return $tags;
	}

	public function getHVMBootParams()
	{
		$xenResponse = $this->call('get_HVM_boot_params');
		$value       = $xenResponse->getValue();
	}


	/**
	 * Assert whether a VM can be migrated to the specified destination.
	 *
	 * @param mixed $VM the uuid of VM,
	 *                  $def The result of a Host.migrate receive call.
	 *                  $live The Live migration
	 *                  $vdiMap of source VDI to destination SR
	 *                  $vifMap of source VIF to destination network
	 *                  $optionsMap  Extra configuration operations
	 *
	 * @return mixed
	 */
	public function assertCanMigrate($dest, $vdiMap, $vifMap, $options, $live = false)
	{
		return $this->getXenConnection()->VM__assert_can_migrate($this->getRefID(), $dest, $live, $vdiMap, $vifMap, $options);
	}


	/**
	 * Get the consoles instances a VM by passing her uuid.
	 *
	 * @param
	 *
	 * @return mixed
	 */
	function getConsoles()
	{
		return $this->getXenConnection()->VM__get_consoles($this->getRefID());
	}

	/**
	 * Get the console UIID of a VM by passing her uuid.
	 *
	 * @param mixed $CN the uuid of conosle of VM
	 *
	 * @return mixed
	 */
	function getConsoleUUID($CN)
	{
		return $this->getXenConnection()->console__get_uuid($CN);
	}

	/**
	 * Get th VM status by passing her uuid.
	 *
	 * @param mixed $VM the uuid of VM and $name the name of cloned vM
	 *
	 * @return mixed
	 */
	function getPowerState()
	{
		return $this->getXenConnection()->VM__get_power_state($this->getRefID());
	}


	/**
	 * Get the VM guest metrics by passing her uuid.
	 *
	 * @param mixed $VM the uuid of VM and $name the name of cloned vM
	 *
	 * @return mixed
	 */
	function getGuestMetrics()
	{
		$VMG = $this->getXenConnection()->VM__get_guest_metrics($this->getRefID());

		return $this->getXenConnection()->VM_guest_metrics__get_record($VMG->getValue());
	}

	/**
	 * Get the VM metrics by passing her uuid.
	 *
	 * @param mixed $VM the uuid of VM and $name the name of cloned vM
	 *
	 * @return mixed
	 */
	function getMetrics()
	{
		$VMG = $this->getXenConnection()->VM__get_metrics($this->getRefID());

		return $this->getXenConnection()->VM_metrics__get_record($VMG->getValue());
	}


	/**
	 * Get the VM stats by passing her uuid.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	function getStats()
	{

		$user     = $this->getXenConnection()->getUser();
		$password = $this->getXenConnection()->getPassword();
		$ip       = $this->getXenConnection()->getUrl();
		$uuid     = $this->getUUID($this->getRefID());

		$url = 'http://' . $user . ':' . $password . '@' . $ip . '/vm_rrd?uuid=' . $uuid->getValue() . '&start=1000000000‏';


		$client   = new Client();
		$response = $client->get($url);

		$body = $response->getBody();
		$xml  = "";

		while (!$body->eof())
		{
			$xml .= $body->read(1024);
		}

		$response = new XenResponse(array('Value' => array(0 => '')));

		if (Validator::string()->validate($xml))
		{
			$response = new XenResponse(array('Value' => $xml, 'Status' => 'Success'));
		}
		else
		{
			$response = new XenResponse(array('Value' => '', 'Status' => 'Failed'));
		}

		return $response;
	}

	/**
	 * Get the VM disk space by passing her uuid.
	 *
	 * @param mixe $size the currency of size of disk space
	 *
	 * @return XenResponse $response
	 */
	function getDiskSpace($size = null)
	{
		$VBD    = $this->getXenConnection()->VBD__get_all();
		$memory = 0;
		foreach ($VBD->getValue() as $bd)
		{
			$responsevm   = $this->getXenConnection()->VBD__get_VM($bd);
			$responsetype = $this->getXenConnection()->VBD__get_type($bd);

			if ($responsevm->getValue() == $this->getRefID() && $responsetype->getValue() == "Disk")
			{
				$VDI    = $this->getXenConnection()->VBD__get_VDI($bd);
				$memory += intval($this->getXenConnection()->VDI__get_virtual_size($VDI->getValue())->getValue());
			}
		}

		$response = null;
		if (Validator::numeric()->validate($memory))
		{

			return new XenResponse(array('Value' => $memory, 'Status' => 'Success'));
		}
		else
		{
			return new XenResponse(array('Value' => 0, 'Status' => 'Failed'));
		}

		return $response;
	}


	/**
	 * Get the snapshot info field of the given VM.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getSnapshotInfo()
	{
		return $this->getXenConnection()->VM__get_snapshot_info($this->getRefID());
	}


	/**
	 * Set this VM’s start delay in seconds.
	 *
	 * @param int seconds of delay
	 *
	 * @return XenResponse $response
	 */
	public function setStartDelay($seconds)
	{
		return $this->getXenConnection()->VM__set_start_delay($this->getRefID(), $seconds);
	}

	/**
	 * Set this VM’s start delay in seconds.
	 *
	 * @param int seconds of delay
	 *
	 * @return XenResponse $response
	 */
	public function setShutdownDelay($seconds)
	{
		return $this->getXenConnection()->VM__set_shutdown_delay($this->getRefID(), $seconds);
	}

	/**
	 * Get the start delay field of the given VM.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getStartDelay()
	{
		return $this->getXenConnection()->VM__get_start_delay($this->getRefID());
	}

	/**
	 * Get the shutdown delay field of the given VM.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getShutdownDelay()
	{
		return $this->getXenConnection()->VM__get_shutdown_delay($this->getRefID());
	}

	/**
	 * Get the current operations field of the given VM.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getCurrentOperations()
	{
		return $this->getXenConnection()->VM__get_current_operations($this->getRefID());
	}

	/**
	 * Get the allowed operations field of the given VM.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getAllowedOperations()
	{
		return $this->getXenConnection()->VM__get_allowed_operations($this->getRefID());
	}


	/**
	 * Get the name/description field of the given VM.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getNameDescription()
	{
		return $this->getXenConnection()->VM__get_name_description($this->getRefID());
	}

	/**
	 * Set the name/description field of the given VM.
	 *
	 * @param string name
	 *
	 * @return XenResponse $response
	 */
	public function setNameDescription($name)
	{
		return $this->getXenConnection()->VM__set_name_description($this->getRefID(), $name);
	}

	/**
	 * Get the is a template field of the given VM.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getIsATemplate()
	{
		return $this->getXenConnection()->VM__get_is_a_template($this->getRefID());
	}

	/**
	 * Set the is a template field of the given VM.
	 *
	 * @param bool $template
	 *
	 * @return XenResponse $response
	 */
	public function setIsATemplate($template)
	{
		return $this->getXenConnection()->VM__set_is_a_template($this->getRefID(), $template);
	}


	/**
	 * Get the resident on field of the given VM.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getResidentOn()
	{
		$xenHost  = null;
		$response = $this->getXenConnection()->VM__get_resident_on($this->getRefID());
		if ($response->getValue() != "")
		{
			$xenHost = new XenHost($this->getXenConnection(), null, $response->getValue());
			$name    = $xenHost->getNameLabel()->getValue();
			$xenHost->_setName($name);
		}
		$response->_setValue($xenHost);

		return $response;
	}

	/**
	 * Get the platform field of the given VM.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getPlatform()
	{
		return $this->getXenConnection()->VM__get_platform($this->getRefID());
	}


	/**
	 * Set the platform field of the given VM.
	 *
	 * @param $value array
	 *
	 * @return XenResponse $response
	 */
	public function setPlatform($value = array())
	{
		return $this->getXenConnection()->VM__set_platform($this->getRefID(), $value);
	}


	/**
	 * Get the other config field of the given VM.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getOtherConfig()
	{
		return $this->getXenConnection()->VM__get_other_config($this->getRefID());
	}

	/**
	 * Set the other config field of the given VM.
	 *
	 * @param $value array
	 *
	 * @return XenResponse $response
	 */
	public function setOtherConfig($array = array())
	{
		return $this->getXenConnection()->VM__set_other_config($this->getRefID(), $array);
	}

	/**
	 * Remove the given key and its corresponding value from the other config field of the given vm. If
	 * the key is not in that Map, then do nothing.
	 *
	 * @param $key string
	 *
	 * @return XenResponse $response
	 */
	public function removeFromOtherConfig($key)
	{
		return $this->getXenConnection()->VM__remove_from_other_config($this->getRefID(), $key);
	}


}

?>
	
