<?php namespace Sircamp\Xenapi\Element;

use Sircamp\Xenapi\Connection\XenResponse;

class XenHost extends XenElement
{

	protected $callPrefix = "host";


	public function applyEdition(String $edition, bool $force)
	{
		$this->call('apply_edition', [$edition, $force]);
	}

	public function assertCanEvacuate()
	{
		$this->call('assert_can_evacuate');
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
		//TODO: enum
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

	//TODO implement get messages

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
		return $this->call('migrateReceive',[$xenNetwork->getRefID(), $map])->getValue();
	}

	public function powerOn()
	{
		$this->call('power_on');
	}

	public function queryDataSource(string $data_source):float
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

	//TODO implement remove messages

	public function restartAgent()
	{
		$this->call('restart_agent');
	}

	public function retrieveWLBEvacuateRecommendation():array
	{
		return $this->call('retrieve_wlb_evacuate_recommendations')->getValue();
	}

	public function sendDebugKeys(string $keys )
	{
		$this->call('send_debug_key', [$keys]);
	}

	//TODO: implement set messages


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






	/**
	 * Get the host’s log file.
	 *
	 * @param
	 *
	 * @return mixed
	 */
	public function getLog()
	{

		return $this->getXenConnection()->host__get_log($this->getRefID());
	}


	/**
	 * This call queries the host’s clock for the current time.
	 *
	 * @param
	 *
	 * @return mixed
	 */
	public function getServertime()
	{

		return $this->getXenConnection()->host__get_servertime($this->getRefID());
	}

	/**
	 * This call queries the host's clock for the current time in the host’s local timezone.
	 *
	 * @param
	 *
	 * @return mixed
	 */
	public function getServerLocaltime()
	{

		return $this->getXenConnection()->host__get_server_localtime($this->getRefID());
	}

	/**
	 * Get the installed server SSL certificate. (pem file)
	 *
	 * @param
	 *
	 * @return mixed
	 */
	public function getServerCertificate()
	{

		return $this->getXenConnection()->host__get_server_certificate($this->getRefID());
	}


	/**
	 * Get the uuid field of the given host.
	 *
	 * @param
	 *
	 * @return mixed
	 */
	public function getUUID()
	{
		return $this->getXenConnection()->host__get_uuid($this->getRefID());
	}

	/**
	 * Get the name/label field of the given host.
	 *
	 * @param
	 *
	 * @return mixed
	 */
	public function getNameLabel()
	{
		return $this->getXenConnection()->host__get_name_label($this->getRefID());
	}

	/**
	 * Set the name/label field of the given host.
	 *
	 * @param string $name
	 *
	 * @return mixed
	 */
	public function setNameLabel($name)
	{
		return $this->getXenConnection()->host__set_name_label($this->getRefID(), $name);
	}

	/**
	 * Get the name/description field of the given HOST.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getNameDescription()
	{
		return $this->getXenConnection()->host__get_name_description($this->getRefID());
	}

	/**
	 * Set the name/description field of the given HOST.
	 *
	 * @param string name
	 *
	 * @return XenResponse $response
	 */
	public function setNameDescription($name)
	{
		return $this->getXenConnection()->host__set_name_description($this->getRefID(), $name);
	}

	/**
	 * Get the current operations field of the given HOST.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getCurrentOperations()
	{
		return $this->getXenConnection()->host__get_current_operations($this->getRefID());
	}

	/**
	 * Get the allowed operations field of the given HOST.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getAllowedOperations()
	{
		return $this->getXenConnection()->host__get_allowed_operations($this->getRefID());
	}

	/**
	 * Get the software version field of the given host.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getSoftwareVersion()
	{
		return $this->getXenConnection()->host__get_software_version($this->getRefID());
	}

	/**
	 * Get the other config field of the given HOST.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getOtherConfig()
	{
		return $this->getXenConnection()->host__get_other_config($this->getRefID());
	}

	/**
	 * Set the other config field of the given HOST.
	 *
	 * @param $value array
	 *
	 * @return XenResponse $response
	 */
	public function setOtherConfig($array = array())
	{
		return $this->getXenConnection()->host__set_other_config($this->getRefID(), $array);
	}

	/**
	 * Add the given key-value pair to the other config field of the given host.
	 *
	 * @param $key string
	 *
	 * @return XenResponse $response
	 */
	public function addToOtherConfig($key, $value)
	{
		return $this->getXenConnection()->host__add_to_other_config($this->getRefID(), $key, $value);
	}

