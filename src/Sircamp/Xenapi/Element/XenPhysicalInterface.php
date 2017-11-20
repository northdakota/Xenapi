<?php
/**
 * Created by PhpStorm.
 * User: Oliver
 * Date: 20.11.2017
 * Time: 10:18
 */

namespace Sircamp\Xenapi\Element;


class XenPhysicalInterface extends XenElement
{

	protected $callPrefix = "PIF";

	public function dbForget()
	{
		$this->call('db_forget');
	}

	//TODO: implement db_introduce

	public function forget()
	{
		$this->call('forget');
	}

	//TODO: implement get messages
	public function introduce()
	{
		//TODO: implement static or in xen
	}

	public function plug()
	{
		$this->call('plug');
	}

	public function reconfigureIP(string $mode, string $ip, string $netmask, string $gateway, string $dns)
	{
		$this->call('reconfigure_ip', [$mode, $ip, $netmask, $gateway, $dns]);
	}

	public function reconfigureIPv6(string $mode, string $ip, string $gateway, string $dns)
	{
		$this->call('reconfigure_ipv6', [$mode, $ip, $gateway, $dns]);
	}

	public function scan()
	{
		//TODO: implement
	}

	public function unplug()
	{
		$this->call('unplug');
	}
}