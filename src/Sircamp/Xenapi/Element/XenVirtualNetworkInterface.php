<?php
/**
 * Created by PhpStorm.
 * User: Oliver
 * Date: 20.11.2017
 * Time: 09:26
 */

namespace Sircamp\Xenapi\Element;


class XenVirtualNetworkInterface extends XenElement
{
	protected $callPrefix = "VIF";

	public function addIPv4Allowed(string $ip)
	{
		$this->call('add_ipv4_allowed', [$ip]);
	}

	public function addIPv6Allowed(string $ip)
	{
		$this->call('add_ipv6_allowed', [$ip]);
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

	public function move(XenNetwork $xenNetwork)
	{
		$this->call('move', [$xenNetwork->getRefID()]);
	}

	public function plug()
	{
		$this->call('plug');
	}

	public function removeIPv4Allowed()
	{
		$this->call('remove_ipv4_allowed');
	}

	public function removeIPv6Allowed()
	{
		$this->call('remove_ipv6_allowed');
	}

	public function setIPv4Allowed(array $ips)
	{
		$this->set('ipv4_allowed', $ips);
	}

	public function setIPv6Allowed(array $ips)
	{
		$this->set('ipv6_allowed', $ips);
	}

	//TODO: implement set messages

	public function unplug()
	{
		$this->call('unplug');
	}

	public function unplugForce()
	{
		$this->call('unplug_force');
	}


}