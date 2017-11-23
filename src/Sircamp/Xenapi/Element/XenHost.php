<?php namespace Sircamp\Xenapi\Element;

/**
 * Class XenHost
 * @package Sircamp\Xenapi\Element
 */
class XenHost extends XenElement
{

	/**
	 * @var string
	 */
	protected $callPrefix = "host";


	/**
	 * @param string $tag
	 */
	public function addTags(string $tag)
	{
		$this->call('add_tags', [$tag]);
	}

	/**
	 * @param string $key
	 * @param string $value
	 */
	public function addToLicenseServer(string $key, string $value)
	{
		$this->addTo('license_server', $key, $value);
	}

	/**
	 * @param string $key
	 * @param string $value
	 */
	public function addToLogging(string $key, string $value)
	{
		$this->addTo('logging', $key, $value);
	}

	/**
	 * @param string $key
	 * @param string $value
	 */
	public function addToOtherConfig(string $key, string $value)
	{
		$this->addTo('other_config', $key, $value);
	}

	/**
	 * @param String $edition
	 * @param bool   $force
	 */
	public function applyEdition(String $edition, bool $force)
	{
		$this->call('apply_edition', [$edition, $force]);
	}

	/**
	 *
	 */
	public function assertCanEvacuate()
	{
		$this->assert('assert_can_evacuate');
	}

	/**
	 * @param float $delay
	 */
	public function backupRRDs(float $delay)
	{
		$this->call('backup_rrds', [$delay]);
	}

	/**
	 * @param String $url
	 * @param array  $options
	 */
	public function bugreportUpload(String $url, array $options = array())
	{
		$this->call('bugreport_upload', [$url, $options]);
	}

	/**
	 * @param String $call
	 *
	 * @return string
	 */
	public function callExtension(String $call): string
	{
		return $this->call('call_extension', [$call]);
	}

	/**
	 * @param String $plugin
	 * @param String $fn
	 * @param array  $args
	 *
	 * @return string
	 */
	public function callPlugin(String $plugin, String $fn, array $args = array()): string
	{
		return $this->call('call_plugin', [$plugin, $fn, $args]);
	}

	/**
	 * @return int
	 */
	public function computeFreeMemory(): int
	{
		return $this->call('compute_free_memory');
	}

	/**
	 * @return mixed
	 */
	public function computeMemoryOverhead()
	{
		return $this->call('compute_memory_overhead');
	}

	/**
	 *
	 */
	public function declareDead()
	{
		$this->call('declare_dead');
	}

	/**
	 *
	 */
	public function destroy()
	{
		$this->call('destroy');
	}

	/**
	 *
	 */
	public function disable()
	{
		$this->call('disable');
	}

	/**
	 * @return mixed
	 */
	public function disableDisplay()
	{
		return $this->call('disable_display');
	}

	/**
	 * @param array $config
	 */
	public function disableExternalAuth(array $config = array())
	{
		$this->call('disable_external_auth', [$config]);
	}

	/**
	 *
	 */
	public function disableLocalStorageCaching()
	{
		$this->call('diasble_local_storage_caching');
	}

	/**
	 * @return string
	 */
	public function dmesg(): string
	{
		return $this->call('dmesg');
	}

	/**
	 * @return string
	 */
	public function dmesgClear(): string
	{
		return $this->call('dmesg_clear');
	}

	//TODO: implement emergency_ha_disable

	/**
	 *
	 */
	public function enable()
	{
		$this->call('enable');
	}

	/**
	 * @return mixed
	 */
	public function enableDisplay()
	{
		//TODO: enum
		return $this->call('enable_display');
	}

	/**
	 * @param array  $config
	 * @param string $service_name
	 * @param string $auth_type
	 */
	public function enableExternalAuth(array $config = array(), string $service_name, string $auth_type)
	{
		$this->call('enable_external_auth', [$config, $service_name, $auth_type]);
	}

