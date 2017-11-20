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

	protected $callPrefix = "VBD";

	public function addToOtherConfig(string $key, string $value)
	{
		$this->addTo('other_config', $key, $value);
	}

	public function assertAttachable()
	{
		$this->call('assert_attachable');
	}

	public function destroy()
	{
		$this->call('destroy');
	}

	public function eject()
	{
		$this->call('eject');
	}

	public function getVDI(): XenVirtualDiskImage
	{
		$refID = $this->call('get_VDI')->getValue();

		return new XenVirtualDiskImage($this->xenConnection, $refID);
	}

	public function getVM(): XenVirtualMachine
	{
		$refID = $this->call('get_VM')->getValue();

		return new XenVirtualMachine($this->getXenConnection(), $refID);
	}

	public function insert(XenVirtualDiskImage $diskImage)
	{
		$this->call('insert', [$diskImage]);
	}

	public function plug()
	{
		$this->call('plug');
	}

	//TODO: implement remove from messages
	//TODO implement set messages
	public function unplug()
	{
		$this->call('unplug');
	}

	public function unplugForce()
	{
		$this->call('unplug_force');
	}

}