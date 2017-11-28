<?php
/**
 * Created by PhpStorm.
 * User: Oliver
 * Date: 20.11.2017
 * Time: 14:45
 */

namespace Sircamp\Xenapi\Element;


class XenVirtualLAN extends XenElement
{
	protected $callPrefix = "VLAN";

	public function addToOtherConfig(string $key, string $value)
	{
		$this->addTo('other_config', $key, $value);
	}

	public function destroy()
	{
		$this->call('destroy');
	}

	public function getOtherConfig(): array
	{
		return $this->get('other_config');
	}

	public function getRecord(): array
	{
		return $this->get('record');
	}

	public function getTag(): int
	{
		return $this->get('tag');
	}

	public function getTaggedPhysicalInterface(): XenPhysicalInterface
	{
		$refID = $this->get('tagged_PIF');

		return new XenPhysicalInterface($this->xenConnection, $refID);
	}

	public function getUntaggedPhysicalInterface(): XenPhysicalInterface
	{
		$refID = $this->get('untagged_PIF');

		return new XenPhysicalInterface($this->xenConnection, $refID);
	}

	public function getUUID(): string
	{
		return $this->get('uuid');
	}

	public function removeFromOtherConfig(string $key)
	{
		$this->removeFrom('other_config', $key);
	}

	public function setOtherConfig(array $config)
	{
		$this->set('other_config', $config);
	}

}