	/**
	 * @param XenStorageRepository $xenStorageRepository
	 */
	public function enableLocalStorageCaching(XenStorageRepository $xenStorageRepository)
	{
		$this->call('enable_local_storage_caching', [$xenStorageRepository->getRefID()]);
	}

	/**
	 *
	 */
	public function evacuate()
	{
		$this->call('evacuate');
	}

	/**
	 * @param string $data_source
	 */
	public function forgetDataSourceArchives(string $data_source)
	{
		$this->call('forget_data_source_archive', [$data_source]);
	}

	/**
	 * @return int
	 */
	public function getAPIVersionMajor(): int
	{
		return $this->get('API_version_major');
	}

	/**
	 * @return int
	 */
	public function getAPIVersionMinor(): int
	{
		return $this->get('API_version_minor');
	}

	/**
	 * @return string
	 */
	public function getAPIVersionVendor(): string
	{
		return $this->get('API_version_vendor');
	}

	/**
	 * @return array
	 */
	public function getAPIVersionVendorImplementation(): array
	{
		return $this->get('API_version_vendor_implementation');
	}

	/**
	 * @return array
	 */
	public function getPhysicalBlockDevices(): array
	{
		$refIDs   = $this->get('PBDs');
		$pbdArray = [];
		foreach ($refIDs as $refID)
		{
			$pbdArray[] = new XenPhysicalBlockDevice($this->xenConnection, $refID);
		}

		return $pbdArray;
	}

	/**
	 * @return array
	 */
	public function getPhysicalInterfaces(): array
	{
		$refIDs   = $this->get('PIFs');
		$pifArray = [];
		foreach ($refIDs as $refID)
		{
			$pifArray[] = new XenPhysicalInterface($this->xenConnection, $refID);
		}

		return $pifArray;
	}

	/**
	 * @return string
	 */
	public function getAddress(): string
	{
		return $this->get('address');
	}

	/**
	 * @return array
	 */
	public function getAllowedOperations(): array
	{
		return $this->get('allowed_operations');
	}

	/**
	 * @return array
	 */
	public function getBIOSStrings(): array
	{
		return $this->get('bios_strings');
	}

	/**
	 * @return array
	 */
	public function getCapabilities(): array
	{
		return $this->get('capabilities');
	}

	/**
	 * @return array
	 */
	public function getChipsetInfo(): array
	{
		return $this->get('chipset_info');
	}

	/**
	 * @return XenVirtualMachine
	 */
	public function getControlDomain(): XenVirtualMachine
	{
		return new XenVirtualMachine($this->xenConnection, $this->get('control_domain'));
	}

	/**
	 * @return array
	 */
	public function getCPUConfiguration(): array
	{
		return $this->get('cpu_configuration');
	}

	/**
	 * @return array
	 */
	public function getCPUInfo(): array
	{
		return $this->get('cpu_info');
	}

	/**
	 * @return XenStorageRepository
	 */
	public function getCrashDumpStorageRepository(): XenStorageRepository
	{
		return new XenStorageRepository($this->xenConnection, $this->get('crash_dump_sr'));
	}

	/**
	 * @return array
	 */
	public function getCurrentOperations(): array
	{
		return $this->get('current_operations');
	}

	/**
	 * @return array
	 */
	public function getDataSources(): array
	{
		return $this->get('data_sources');
	}

	/**
	 * @return string
	 */
	public function getDisplay(): string
	{
		return $this->get('display');
	}

	/**
	 * @return string
	 */
	public function getEdition(): string
	{
		return $this->get('edition');
	}

	/**
	 * @return bool
	 */
	public function getEnabled(): bool
	{
		return $this->get('enabled');
	}

	/**
	 * @return array
	 */
	public function getExternalAuthConfiguration(): array
	{
		return $this->get('external_auth_configuration');
	}

	/**
	 * @return string
	 */
	public function getExternalAuthType(): string
	{
		return $this->get('external_auth_type');
	}

