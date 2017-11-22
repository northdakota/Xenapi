<?php
/**
 * Created by PhpStorm.
 * User: Oliver
 * Date: 20.11.2017
 * Time: 10:18
 */

namespace Sircamp\Xenapi\Element;


/**
 * Class XenPhysicalInterface
 * @package Sircamp\Xenapi\Element
 */
class XenPhysicalInterface extends XenElement
{

	/**
	 * @var string
	 */
	protected $callPrefix = "PIF";

	/**
	 * @param string $key
	 * @param string $value
	 */
	public function addToOtherConfig(string $key, string $value)
	{
		$this->addTo('other_config', $key, $value);
	}

	/**
	 *
	 */
	public function dbForget()
	{
		$this->call('db_forget');
	}

	//TODO: implement db_introduce

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
	public function forget()
	{
		$this->call('forget');
	}

	/**
	 * @return string
	 */
	public function getDNS(): string
	{
		return $this->get('DNS');
	}

	/**
	 * @return string
	 */
	public function getIP(): string
	{
		return $this->get('IP');
	}

	/**
	 * @return array
	 */
	public function getIPv6(): array
	{
		return $this->get('IPv6');
	}

	/**
	 * @return string
	 */
	public function getMAC(): string
	{
		return $this->get('MAC');
	}

	/**
	 * @return int
	 */
	public function getMTU(): int
	{
		return $this->get('MTU');
	}

	/**
	 * @return int
	 */
	public function getVLAN(): int
	{
		return $this->get('VLAN');
	}

	/**
	 * @return XenVirtualLAN
	 */
	public function getVLANMasterOf(): XenVirtualLAN
	{
		return new XenVirtualLAN($this->xenConnection, $this->get('VLAN_master_of'));
	}

	/**
	 * @return array
	 */
	public function getVLANSlaveOf(): array
	{
		$refIDs  = $this->get('VLAN_slave_of');
		$vlanArr = array();

		foreach ($refIDs as $refID)
		{
			$vlanArr[] = new XenVirtualLAN($this->xenConnection, $refID);
		}

		return $vlanArr;
	}

	//TODO implement Bond

	/**
	 * @return array
	 */
	public function getcCapabilities(): array
	{
		return $this->get('capabilities');
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
	public function getDisallowUnplug(): bool
	{
		return $this->get('disallow_unplug');
	}

	/**
	 * @return string
	 */
	public function getGateway(): string
	{
		return $this->get('gateway');
	}

	/**
	 * @return XenHost
	 */
	public function getHost(): XenHost
	{
		return new XenHost($this->xenConnection, $this->get('host'));
	}

	/**
	 * @return string
	 */
	public function getIGMPConfigurationMode(): string
	{
		return $this->get('igmp_configuration_mode');
	}

	/**
	 * @return string
	 */
	public function getIPConfigurationMode(): string
	{
		return $this->get('ip_configuration_mode');
	}

	/**
	 * @return string
	 */
	public function getIPv6ConfigurationMode(): string
	{
		return $this->get('ipv6_configuration_mode');
	}

	/**
	 * @return string
	 */
	public function getIPv6Gateway(): string
	{
		return $this->get('ipv6_gateway');
	}

	/**
	 * @return bool
	 */
	public function getManaged(): bool
	{
		return $this->get('managed');
	}

	/**
	 * @return bool
	 */
	public function getManagement(): bool
	{
		return $this->get('management');
	}

	//TODO implement metrics

	/**
	 * @return string
	 */
	public function getNetmask(): string
	{
		return $this->get('netmask');
	}

	/**
	 * @return XenNetwork
	 */
	public function getNetwork(): XenNetwork
	{
		return new XenNetwork($this->xenConnection, $this->get('network'));
	}

	/**
	 * @return array
	 */
	public function getOtherConfig(): array
	{
		return $this->get('other_config');
	}

	/**
	 * @return bool
	 */
	public function getPhysical(): bool
	{
		return $this->get('physical');
	}

	/**
	 * @return string
	 */
	public function getPrimaryAddressType(): string
	{
		return $this->get('primary_address_type');
	}

	/**
	 * @return array
	 */
	public function getProperties(): array
	{
		return $this->get('properties');
	}

	//TODO implement tunnel

	/**
	 * @return string
	 */
	public function getUUID(): string
	{
		return $this->get('uuid');
	}

	/**
	 *
	 */
	public function plug()
	{
		$this->call('plug');
	}

	/**
	 * @param string $mode
	 * @param string $ip
	 * @param string $netmask
	 * @param string $gateway
	 * @param string $dns
	 */
	public function reconfigureIP(string $mode, string $ip, string $netmask, string $gateway, string $dns)
	{
		$this->call('reconfigure_ip', [$mode, $ip, $netmask, $gateway, $dns]);
	}

	/**
	 * @param string $mode
	 * @param string $ip
	 * @param string $gateway
	 * @param string $dns
	 */
	public function reconfigureIPv6(string $mode, string $ip, string $gateway, string $dns)
	{
		$this->call('reconfigure_ipv6', [$mode, $ip, $gateway, $dns]);
	}

	/**
	 * @param string $key
	 */
	public function removeFromOtherConfig(string $key)
	{
		$this->removeFrom('other_config', $key);
	}

	/**
	 * @param bool $value
	 */
	public function setDisallowUnplug(bool $value)
	{
		$this->set('disallow_unplug', $value);
	}

	/**
	 * @param array $value
	 */
	public function setOtherConfig(array $value)
	{
		$this->set('other_config', $value);
	}

	/**
	 * @param string $value
	 */
	public function setPrimaryAddressType(string $value)
	{
		$this->set('primary_address_type', $value);
	}

	/**
	 * @param string $name
	 * @param string $value
	 */
	public function setProperty(string $name, string $value)
	{
		$this->call('set_property', [$name, $value]);
	}

	/**
	 * Attempt to bring down a physical interface
	 */
	public function unplug()
	{
		$this->call('unplug');
	}

}