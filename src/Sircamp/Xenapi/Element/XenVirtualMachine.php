<?php namespace Sircamp\Xenapi\Element;

use Sircamp\Xenapi\Connection\XenResponse;
use Sircamp\Xenapi\Exception\XenException;

class XenVirtualMachine extends XenElement
{

	protected $callPrefix = "VM";

	/**
	 * It is a destructor for the server to destroy the vm
	 */


	/**
	 * Add the given value to the tags field of the given VM. If the value is already in that Set, then do nothing.
	 *
	 * @param string $tag
	 */
	public function addTags(string $tag)
	{
		$this->call('add_tags', [$tag]);
	}

	/**
	 * Add the given key-value pair to the HVM/boot_params field of the given VM.
	 *
	 * @param string $key
	 * @param string $value
	 */
	public function addToHVMBootParams(string $key, string $value)
	{
		$this->addTo('HVM_boot_params', $key, $value);
	}

	/**
	 * Add the given key-value pair to the VCPUs/params field of the given VM.
	 *
	 * @param string $key
	 * @param string $value
	 */
	public function addToVCPUsParams(string $key, string $value)
	{
		$this->addTo('VCPUs_params', $key, $value);
	}

	/**
	 * Add the given key-value pair to VM.VCPUs_params, and apply that value on the running VM
	 *
	 * @param string $key
	 * @param        $value
	 */
	public function addToVSPUsParamsLive(string $key, $value)
	{
		$this->addTo('VCPUs_params', $key, $value);
	}

	/**
	 * Add the given key-value pair to the blocked_operations field of the given VM.
	 *
	 * @param string $vm_operations
	 * @param string $value
	 */
	public function addToBlockedOperations(string $vm_operations, string $value)
	{
		$this->addTo('blocked_operations', $vm_operations, $value);
	}

	/**
	 * Add the given key-value pair to the other_config field of the given VM.
	 *
	 * @param string $key
	 * @param string $value
	 */
	public function addToOtherConfig(string $key, string $value)
	{
		$this->addTo('other_config', $key, $value);
	}

	/**
	 * Add the given key-value pair to the platform field of the given VM.
	 *
	 * @param string $key
	 * @param string $value
	 */
	public function addToPlatform(string $key, string $value)
	{
		$this->addTo('platform', $key, $value);
	}

	/**
	 * Add the given key-value pair to the xenstore_data field of the given VM.
	 *
	 * @param string $key
	 * @param string $value
	 */
	public function addToXenstoreData(string $key, string $value)
	{
		$this->addTo('xenstore_data', $key, $value);
	}

	//TODO: implement assert messages

	/**
	 * Throws an error if the VM is not considered agile e.g. because it is tied to a resource local to a host
	 */
	public function assertAgile()
	{
		$this->assert('agile');
	}

	/**
	 * Assert whether all SRs required to recover this VM are available.
	 *
	 * @param string $session
	 */
	public function assertCanBeRecovered(string $session)
	{
		$this->assert('can_be_recovered', [$session]);
	}

	/**
	 * Throws an error if the VM could not boot on this host for some reason
	 *
	 * @param XenHost $host
	 */
	public function assertCanBootHere(XenHost $host)
	{
		$this->assert('can_be_boot_here', [$host->getRefID()]);
	}

	/**
	 * Assert whether a VM can be migrated to the specified destination.
	 *
	 * @param bool  $live
	 * @param array $vdi_map
	 * @param array $vif_map
	 * @param array $options
	 * @param array $vgpu_map
	 */
	public function assertCanMigrate(bool $live, array $vdi_map = array(), array $vif_map = array(), array $options = array(), array $vgpu_map = array())
	{
		$this->assert('can_migrate', [$live, $vdi_map, $vif_map, $options, $vgpu_map]);
	}

	/**
	 * Check to see whether this operation is acceptable in the current state of the system, raising an error if the operation is invalid for some reason
	 *
	 * @param string $op
	 */
	public function operationValid(string $op)
	{
		$this->assert('operation_valid', [$op]);
	}

