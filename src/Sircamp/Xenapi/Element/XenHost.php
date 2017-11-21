<?php namespace Sircamp\Xenapi\Element;

class XenHost extends XenElement
{

	protected $callPrefix = "host";


	public function addTags(string $tag)
	{
		$this->call('add_tags', [$tag]);
	}

	public function addToLicenseServer(string $key, string $value)
	{
		$this->addTo('license_server', $key, $value);
	}

	public function addToLogging(string $key, string $value)
	{
		$this->addTo('logging', $key, $value);
	}

	public function addToOtherConfig(string $key, string $value)
	{
		$this->addTo('other_config', $key, $value);
	}

	public function applyEdition(String $edition, bool $force)
	{
		$this->call('apply_edition', [$edition, $force]);
	}

	public function assertCanEvacuate()
	{
		$this->assert('assert_can_evacuate');
	}

	public function backupRRDs(float $delay)
	{
		$this->call('backup_rrds', [$delay]);
	}

	public function bugreportUpload(String $url, array $options = array())
	{
		$this->call('bugreport_upload', [$url, $options]);
	}

	public function callExtension(String $call): string
	{
		return $this->call('call_extension', [$call])->getValue();
	}

	public function callPlugin(String $plugin, String $fn, array $args = array()): string
	{
		return $this->call('call_plugin', [$plugin, $fn, $args])->getValue();
	}

	public function computeFreeMemory(): int
	{
		return $this->call('compute_free_memory')->getValue();
	}

	public function computeMemoryOverhead()
	{
		return $this->call('compute_memory_overhead')->getValue();
	}

	public function declareDead()
	{
		$this->call('declare_dead');
	}

	public function destroy()
	{
		$this->call('destroy');
	}

	public function disable()
	{
		$this->call('disable');
	}

	public function disableDisplay()
	{
		return $this->call('disable_display')->getValue();
	}

	public function disableExternalAuth(array $config = array())
	{
		$this->call('disable_external_auth', [$config]);
	}

	public function disableLocalStorageCaching()
	{
		$this->call('diasble_local_storage_caching');
	}

	public function dmesg(): string
	{
		return $this->call('dmesg')->getValue();
	}

	public function dmesgClear(): string
	{
		return $this->call('dmesg_clear')->getValue();
	}

	//TODO: implement emergency_ha_disable

	public function enable()
	{
		$this->call('enable');
	}

	public function enableDisplay()
	{
		//TODO: enum
		return $this->call('enable_display')->getValue();
	}

	public function enableExternalAuth(array $config = array(), string $service_name, string $auth_type)
	{
		$this->call('enable_external_auth', [$config, $service_name, $auth_type]);
	}

	public function enableLocalStorageCaching(XenStorageRepository $xenStorageRepository)
	{
		$this->call('enable_local_storage_caching', [$xenStorageRepository->getRefID()]);
	}

	public function evacuate()
	{
		$this->call('evacuate');
	}

	public function forgetDataSourceArchives(string $data_source)
	{
		$this->call('forget_data_source_archive', [$data_source]);
	}

	public function getAPIVersionMajor(): int
	{
		return $this->get('API_version_major');
	}

	public function getAPIVersionMinor(): int
	{
		return $this->get('API_version_minor');
	}

	public function getAPIVersionVendor(): string
	{
		return $this->get('API_version_vendor');
	}

	public function getAPIVersionVendorImplementation(): array
	{
		return $this->get('API_version_vendor_implementation');
	}

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

	public function getAddress(): string
	{
		return $this->get('address');
	}

	public function getAllowedOperations(): array
	{
		return $this->get('allowed_operations');
	}

	public function getBIOSStrings(): array
	{
		return $this->get('bios_strings');
	}

	public function getCapabilities(): array
	{
		return $this->get('capabilities');
	}

	public function getChipsetInfo(): array
	{
		return $this->get('chipset_info');
	}

