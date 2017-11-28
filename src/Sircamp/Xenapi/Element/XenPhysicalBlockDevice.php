<?php
/**
 * Created by PhpStorm.
 * User: Oliver
 * Date: 20.11.2017
 * Time: 10:50
 */

namespace Sircamp\Xenapi\Element;


class XenPhysicalBlockDevice extends XenElement
{
	protected $callPrefix = "PBD";

	public function addToOtherConfig(string $key, string $value)
	{
		$this->addTo('other_config', $key, $value);
	}

	public function destroy()
	{
		$this->call('destroy');
	}

	public function getStorageRepository(): XenStorageRepository
	{
		return $this->get('SR');
	}

	public function getCurrentlyAttached(): bool
	{
		return $this->get('currently_attached');
	}

	public function getDeviceConfig(): array
	{
		return $this->get('device_config');
	}

	public function getHost(): XenHost
	{
		$refID = $this->get('host');

		return new XenHost($this->xenConnection, $refID);
	}

	public function getOtherConfig(): array
	{
		return $this->get('other_config');
	}

	public function getRecord(): array
	{
		return $this->get('record');
	}

	public function getUUID(): string
	{
		return $this->get('uuid');
	}

	public function plug()
	{
		$this->call('plug');
	}

	public function removeFromOtherConfig(string $key)
	{
		$this->removeFrom('other_config', $key);
	}

	public function setDeviceConfig(array $config)
	{
		$this->set('device_config', $config);
	}

	public function setOtherConfig(array $config)
	{
		$this->set('other_config', $config);
	}

	public function unplug()
	{
		$this->call('unplug');
	}
}