	/**
	 * @return array
	 */
	public function getGuestVCPUsParams(): array
	{
		return $this->get('guest_VCPUs_params');
	}

	/**
	 * @return array
	 */
	public function getHANetworkPeers(): array
	{
		return $this->get('ha_network_peers');
	}

	/**
	 * @return array
	 */
	public function getHAStatefiles(): array
	{
		return $this->get('ha_statefiles');
	}

	/**
	 * @return string
	 */
	public function getHostname(): string
	{
		return $this->get('hostname');
	}

	/**
	 * @return array
	 */
	public function getLicenseParams(): array
	{
		return $this->get('license_params');
	}

	/**
	 * @return array
	 */
	public function getLicenseServer(): array
	{
		return $this->get('license_server');
	}

	/**
	 * @return XenStorageRepository
	 */
	public function getLocalCacheStorageRepository(): XenStorageRepository
	{
		return new XenStorageRepository($this->xenConnection, $this->get('local_cache_sr'));
	}

	/**
	 * @return string
	 */
	public function getLog(): string
	{
		return $this->get('log');
	}

	/**
	 * @return array
	 */
	public function getLogging(): array
	{
		return $this->get('logging');
	}

	/**
	 * @return XenPhysicalInterface
	 */
	public function getManagementInterface(): XenPhysicalInterface
	{
		return new XenPhysicalInterface($this->xenConnection, $this->get('management_interface'));
	}

	/**
	 * @return int
	 */
	public function getMemoryOverhead(): int
	{
		return $this->get('memory_overhead');
	}

	/**
	 * @return string
	 */
	public function getNameDescription(): string
	{
		return $this->get('name_description');
	}

	/**
	 * @return string
	 */
	public function getNameLabel(): string
	{
		return $this->get('name_label');
	}

	/**
	 * @return array
	 */
	public function getOtherConfig(): array
	{
		return $this->get('other_config');
	}

	/**
	 * @deprecated
	 * @return array
	 */
	public function getPatches(): array
	{
		return $this->get('pathes');
	}


	/**
	 * @return array
	 */
	public function getPowerOnConfig(): array
	{
		return $this->get('power_on_config');
	}

	/**
	 * @return string
	 */
	public function getPowerOnMode(): string
	{
		return $this->get('power_on_mode');
	}

	/**
	 * @return array
	 */
	public function getRecord(): array
	{
		return $this->get('record');
	}

	/**
	 * @return array
	 */
	public function getResidentVirtualMachines(): array
	{
		$refIDs  = $this->get('resident_VMs');
		$vmArray = [];
		foreach ($refIDs as $refID)
		{
			$vmArray[] = new XenVirtualMachine($this->xenConnection, $refID);
		}

		return $vmArray;
	}

	/**
	 * @return string
	 */
	public function getSchedPolicy(): string
	{
		return $this->get('sched_policy');
	}

	/**
	 * @return string
	 */
	public function getServerCertificate(): string
	{
		return $this->get('server_certificate');
	}

	/**
	 * @return string
	 */
	public function getServerLocaltime(): string
	{
		return $this->get('server_localtime');
	}

	/**
	 * @return string
	 */
	public function getServertime(): string
	{
		return $this->get('servertime');
	}

	/**
	 * @return array
	 */
	public function getSoftwareVersion(): array
	{
		return $this->get('software_version');
	}

	/**
	 * @return bool
	 */
	public function getSSLLegacy(): bool
	{
		return $this->get('ssl_legacy');
	}

	/**
	 * @return array
	 */
	public function getSupportedBootloaders(): array
	{
		return $this->get('supported_bootloaders');
	}


	/**
	 * @return XenStorageRepository
	 */
	public function getSuspendImageStorageRepository(): XenStorageRepository
	{
		return new XenStorageRepository($this->xenConnection, $this->get('suspend_image_sr'));
	}

