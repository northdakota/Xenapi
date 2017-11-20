<?php
/**
 * Created by PhpStorm.
 * User: Oliver
 * Date: 20.11.2017
 * Time: 21:09
 */

namespace Sircamp\Xenapi\Element;


class XenVirtualInterface extends XenElement
{
	protected $callPrefix = "VIF";

	public function addIPv4Allowed(string $address)
	{
		$this->call('add_ipv4_allowed', [$address]);
	}

	public function addIPv6Allowed(string $address)
	{
		$this->call('add_ipv6_allowed', [$address]);
	}

	public function addToOtherConfig(string $key, string $value)
	{
		$this->addTo('other_config', $key, $value);
	}

	public function addToQosAlgorithmParams(string $key, string $value)
	{
		$this->addTo('qos_algorithm_params', $key, $value);
	}

	public function configureIPv4(string $mode, string $address, string $gateway)
	{
		$this->call('configure_ipv4', [$mode, $address, $gateway]);
	}

	public function configureIPv6(string $mode, string $address, string $gateway)
	{
		$this->call('configure_ipv6', [$mode, $address, $gateway]);
	}

	public function destroy()
	{
		$this->call('destroy');
	}

	//TODO implement get messages
	public function getMAC(): string
	{
		return $this->get('MAC');
	}

	public function getMACAutogenerated(): bool
	{
		return $this->get('MAC_autogenerated');
	}

	public function getMTU(): int
	{
		return $this->get('MTU');
	}

	public function getVM(): XenVirtualMachine
	{
		$refID = $this->get('VM');

		return new XenVirtualMachine($this->xenConnection, $refID);
	}

	public function getAllowedOperations(): array
	{
		return $this->get('allowed_operations');
	}

	public function getCurrentOperations(): array
	{
		return $this->get('current_operations');
	}

	public function getCurrentlyAttached(): bool
	{
		return $this->get('currently_attached');
	}

	public function getDevice(): string
	{
		return $this->get('device');
	}

	public function getIPv4Addresses(): array
	{
		return $this->get('ipv4_addresses');
	}

	public function getIPv4Allowed(): array
	{
		return $this->get('ipv4_allowed');
	}

	public function getIPv4ConfigurationMode(): string
	{
		return $this->get('ipv4_configuration_mode');
	}

	public function getIPv4Gateway(): string
	{
		return $this->get('ipv4_gateway');
	}

	public function getIPv6Addresses(): array
	{
		return $this->get('ipv6_addresses');
	}

	public function getIPv6Allowed(): array
	{
		return $this->get('ipv6_allowed');
	}

	public function getIPv6ConfigurationMode(): string
	{
		return $this->get('ipv6_configuration_mode');
	}

	public function getIPv6Gateway(): string
	{
		return $this->get('ipv6_gateway');
	}

	public function getLockingMode(): string
	{
		return $this->get('locking_mode');
	}

	public function getNetwork(): XenNetwork
	{
		return new XenNetwork($this->xenConnection, $this->get('network'));
	}

	public function getOtherConfig(): array
	{
		return $this->get('other_config');
	}

	public function getQosAlgorithmParams(): array
	{
		return $this->get('qos_algorithm_params');
	}

	public function getRecord(): array
	{
		return $this->get('record');
	}

	public function getRuntimeProperties(): array
	{
		return $this->get('runtime_properties');
	}

	public function getStatusCode(): int
	{
		return $this->get('status_code');
	}

	public function getStatusDetail(): array
	{
		return $this->get('status_detail');
	}

	public function getUUID(): string
	{
		return $this->get('uuid');
	}

	public function move(XenNetwork $network)
	{
		$this->call('move', [$network->getRefID()]);
	}

	public function plug()
	{
		$this->call('plug');
	}

	public function removeFromOtherConfig(string $key)
	{
		$this->removeFrom('other_config', $key);
	}

	public function removeIPv4Allowed(string $address)
	{
		$this->call('remove_ipv4_allowed', [$address]);
	}

	public function removeIPv6Allowed(string $address)
	{
		$this->call('remove_ipv6_allowed', [$address]);
	}

	public function setIPv4Allowed(array $addresses)
	{
		$this->call('set_ipv4_allowed', [$addresses]);
	}

	public function setIPv6Allowed(array $addresses)
	{
		$this->call('set_ipv6_allowed', [$addresses]);
	}

	public function setLockingMode(string $mode)
	{
		$this->call('set_locking_mode', [$mode]);
	}

	public function setOtherConfig(array $config)
	{
		$this->call('set_other_config', [$config]);
	}

	public function setQosAlgorithmParams(array $config)
	{
		$this->call('set_qos_algorithm_params', [$config]);
	}

	public function setQosAlgorithmType(string $type)
	{
		$this->call('set_qos_algorithm_type', [$type]);
	}

	public function unplug()
	{
		$this->call('unplug');
	}

	public function unplugForce()
	{
		$this->call('unplug_force');
	}
}