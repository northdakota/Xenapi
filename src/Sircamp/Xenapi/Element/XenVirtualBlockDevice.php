<?php
/**
 * Created by PhpStorm.
 * User: Oliver
 * Date: 20.11.2017
 * Time: 10:43
 */

namespace Sircamp\Xenapi\Element;


class XenVirtualBlockDevice extends XenElement
{

	/**
	 * @var string
	 */
	protected $callPrefix = "VBD";

	/**
	 * @param string $key
	 * @param string $value
	 */
	public function addToOtherConfig(string $key, string $value)
	{
		$this->addTo('other_config', $key, $value);
	}

	/**
	 * @param string $key
	 * @param string $value
	 */
	public function addToQoSAlgorithmParams(string $key, string $value)
	{
		$this->addTo('qos_algorithm_params', $key, $value);
	}

	/**
	 *
	 */
	public function assertAttachable()
	{
		$this->call('assert_attachable');
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
	public function eject()
	{
		$this->call('eject');
	}

	/**
	 * @return XenVirtualDiskImage
	 */
	public function getVDI(): XenVirtualDiskImage
	{
		$refID = $this->get('VDI')->getValue();

		return new XenVirtualDiskImage($this->xenConnection, $refID);
	}

	/**
	 * @return XenVirtualMachine
	 */
	public function getVM(): XenVirtualMachine
	{
		$refID = $this->get('VM')->getValue();

		return new XenVirtualMachine($this->getXenConnection(), $refID);
	}

	/**
	 * @return array
	 */
	public function getAllowedOperations(): array
	{
		return $this->get('allowed_operations');
	}

	/**
	 * @return bool
	 */
	public function getBootable(): bool
	{
		return $this->get('bootable');
	}

	/**
	 * @return array
	 */
	public function getCurrentOperations(): array
	{
		return $this->get('current_operations');
	}

	/**
	 * @return bool
	 */
	public function getCurrentlyAttached(): bool
	{
		return $this->get('currently_attached');
	}

	/**
	 * @return string
	 */
	public function getDevice(): string
	{
		return $this->get('device');
	}

	/**
	 * @return bool
	 */
	public function getEmpty(): bool
	{
		return $this->get('empty');
	}

	//TODO: get metrics

	/**
	 * @return string
	 */
	public function getMode(): string
	{
		return $this->get('mode');
	}

	/**
	 * @return array
	 */
	public function getOtherConfig(): array
	{
		return $this->get('other_config');
	}

	/**
	 * @return array
	 */
	public function getQoSAlgorithmParams(): array
	{
		return $this->get('qos_algorithm_params');
	}

	/**
	 * @return string
	 */
	public function getQoSAlgorithmType(): string
	{
		return $this->get('qos_algorithm_type');
	}

	/**
	 * @return array
	 */
	public function getQoSSupportedAlgorithms(): array
	{
		return $this->get('qos_supported_algorithms');
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
	public function getRuntimeProperties(): array
	{
		return $this->get('runtime_properties');
	}

	/**
	 * @return int
	 */
	public function getStatusCode(): int
	{
		return $this->get('status_code');
	}

	/**
	 * @return array
	 */
	public function getStatusDetail(): array
	{
		return $this->get('status_detail');
	}

	/**
	 * @return bool
	 */
	public function getStorageLock(): bool
	{
		return $this->get('storage_lock');
	}

	/**
	 * @return string
	 */
	public function getType(): string
	{
		return $this->get('type');
	}

	/**
	 * @return bool
	 */
	public function getUnpluggable(): bool
	{
		return $this->get('unpluggable');
	}

	/**
	 * @return string
	 */
	public function getUserdevice(): string
	{
		return $this->get('userdevice');
	}

	/**
	 * @return string
	 */
	public function getUUID(): string
	{
		return $this->get('uuid');
	}

	/**
	 * @param XenVirtualDiskImage $diskImage
	 */
	public function insert(XenVirtualDiskImage $diskImage)
	{
		$this->call('insert', [$diskImage]);
	}

	/**
	 *
	 */
	public function plug()
	{
		$this->call('plug');
	}

	/**
	 * @param string $key
	 */
	public function removeFromOtherConfig(string $key)
	{
		$this->removeFrom('other_config', $key);
	}

	/**
	 * @param string $key
	 */
	public function removeFromQoSAlgorithmParams(string $key)
	{
		$this->removeFrom('qos_algorithm_params', $key);
	}

	/**
	 * @param bool $value
	 */
	public function setBootable(bool $value)
	{
		$this->set('bootable', $value);
	}

	/**
	 * @param string $mode
	 */
	public function setMode(string $mode)
	{
		$this->set('mode', $mode);
	}

	/**
	 * @param array $config
	 */
	public function setOtherConfig(array $config)
	{
		$this->set('other_config', $config);
	}

	/**
	 * @param array $config
	 */
	public function setQoSAlgorithmParams(array $config)
	{
		$this->set('qos_algorithm_params', $config);
	}

	/**
	 * @param string $type
	 */
	public function setQoSAlgorithmType(string $type)
	{
		$this->set('qos_algorithm_type', $type);
	}

	/**
	 * @param string $mode
	 */
	public function setType(string $mode)
	{
		$this->set('type', $mode);
	}

	/**
	 * @param bool $value
	 */
	public function setUnpluggable(bool $value)
	{
		$this->set('unpluggable', $value);
	}

	/**
	 * @param string $userdevice
	 */
	public function setUserdevice(string $userdevice)
	{
		$this->set('mode', $userdevice);
	}

	//TODO implement set messages

	/**
	 *
	 */
	public function unplug()
	{
		$this->call('unplug');
	}

	/**
	 *
	 */
	public function unplugForce()
	{
		$this->call('unplug_force');
	}

}