	public function getControlDomain(): XenVirtualMachine
	{
		return new XenVirtualMachine($this->xenConnection, $this->get('control_domain'));
	}

	public function getCPUConfiguration(): array
	{
		return $this->get('cpu_configuration');
	}

	public function getCPUInfo(): array
	{
		return $this->get('cpu_info');
	}

	public function getCrashDumpStorageRepository(): XenStorageRepository
	{
		return new XenStorageRepository($this->xenConnection, $this->get('crash_dump_sr'));
	}

	public function getCurrentOperations(): array
	{
		return $this->get('current_operations');
	}

	public function getDataSources(): array
	{
		return $this->get('data_sources');
	}

	public function getDisplay(): string
	{
		return $this->get('display');
	}

	public function getEdition(): string
	{
		return $this->get('edition');
	}

	public function getEnabled(): bool
	{
		return $this->get('enabled');
	}

	public function getExternalAuthConfiguration(): array
	{
		return $this->get('external_auth_configuration');
	}

	public function getExternalAuthType(): string
	{
		return $this->get('external_auth_type');
	}

	public function getGuestVCPUsParams(): array
	{
		return $this->get('guest_VCPUs_params');
	}

	public function getHANetworkPeers(): array
	{
		return $this->get('ha_network_peers');
	}

	public function getHAStatefiles(): array
	{
		return $this->get('ha_statefiles');
	}

	public function getHostname(): string
	{
		return $this->get('hostname');
	}

	public function getLicenseParams(): array
	{
		return $this->get('license_params');
	}

	public function getLicenseServer(): array
	{
		return $this->get('license_server');
	}

	public function getLocalCacheStorageRepository(): XenStorageRepository
	{
		return new XenStorageRepository($this->xenConnection, $this->get('local_cache_sr'));
	}

	public function getLog(): string
	{
		return $this->get('log');
	}

	public function getLogging(): array
	{
		return $this->get('logging');
	}

	public function getManagementInterface(): XenPhysicalInterface
	{
		return new XenPhysicalInterface($this->xenConnection, $this->get('management_interface'));
	}

	public function getMemoryOverhead(): int
	{
		return $this->get('memory_overhead');
	}

	public function getNameDescription(): string
	{
		return $this->get('name_description');
	}

	public function getNameLabel(): string
	{
		return $this->get('name_label');
	}

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


	public function getPowerOnConfig(): array
	{
		return $this->get('power_on_config');
	}

	public function getPowerOnMode(): string
	{
		return $this->get('power_on_mode');
	}

	public function getRecord(): array
	{
		return $this->get('record');
	}

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

	public function getSchedPolicy(): string
	{
		return $this->get('sched_policy');
	}

	public function getServerCertificate(): string
	{
		return $this->get('server_certificate');
	}

	public function getServerLocaltime(): string
	{
		return $this->get('server_localtime');
	}

	public function getServertime(): string
	{
		return $this->get('servertime');
	}

	public function getSoftwareVersion(): array
	{
		return $this->get('software_version');
	}

	public function getSSLLegacy(): bool
	{
		return $this->get('ssl_legacy');
	}

	public function getSupportedBootloaders(): array
	{
		return $this->get('supported_bootloaders');
	}


	public function getSuspendImageStorageRepository(): XenStorageRepository
	{
		return new XenStorageRepository($this->xenConnection, $this->get('suspend_image_sr'));
	}

	public function getSystemStatusCapabilities(): string
	{
		return $this->get('system_status_capabilities');
	}

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

	public function getUUID(): string
	{
		return $this->get('uuid');
	}

	public function getVirtualHardwarePlatformVersions(): array
	{
		return $this->get('virtual_hardware_platform_versions');
	}

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


	public function hasExtension(string $name): bool
	{
		return $this->call('has_extension', [$name])->getValue();
	}

	public function licenseAdd(string $contents)
	{
		$this->call('licenseAdd', [$contents]);
	}