	/**
	 * Remove the given key and its corresponding value from the other config field of the given host. If
	 * the key is not in that Map, then do nothing.
	 *
	 * @param $key string
	 *
	 * @return XenResponse $response
	 */
	public function removeFromOtherConfig($key)
	{
		return $this->getXenConnection()->host__remove_from_other_config($this->getRefID(), $key);
	}

	/**
	 * Get the supported bootloaders field of the given host.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getSupportedBootloaders()
	{
		return $this->getXenConnection()->host__get_supported_bootloaders($this->getRefID());
	}

	/**
	 * Get the resident VMs field of the given host.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getResidentVMs()
	{
		$response = $this->getXenConnection()->host__get_resident_VMs($this->getRefID());
		$VMs      = array();
		if ($response->getValue() != "")
		{
			foreach ($response->getValue() as $key => $vm)
			{
				$xenVM = new XenVirtualMachine($this->getXenConnection(), null, $vm);
				$name  = $xenVM->getNameLabel();
				array_push($VMs, new XenVirtualMachine($this->getXenConnection(), $name, $vm));
			}
			$response->_setValue($VMs);
		}

		return $response;
	}

	/**
	 * Get the patches field of the given host.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getPatches()
	{
		return $this->getXenConnection()->host__get_patches($this->getRefID());
	}

	/**
	 * Get the host CPUs field of the given host.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getHostCPUs()
	{
		return $this->getXenConnection()->host__get_host_CPUs($this->getRefID());
	}


	/**
	 * Get the cpu info field of the given host.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getCPUInfo()
	{
		return $this->getXenConnection()->host__get_cpu_info($this->getRefID());
	}

	/**
	 * Get the hostname of the given host.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getHostname()
	{
		return $this->getXenConnection()->host__get_hostname($this->getRefID());
	}

	/**
	 * Set the hostname of the given host.
	 *
	 * @param $name string
	 *
	 * @return XenResponse $response
	 */
	public function setHostname($name)
	{
		return $this->getXenConnection()->host__set_hostname($this->getRefID(), $name);
	}

	/**
	 * Get the address field of the given host.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getAddress()
	{
		return $this->getXenConnection()->host__get_address($this->getRefID());
	}

	/**
	 * Set the address field of the given host.
	 *
	 * @param $address string
	 *
	 * @return XenResponse $response
	 */
	public function setAddress($address)
	{
		return $this->getXenConnection()->host__set_address($this->getRefID(), $address);
	}

	/**
	 * Get the metrics field of the given host
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getMetrics()
	{
		return $this->getXenConnection()->host__get_metrics($this->getRefID());
	}

	/**
	 * Get the license params field of the given host.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getLicenseParam()
	{
		return $this->getXenConnection()->host__get_license_params($this->getRefID());
	}

	/**
	 * Get the edition field of the given host.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getEdition()
	{
		return $this->getXenConnection()->host__get_edition($this->getRefID());
	}

	/**
	 * Get the license server field of the given host.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getLicenseServer()
	{
		return $this->getXenConnection()->host__get_license_server($this->getRefID());
	}

	/**
	 * Set the license server field of the given host.
	 *
	 * @param $license_server string
	 *
	 * @return XenResponse $response
	 */
	public function setLicenseServer($license_server)
	{
		return $this->getXenConnection()->host__license_server($this->getRefID(), $license_server);
	}

	/**
	 * Add the given key-value pair to the license server field of the given host.
	 *
	 * @param $key string
	 *
	 * @return XenResponse $response
	 */
	public function addToLicenseServer($key, $value)
	{
		return $this->getXenConnection()->host__add_to_license_server($this->getRefID(), $key, $value);
	}

	/**
	 * Remove the given key and its corresponding value from the license server field of the given host.
	 * If the key is not in that Map, then do nothing.
	 *
	 * @param $key string
	 *
	 * @return XenResponse $response
	 */
	public function removeFromLicenseServer($key)
	{
		return $this->getXenConnection()->host__remove_from_license_server($this->getRefID(), $key);
	}

	/**
	 * Get the chipset info field of the given host.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getChipsetInfo()
	{
		return $this->getXenConnection()->host__get_chipset_info($this->getRefID());
	}
}

?>
	