	/**
	 * Call a XenAPI plugin on this vm
	 *
	 * @param string $name
	 * @param string $fn
	 * @param array  $args
	 *
	 * @return string
	 * @throws XenException
	 */
	public function callPlugin(string $name, string $fn, array $args = array()): string
	{
		return $this->call('call_plugin', [$name, $fn, $args]);
	}

	/**
	 * Checkpoints the specified VM, making a new VM. Checkpoint automatically exploits the capabilities of the underlying storage repository in which the VM's disk images are stored (e.g. Copy on Write) and saves the memory image as well.
	 *
	 * @param string $name
	 *
	 * @return XenVirtualMachine
	 * @throws XenException
	 */
	public function checkpoint(string $name): XenVirtualMachine
	{
		$refID = $this->call('checkpoint', $name);

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
	 * @param string $name
	 *
	 * @return XenVirtualMachine
	 */
	public function clone(string $name): XenVirtualMachine
	{
		$refID = $this->call('clone', [$name]);

		return new XenVirtualMachine($this->getXenConnection(), $refID);
	}

	/**
	 * Computes the virtualization memory overhead of a VM.
	 *
	 * @return int
	 */
	public function computeMemoryOverhead(): int
	{
		return $this->call('compute_memory_overhead');
	}

	/**
	 * Copied the specified VM, making a new VM. Unlike clone,
	 * copy does not exploits the capabilities of the underlying storage repository in which the VM's disk images are stored.
	 * Instead, copy guarantees that the disk images of the newly created VM will be 'full disks' - i.e. not part of a CoW chain.
	 * This function can only be called when the VM is in the Halted State.
	 *
	 * @param string                    $name
	 * @param XenStorageRepository|null $xenStorageRepository
	 *
	 * @return XenVirtualMachine
	 */
	public function copy(string $name, XenStorageRepository $xenStorageRepository = null): XenVirtualMachine
	{
		$refID = "";
		if (!is_null($xenStorageRepository))
		{
			$refID = $xenStorageRepository->getRefID();
		}

		$vmRefID = $this->call('copy', [$name, $refID]);

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

	public function destroy()
	{
		$this->call('destroy');
	}

	/**
	 * Forget the recorded statistics related to the specified data source
	 *
	 * @param string $data_source
	 */
	public function forgetDataSourceArchives(string $data_source)
	{
		$this->call('forget_data_source_archives', [$data_source]);
	}


	//TODO: implement get methods

	/**
	 * Get the HVM/boot_policy field of the given VM.
	 *
	 * @return string
	 */
	public function getHVMBootPolicy(): string
	{
		return $this->get('HVM_boot_policy');
	}

	/**
	 * Get the HVM/shadow_multiplier field of the given VM.
	 *
	 * @return float
	 */
	public function getHVMShadowMultiplier(): float
	{
		return $this->get('HVM_boot_policy');
	}

	/**
	 * Get the VirtualBlockDevices of the given VM.
	 *
	 * @return array
	 */
	public function getVirtualBlockDevices(): array
	{
		$refIDs    = $this->get('get_VBDs');
		$vbdsArray = array();
		foreach ($refIDs as $refID)
		{
			$vbdsArray[] = new XenVirtualBlockDevice($this->xenConnection, $refID);
		}

		return $vbdsArray;
	}

	/**
	 * Get the VirtualInterfaces of the given VM.
	 *
	 * @return array
	 */
	public function getVirtualInterfaces(): array
	{
		$refIDs    = $this->get('get_VIFs');
		$vifsArray = array();
		foreach ($refIDs as $refID)
		{
			$vifsArray[] = new XenVirtualInterface($this->xenConnection, $refID);
		}

		return $vifsArray;
	}

	private function getActionsAfter(string $name)
	{
		return $this->get('actions_after_' . $name);
	}

	public function getActionsAfterCrash(): string
	{
		return $this->getActionsAfter('crash');
	}

	public function getActionsAfterReboot(): string
	{
		return $this->getActionsAfter('reboot');
	}

	public function getActionsAfterShutdown(): string
	{
		return $this->getActionsAfter('shutdown');
	}

	public function getAffinity(): XenHost
	{
		$refID = $this->get('affinity');

		return new XenHost($this->xenConnection, $refID);
	}

	public function getAllowedVBDDevices(): array
	{
		return $this->get('allowed_VBD_devices');
	}

	public function getAllowedVIFDevices(): array
	{
		return $this->get('allowed_VIF_devices');
	}

	public function getAllowedOperations(): array
	{
		return $this->get('allowed_operations');
	}

	public function getChildren(): array
	{
		$refIDs  = $this->get('children');
		$vmArray = array();
		foreach ($refIDs as $refID)
		{
			$vmArray[] = new XenVirtualMachine($this->xenConnection, $refID);
		}

		return $vmArray;
	}

	public function getConsoles(): array
	{
		//TODO: implement class console
		return $this->get('consoles');
	}

	public function getCurrentOperations(): array
	{
		return $this->get('current_operations');
	}

	public function getDataSources(): array
	{
		return $this->get('data_sources');
	}

	public function getDomarch(): string
	{
		return $this->get('domarch');
	}

	public function getDomID(): string
	{
		return $this->get('domid');
	}

	public function getGenerationID(): string
	{
		return $this->get('generation_id');
	}

	//TODO: get metrics

	public function getHardwarePlatformVersion(): int
	{
		return $this->get('hardware_platform_version');
	}

	public function getHasVendorDevice(): bool
	{
		return $this->get('has_vendor_device');
	}

	public function getIsASnapshot(): bool
	{
		return $this->get('is_a_snapshot');
	}

	public function getIsATemplate(): bool
	{
		return $this->get('is_a_template');
	}

	public function getIsControlDomain(): bool
	{
		return $this->get('is_control_domain');
	}

	public function getIsDefaultDomain(): bool
	{
		return $this->get('is_default_domain');
	}

	public function getIsSnapshotFromVMPP(): bool
	{
		return $this->get('is_snapshot_from_vmpp');
	}

	public function getIsVMSSSnapshot(): bool
	{
		return $this->get('is_vmss_snapshot');
	}

	public function getNameDescription(): string
	{
		return $this->get('name_description');
	}

	public function getNameLabel(): string
	{
		return $this->get('name_label');
	}

	public function getOrder(): int
	{
		return $this->get('order');
	}

	public function getOtherConfig(): array
	{
		return $this->get('other_config');
	}

	public function getParent(): XenVirtualMachine
	{
		$refID = $this->get('parent');

		return new XenVirtualMachine($this->xenConnection, $refID);
	}

	public function getPlatform(): array
	{
		return $this->get('platform');
	}

	public function getPossibleHosts(): array
	{
		$refIDs  = $this->get('possible_hosts');
		$hostArr = array();

		foreach ($refIDs as $refID)
		{
			$hostArr[] = new XenHost($this->xenConnection, $refID);
		}

		return $hostArr;
	}

	public function getPowerState(): string
	{
		return $this->get('power_state');
	}

	public function getRecord(): array
	{
		return $this->get('record');
	}

	public function getResidentOn(): XenHost
	{
		return new XenHost($this->xenConnection, $this->get('resident_on'));
	}

	public function getShutdownDelay(): int
	{
		return $this->get('shutdown_delay');
	}

	public function getSnapshotInfo(): array
	{
		return $this->get('snapshot_info');
	}

	public function getSnapshotMetadata(): string
	{
		return $this->get('snapshot_metadata');
	}

	public function getSnapshotOf(): XenVirtualMachine
	{
		$refID = $this->get('snapshot_of');

		return new XenVirtualMachine($this->xenConnection, $refID);
	}

	public function getSnapshotDatetime(): string
	{
		return $this->get('snapshot_datetime');
	}

	public function getSnapshots(): array
	{
		$refIDs = $this->get('snapshots');
		$vmArr  = array();

		foreach ($refIDs as $refID)
		{
			$vmArr[] = new XenVirtualMachine($this->xenConnection, $refID);
		}

		return $vmArr;
	}

	public function getStartDelay(): int
	{
		return $this->get('start_delay');
	}

	public function getSuspendStorageRepository()
	{
		$refID = $this->get('suspend_SR');

		return new XenStorageRepository($this->xenConnection, $refID);
	}

	public function getSuspendVirtualDiskImage()
	{
		$refID = $this->get('suspend_VDI');

		return new XenVirtualDiskImage($this->xenConnection, $refID);
	}

	public function getTags(): array
	{
		return $this->get('tags');
	}

	public function getTransportableSnapshotID(): string
	{
		return $this->get('transportable_snapshot_id');
	}

	public function getUserVersion(): int
	{
		return $this->get('user_version');
	}

	public function getUUID(): string
	{
		return $this->get('uuid');
	}

	public function getVersion(): int
	{
		return $this->get('version');
	}

	public function getXenStoreData(): array
	{
		return $this->get('xenstore_data');
	}

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
		$refIDs  = $this->call('import', [$url, $xenStorageRepository->getRefID(), $full_restore, $force]);
		$vmArray = array();

		foreach ($refIDs as $refID)
		{
			$vmArray[] = new XenVirtualMachine($this->getXenConnection(), $refID);
		}

	}

	public function importConvert(string $type, string $username, string $password, XenStorageRepository $xenStorageRepository, array $remote_config)
	{
		$this->call('import_convert', [$type, $username, $password, $xenStorageRepository->getRefID(), $remote_config]);
	}


	public function maximiseMemory(int $total, bool $approximate)
	{
		return $this->call('maximiseMemory', [$total, $approximate]);
	}

	//TODO: implement migrate_send
	public function migrateSend(array $dest, bool $live, array $vdi_map, array $vif_map, array $options, array $vgpu_map)
	{
		$refID = $this->call('migrate_send', [$dest, $live, $vdi_map, $vif_map, $options, $vgpu_map]);

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

	public function queryDataSource(string $data_source): float
	{
		return $this->call('query_data_source', [$data_source]);
	}

	public function queryServices(): array
	{
		return $this->call('query_services');
	}

	public function recordDataSource(string $data_source)
	{
		$this->call('record_data_source', [$data_source]);
	}

	public function recover(string $session_to, bool $force = false)
	{
		$this->call('recover', [$session_to, $force]);
	}

	public function removeFromHVMBootParams(string $key)
	{
		$this->removeFrom('HVM_boot_params', $key);
	}

	public function removeFromVCPUsParams(string $key)
	{
		$this->removeFrom('VCPUs_params', $key);
	}

	public function removeFromBlockedOperations(string $key)
	{
		$this->removeFrom('blocked_operations', $key);
	}

	public function removeFromOtherConfig(string $key)
	{
		$this->removeFrom('other_config', $key);
	}

	public function removeFromPlatform(string $key)
	{
		$this->removeFrom('platform', $key);
	}

	public function removeFromXenStoreData(string $key)
	{
		$this->removeFrom('xenstore_data', $key);
	}

	public function removeTags(string $key)
	{
		$this->call('remove_tags', [$key]);
	}

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

	public function sendSysrq(string $key)
	{
		$this->call('send_sysrq', [$key]);
	}

	public function sendTrigger(string $trigger)
	{
		$this->call('send_trigger', [$trigger]);
	}

	public function setHVMBootParams(array $value)
	{
		$this->set('HVM_boot_params', $value);
	}

	public function setHVMBootPolicy(string $value)
	{
		$this->set('HVM_boot_policy', $value);
	}

	public function setHVMShadowMultiplier(float $value)
	{
		$this->set('HVM_shadow_multiplier', $value);
	}

	public function setPCIBus(string $value)
	{
		$this->set('PCI_bus', $value);
	}

	public function setPVBootloader(string $value)
	{
		$this->set('PV_bootloader', $value);
	}

	public function setPVBootloaderArgs(string $value)
	{
		$this->set('PV_bootloader_args', $value);
	}

	public function setPVKernel(string $value)
	{
		$this->set('PV_kernel', $value);
	}

	public function setPVLegacyArgs(string $value)
	{
		$this->set('PV_legacy_args', $value);
	}

	public function setPVRamdisk(string $value)
	{
		$this->set('PV_ramdisk', $value);
	}

	public function setVCPUsAtStartup(int $value)
	{
		$this->set('VCPUs_at_startup', $value);
	}

	public function setVCPUsMax(int $value)
	{
		$this->set('VCPUs_max', $value);
	}

	public function setVCPUsNumberLive(int $value)
	{
		$this->set('VCPUs_number_live', $value);
	}

	public function setVCPUsParams(array $value)
	{
		$this->set('VCPUs_params', $value);
	}

	public function setActionsAfterCrash(string $value)
	{
		$this->set('actions_after_crash', $value);
	}

	public function setActionsAfterReboot(string $value)
	{
		$this->set('actions_after_reboot', $value);
	}

	public function setActionsAfterShutdown(string $value)
	{
		$this->set('actions_after_shutdown', $value);
	}

	public function setAffinity(XenHost $host)
	{
		$this->set('affinity', $host->getRefID());
	}

	//TODO appliance

	public function setBiosStrings(array $value)
	{
		$this->set('bios_strings', $value);
	}

	public function setBlockedOperations(array $value)
	{
		$this->set('blocked_operations', $value);
	}

	public function setHARestartPriority(string $value)
	{
		$this->set('ha_restart_priority', $value);
	}

	public function setHardwarePlatformVersion(int $value)
	{
		$this->set('hardware_platform_version', $value);
	}

	public function setHasVendorDevice(bool $value)
	{
		$this->set('has_vendor_device', $value);
	}

	public function setIsATemplate(bool $value)
	{
		$this->set('is_a_template', $value);
	}

	public function setMemory(int $value)
	{
		$this->set('memory', $value);
	}

	//TODO memory messages

	public function setNameDescription(string $value)
	{
		$this->set('name_description', $value);
	}

	public function setNameLabel(string $value)
	{
		$this->set('name_label', $value);
	}

	public function setOrder(int $value)
	{
		$this->set('order', $value);
	}

	public function setOtherConfig(array $value)
	{
		$this->set('other_config', $value);
	}

	public function setPlatform(array $value)
	{
		$this->set('platform', $value);
	}

	public function setRecommendations(string $value)
	{
		$this->set('recommendations', $value);
	}

	public function setShadowMultiplierLive(float $value)
	{
		$this->set('shadow_multiplier_live', $value);
	}

	public function setShutdownDelay(int $value)
	{
		$this->set('shutdown_delay', $value);
	}

	public function setStartDelay(int $value)
	{
		$this->set('start_delay', $value);
	}

	public function setSuspendStorageRepository(XenStorageRepository $sr)
	{
		$this->set('suspend_SR', $sr->getRefID());
	}

	public function setSuspendVirtualDiskImage(XenVirtualDiskImage $vdi)
	{
		$this->set('suspend_VDI', $vdi->getRefID());
	}

	public function setTags(array $tags)
	{
		$this->set('tags', $tags);
	}

	public function setUserVersion(int $value)
	{
		$this->set('user_version', $value);
	}

	public function setXenStoreData(array $value)
	{
		$this->set('xenstore_data', $value);
	}

	public function shutdown()
	{
		$this->call('shutdown');
	}

	public function snapshot(string $name): XenVirtualMachine
	{
		$refID = $this->call('snapshot', [$name]);

		return new XenVirtualMachine($this->getXenConnection(), $refID);
	}

	public function snapshotWithQuiesce(string $name): XenVirtualMachine
	{
		$refID = $this->call('snapshot_with_quiesce', [$name]);

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
	 * Get the VM stats by passing her uuid.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
//	function getStats()
//	{
//
//		$user     = $this->getXenConnection()->getUser();
//		$password = $this->getXenConnection()->getPassword();
//		$ip       = $this->getXenConnection()->getUrl();
//		$uuid     = $this->getUUID($this->getRefID());
//
//		$url = 'http://' . $user . ':' . $password . '@' . $ip . '/vm_rrd?uuid=' . $uuid. '&start=1000000000‏';
//
//
//		$client   = new Client();
//		$response = $client->get($url);
//
//		$body = $response->getBody();
//		$xml  = "";
//
//		while (!$body->eof())
//		{
//			$xml .= $body->read(1024);
//		}
//
//		$response = new XenResponse(array('Value' => array(0 => '')));
//
//		if (Validator::stringType()->validate($xml))
//		{
//			$response = new XenResponse(array('Value' => $xml, 'Status' => 'Success'));
//		}
//		else
//		{
//			$response = new XenResponse(array('Value' => '', 'Status' => 'Failed'));
//		}
//
//		return $response;
//	}

}

?>
	