	public function licenseApply(string $contents)
	{
		$this->call('license_apply', [$contents]);
	}

	public function licenseRemove()
	{
		$this->call('license_remove');
	}

//	Method is not implemented in xen
//	public function listMethods(): array
//	{
//		$xenResponse = $this->getXenConnection()->__call($this->callPrefix.'__list_methods');
//		print_r($xenResponse);die();
//		return $xenResponse->getValue();
//	}


	//TODO: implement management messages

	public function migrateReceive(XenNetwork $xenNetwork, array $map = array()): array
	{
		return $this->call('migrateReceive', [$xenNetwork->getRefID(), $map])->getValue();
	}

	public function powerOn()
	{
		$this->call('power_on');
	}

	public function queryDataSource(string $data_source): float
	{
		return $this->call('query_data_source', [$data_source])->getValue();
	}

	public function reboot()
	{
		$this->call('reboot');
	}

	public function recordDataSource(string $data_source)
	{
		$this->call('record_data_source', [$data_source]);
	}

	public function refreshPackInfo()
	{
		$this->call('refresh_pack_info');
	}

	public function removeFromGuestVCPUsParams(string $key)
	{
		$this->removeFrom('guest_VCPUs_params', $key);
	}

	public function removeFromLicenseServer(string $key)
	{
		$this->removeFrom('license_server', $key);
	}

	public function removeFromLogging(string $key)
	{
		$this->removeFrom('logging', $key);
	}

	public function removeFromOtherConfig(string $key)
	{
		$this->removeFrom('other_config', $key);
	}

	public function removeTags(string $tag)
	{
		$this->call('remove_tags', [$tag]);
	}

	public function restartAgent()
	{
		$this->call('restart_agent');
	}

	public function retrieveWLBEvacuateRecommendation(): array
	{
		return $this->call('retrieve_wlb_evacuate_recommendations')->getValue();
	}

	public function sendDebugKeys(string $keys)
	{
		$this->call('send_debug_key', [$keys]);
	}

	//TODO: implement set messages
	public function setAddress(string $value)
	{
		$this->set('address', $value);
	}

	public function setCPUFeatures(string $value)
	{
		$this->set('cpu_features', $value);
	}

	public function setCrashDumpStorageRepository(XenStorageRepository $sr)
	{
		$this->set('crash_dump_sr', $sr->getRefID());
	}

	public function setDisplay(string $value)
	{
		$this->set('display', $value);
	}

	public function setGuestVCPUsParams(array $value)
	{
		$this->set('guest_VCPUs_params', $value);
	}

	public function setHostname(string $value)
	{
		$this->set('hostname', $value);
	}

	public function setHostnameLive(string $value)
	{
		$this->set('hostname_live', $value);
	}

	public function setLicenseServer(array $value)
	{
		$this->set('license_server', $value);
	}

	public function setLogging(array $value)
	{
		$this->set('logging', $value);
	}

	public function setNameDescription(string $value)
	{
		$this->set('name_description', $value);
	}

	public function setNameLabel(string $value)
	{
		$this->set('name_label', $value);
	}

	public function setOtherConfig(array $value)
	{
		$this->set('other_config', $value);
	}

	public function setPowerOnMode(array $value)
	{
		$this->set('power_on_mode', $value);
	}

	public function setSSLLegacy(bool $value)
	{
		$this->set('ssl_legacy', $value);
	}

	public function setSuspendImageStorageRepository(XenStorageRepository $sr)
	{
		$this->set('suspend_image_sr', $sr->getRefID());
	}

	public function setTags(array $tags)
	{
		$this->set('tags', $tags);
	}


	public function shutdown()
	{
		$this->call('shutdown');
	}

	public function shutdownAgent()
	{
		$this->call('shutdown_agent');
	}

	public function syncData()
	{
		$this->call('sync_data');
	}

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
	