	/**
	 * @return string
	 */
	public function getSystemStatusCapabilities(): string
	{
		return $this->get('system_status_capabilities');
	}

	/**
	 * @return array
	 */
	public function getTags(): array
	{
		return $this->get('tags');
	}

	/**
	 * @deprecated
	 * @return array
	 */
	public function getUncooperativeResidentVirtualMachines(): array
	{
		$refIDs  = $this->get('uncooperative_resident_VMs');
		$vmArray = [];
		foreach ($refIDs as $refID)
		{
			$vmArray[] = new XenVirtualMachine($this->xenConnection, $refID);
		}

		return $vmArray;
	}

	/**
	 * @return string
	 */
	public function getUUID(): string
	{
		return $this->get('uuid');
	}

	/**
	 * @return array
	 */
	public function getVirtualHardwarePlatformVersions(): array
	{
		return $this->get('virtual_hardware_platform_versions');
	}

	/**
	 * @return array
	 */
	public function getVirtualMachinesWhichPreventEvacuation(): array
	{
		$refIDs  = $this->get('vms_which_prevents');
		$vmArray = [];
		foreach ($refIDs as $refID)
		{
			$vmArray[] = [
				'vm'     => new XenVirtualMachine($this->xenConnection, $refID[0]),
				'errors' => $refID[1]
			];
		}

		return $vmArray;
	}


	/**
	 * @param string $name
	 *
	 * @return bool
	 */
	public function hasExtension(string $name): bool
	{
		return $this->call('has_extension', [$name]);
	}

	/**
	 * @param string $contents
	 */
	public function licenseAdd(string $contents)
	{
		$this->call('licenseAdd', [$contents]);
	}

	/**
	 * @param string $contents
	 */
	public function licenseApply(string $contents)
	{
		$this->call('license_apply', [$contents]);
	}

	/**
	 *
	 */
	public function licenseRemove()
	{
		$this->call('license_remove');
	}

//	Method is not implemented in xen
//	public function listMethods(): array
//	{
//		$xenResponse = $this->getXenConnection()->__call($this->callPrefix.'__list_methods');
//		print_r($xenResponse);die();
//		return $xenResponse;
//	}


	//TODO: implement management messages

	/**
	 * @param XenNetwork $xenNetwork
	 * @param array      $map
	 *
	 * @return array
	 */
	public function migrateReceive(XenNetwork $xenNetwork, array $map = array()): array
	{
		return $this->call('migrateReceive', [$xenNetwork->getRefID(), $map]);
	}

	/**
	 *
	 */
	public function powerOn()
	{
		$this->call('power_on');
	}

	/**
	 * @param string $data_source
	 *
	 * @return float
	 */
	public function queryDataSource(string $data_source): float
	{
		return $this->call('query_data_source', [$data_source]);
	}

	/**
	 *
	 */
	public function reboot()
	{
		$this->call('reboot');
	}

	/**
	 * @param string $data_source
	 */
	public function recordDataSource(string $data_source)
	{
		$this->call('record_data_source', [$data_source]);
	}

	/**
	 *
	 */
	public function refreshPackInfo()
	{
		$this->call('refresh_pack_info');
	}

	/**
	 * @param string $key
	 */
	public function removeFromGuestVCPUsParams(string $key)
	{
		$this->removeFrom('guest_VCPUs_params', $key);
	}

	/**
	 * @param string $key
	 */
	public function removeFromLicenseServer(string $key)
	{
		$this->removeFrom('license_server', $key);
	}

	/**
	 * @param string $key
	 */
	public function removeFromLogging(string $key)
	{
		$this->removeFrom('logging', $key);
	}

	/**
	 * @param string $key
	 */
	public function removeFromOtherConfig(string $key)
	{
		$this->removeFrom('other_config', $key);
	}

	/**
	 * @param string $tag
	 */
	public function removeTags(string $tag)
	{
		$this->call('remove_tags', [$tag]);
	}

