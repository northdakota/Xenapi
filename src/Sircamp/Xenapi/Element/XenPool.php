<?php
/**
 * Created by PhpStorm.
 * User: Oliver
 * Date: 23.11.2017
 * Time: 22:05
 */

namespace Sircamp\Xenapi\Element;


class XenPool extends XenElement
{
	protected $callPrefix = 'pool';


	public function addTags(string $tag)
	{
		$this->call('add_tags', [$tag]);
	}
	
	public function addToGuestAgentConfig(string $key, string $value)
	{
	    $this->addTo('guest_agent_config', $key, $value);
	}
	
	public function addToHealthCheckConfig(string $key, string $value)
	{
	    $this->addTo('health_check_config', $key, $value);
	}
	public function addToOtherConfig(string $key, string $value)
	{
	    $this->addTo('other_config', $key, $value);
	}

	public function applyEdition(string $edition)
	{
		$this->call('apply_edition', [$edition]);
	}

	public function disableExternalAuth(array $config)
	{
		$this->call('disable_external_auth', [$config]);
	}

	public function disableLocalStorageCaching()
	{
		$this->call('disable_local_storage_caching');
	}

	public function enableExternalAuth(array $config, string $service_name, string $auth_type)
	{
		$this->call('enable_external_auth', [$config, $service_name, $auth_type]);
	}

	public function enableLocalStorageCaching()
	{
		$this->call('enable_local_storage_caching');
	}

	public function enableSSLLegacy()
	{
		$this->call('enable_ssl_legacy');
	}

	public function getAllowedOperations():array
	{
		return $this->get('allowed_operations');
	}

	public function getCPUInfo(): array
	{
	    return $this->get('cpu_info');
	}


	public function getCrashDumpSR(): XenStorageRepository
	{
	    return new XenStorageRepository($this->xenConnection,$this->get('crash_dump_SR'));
	}
	
	public function getCurrentOperations(): array
	{
	    return $this->get('current_operations');
	}
	
	public function getDefaultSR(): XenStorageRepository
	{
	    return new XenStorageRepository($this->xenConnection,$this->get('default_SR'));
	}
	
	public function getGuestAgentConfig(): array
	{
	    return $this->get('guest_agent_config');
	}
	
	public function getGUIConfig(): array
	{
	    return $this->get('gui_config');
	}
	
	public function getHAAllowOvercommit(): bool
	{
	    return $this->get('ha_allow_overcommit');
	}
	
	public function getHAClusterStack(): string
	{
	    return $this->get('ha_cluster_stack');
	}
	
	public function getHAConfiguration(): array
	{
	    return $this->get('ha_configuration');
	}
	
	public function getHAEnabled(): bool
	{
	    return $this->get('ha_enabled');
	}
	
	public function getHAHistFailuresToTolerate(): int
	{
	    return $this->get('ha_hist_failures_to_tolerate');
	}
	
	public function getHACvercommited(): bool
	{
	    return $this->get('ha_overcommited');
	}
	
	public function getHAPlanExistsFor(): int
	{
	    return $this->get('ha_plan_exists_for');
	}
	
	public function getHAStatefiles(): array
	{
	    return $this->get('ha_statefiles');
	}
	
	public function getHealthCheckConfig(): array
	{
	    return $this->get('health_check_config');
	}
	
	public function getIGMPSnoopingEnabled(): bool
	{
	    return $this->get('igmp_snooping_enabled');
	}
	
	public function getLicenseState(): array
	{
	    return $this->get('license_state');
	}
	
	public function getLivePatchingDisabled(): bool
	{
	    return $this->get('live_patching_disabled');
	}
	
	public function getMaster(): XenHost
	{
	    return new XenHost($this->xenConnection,$this->get('master'));
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
	
	public function getPolicyNoVendorDevice(): bool
	{
	    return $this->get('policy_no_vendor_device');
	}
	
	public function getRecord(): array
	{
	    return $this->get('record');
	}
	
	public function getRedoLogRnabled(): bool
	{
	    return $this->get('redo_log_enabled');
	}
	
	public function getRedoLogVDI(): XenVirtualDiskImage
	{
	    return new XenVirtualDiskImage($this->xenConnection,$this->get('redo_log_vdi'));
	}

	public function getRestrictions(): array
	{
	    return $this->get('restrictions');
	}

	public function getSuspendImageSR(): XenStorageRepository
	{
	    return new XenStorageRepository($this->xenConnection,$this->get('suspend_image_SR'));
	}

	public function getTags(): array
	{
	    return $this->get('tags');
	}

	public function getUUID(): string
	{
	    return $this->get('uuid');
	}

	public function getWLBEnabled(): boole
	{
	    return $this->get('wlb_enabled');
	}

	public function getWLBUrl(): string
	{
	    return $this->get('wlb_url');
	}

	public function getWLBUsername(): string
	{
	    return $this->get('wlb_username');
	}

	public function getWLBVerifyCert(): bool
	{
	    return $this->get('wlb_verify_cert');
	}

	//TODO HA messages

	public function hasExtensions(string $name) : bool
	{
	    return $this->call('has_extensions', [$name]);
	}


	public function removeFromGuestAgentConfig(string $key)
	{
		$this->removeFrom('guest_agent_config', $key);
	}

	public function removeFromGUIConfig(string $key)
	{
		$this->removeFrom('gui_config', $key);
	}

	public function removeFromHealthCheckConfig(string $key)
	{
		$this->removeFrom('health_check_config', $key);
	}

	public function removeFromOtherConfig(string $key)
	{
		$this->removeFrom('other_config', $key);
	}

	public function removeTags(string $tag)
	{
		$this->call('remove_tags', [$tag]);
	}

	public function setCrashDumpSR(XenStorageRepository $value)
	{
		$this->set('crash_dump_SR', $value->getRefID());
	}

	public function setDefaultSR(XenStorageRepository $value)
	{
		$this->set('default_SR', $value->getRefID());
	}

	public function setGUIConfig(array $value)
	{
		$this->set('gui_config', $value);
	}

	public function setHAAllowOvercommit(bool $value)
	{
		$this->set('ha_allow_overcommit', $value);
	}

	public function setHAHostFailuresToTolerate(int $value)
	{
		$this->set('ha_host_failures_to_tolerate', $value);
	}

	public function setHAHostCheckConfig(array $config)
	{
		$this->set('ha_host_check_config', $config);
	}

	public function setHealthCheckConfig(array $value)
	{
		$this->set('health_check_config', $value);
	}

	public function setIGMPSnoopingEnabled(bool $value)
	{
		$this->set('igmp_snooping_enabled', $value);
	}

	public function setLivePatchingDisabled(bool $value)
	{
		$this->set('live_patching_disabled', $value);
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

	public function setPolicyNoVendorDevice(bool $value)
	{
		$this->set('policy_no_vendor_device', $value);
	}

	public function setSuspendImageSR(XenStorageRepository $sr)
	{
		$this->set('suspend_image_SR', $sr->getRefID());
	}

	public function setTags(array $tags)
	{
		$this->set('tags', $tags);
	}

	public function setWLBEnabled(bool $value)
	{
		$this->set('wlb_enabled', $value);
	}

	public function setVLBVerifyCert(bool $value)
	{
		$this->set('wlb_verify_cert', $value);
	}

	public function setTestArchiveTarget(array $config)
	{
		$this->set('test_archive_target', $config);
	}



}