	/**
	 *
	 */
	public function restartAgent()
	{
		$this->call('restart_agent');
	}

	/**
	 * @return array
	 */
	public function retrieveWLBEvacuateRecommendation(): array
	{
		return $this->call('retrieve_wlb_evacuate_recommendations');
	}

	/**
	 * @param string $keys
	 */
	public function sendDebugKeys(string $keys)
	{
		$this->call('send_debug_key', [$keys]);
	}

	//TODO: implement set messages

	/**
	 * @param string $value
	 */
	public function setAddress(string $value)
	{
		$this->set('address', $value);
	}

	/**
	 * @param string $value
	 */
	public function setCPUFeatures(string $value)
	{
		$this->set('cpu_features', $value);
	}

	/**
	 * @param XenStorageRepository $sr
	 */
	public function setCrashDumpStorageRepository(XenStorageRepository $sr)
	{
		$this->set('crash_dump_sr', $sr->getRefID());
	}

	/**
	 * @param string $value
	 */
	public function setDisplay(string $value)
	{
		$this->set('display', $value);
	}

	/**
	 * @param array $value
	 */
	public function setGuestVCPUsParams(array $value)
	{
		$this->set('guest_VCPUs_params', $value);
	}

	/**
	 * @param string $value
	 */
	public function setHostname(string $value)
	{
		$this->set('hostname', $value);
	}

	/**
	 * @param string $value
	 */
	public function setHostnameLive(string $value)
	{
		$this->set('hostname_live', $value);
	}

	/**
	 * @param array $value
	 */
	public function setLicenseServer(array $value)
	{
		$this->set('license_server', $value);
	}

	/**
	 * @param array $value
	 */
	public function setLogging(array $value)
	{
		$this->set('logging', $value);
	}

	/**
	 * @param string $value
	 */
	public function setNameDescription(string $value)
	{
		$this->set('name_description', $value);
	}

	/**
	 * @param string $value
	 */
	public function setNameLabel(string $value)
	{
		$this->set('name_label', $value);
	}

	/**
	 * @param array $value
	 */
	public function setOtherConfig(array $value)
	{
		$this->set('other_config', $value);
	}

	/**
	 * @param array $value
	 */
	public function setPowerOnMode(array $value)
	{
		$this->set('power_on_mode', $value);
	}

	/**
	 * @param bool $value
	 */
	public function setSSLLegacy(bool $value)
	{
		$this->set('ssl_legacy', $value);
	}

	/**
	 * @param XenStorageRepository $sr
	 */
	public function setSuspendImageStorageRepository(XenStorageRepository $sr)
	{
		$this->set('suspend_image_sr', $sr->getRefID());
	}

	/**
	 * @param array $tags
	 */
	public function setTags(array $tags)
	{
		$this->set('tags', $tags);
	}


	/**
	 *
	 */
	public function shutdown()
	{
		$this->call('shutdown');
	}

	/**
	 *
	 */
	public function shutdownAgent()
	{
		$this->call('shutdown_agent');
	}

	/**
	 *
	 */
	public function syncData()
	{
		$this->call('sync_data');
	}

	/**
	 *
	 */
	public function syslogReconfigure()
	{
		$this->call('syslog_reconfigure');
	}

// Methods from old api which will be implemented soon
//	/**
//	 * Get the host CPUs field of the given host.
//	 *
//	 * @param
//	 *
//	 * @return XenResponse $response
//	 */
//	public function getHostCPUs()
//	{
//		return $this->getXenConnection()->host__get_host_CPUs($this->getRefID());
//	}
//
//
//	/**
//	 * Get the metrics field of the given host
//	 *
//	 * @param
//	 *
//	 * @return XenResponse $response
//	 */
//	public function getMetrics()
//	{
//		return $this->getXenConnection()->host__get_metrics($this->getRefID());
//	}


}

?>
	