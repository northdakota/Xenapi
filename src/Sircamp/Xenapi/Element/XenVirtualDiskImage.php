<?php
/**
 * Created by PhpStorm.
 * User: Oliver
 * Date: 20.11.2017
 * Time: 10:44
 */

namespace Sircamp\Xenapi\Element;


class XenVirtualDiskImage extends XenElement
{

	protected $callPrefix = "VDI";

	public function addTags(string $tags)
	{
		$this->call('add_tags', [$tags]);
	}

	public function addToOtherConfig(string $key, string $value)
	{
		$this->addTo('other_config', $key, $value);
	}

	public function addToStorageManagerConfig(string $key, string $value)
	{
		$this->addTo('sm_config', $key, $value);
	}

	public function addToXenstoreData(string $key, string $value)
	{
		$this->addTo('xenstore_data', $key, $value);
	}

	public function clone(array $driver_params = array()): XenVirtualDiskImage
	{
		$refID = $this->call('clone', [$driver_params]);

		return new XenVirtualDiskImage($this->xenConnection, $refID);
	}

	public function copy(XenStorageRepository $sr = null, XenVirtualDiskImage $base_vdi = null, XenVirtualDiskImage $into_vdi = null): XenVirtualDiskImage
	{
		$refID = $this->call('copy', [$sr->getRefID(), $base_vdi->getRefID(), $into_vdi->getRefID()]);

		return new XenVirtualDiskImage($this->xenConnection, $refID);
	}

	public function dataDestroy()
	{
		$this->call('data_destroy');
	}

	public function dbForget()
	{
		$this->call('db_forget');
	}

//	private function dbIntroduce()
//	{
//		TODO Implement and make public
//	}

	public function destroy()
	{
		$this->call('destroy');
	}

	public function disableCBT()
	{
		$this->call('disable_cbt');
	}

	public function enableCBT()
	{
		$this->call('enable_cbt');
	}

	public function forget()
	{
		$this->call('forget');
	}

	public function getStorageRepository(): XenStorageRepository
	{
		$refID = $this->get('SR');

		return new XenStorageRepository($this->xenConnection, $refID);
	}

	public function getVirtualBlockDevices(): array
	{
		$refIDs   = $this->get('VBDs');
		$vbdArray = array();
		foreach ($refIDs as $refID)
		{
			$vbdArray[] = new XenVirtualBlockDevice($this->xenConnection, $refID);
		}

		return $vbdArray;
	}

	//TODO implement get messages
	//TODO: implement introduce

	public function listChangedBlocks(XenVirtualDiskImage $vdi_to): string
	{
		return $this->call('list_changed_blocks', [$vdi_to]);
	}

	//TODO implement open_database

	public function poolMigrate(XenStorageRepository $sr, array $options = array()): XenVirtualDiskImage
	{
		$refID = $this->call('pool_migrate', [$sr, $options]);

		return new XenVirtualDiskImage($this->xenConnection, $refID);
	}

	public function readDatabasePoolUUID(): string
	{
		return $this->call('read_database_pool_uuid');
	}

	public function removeFromOtherConfig(string $key)
	{
		$this->removeFrom('other_config', $key);
	}

	public function removeTags(string $key)
	{
		$this->call('remove_tags', [$key]);
	}

	public function resize(int $size)
	{
		$this->call('resize', [$size]);
	}

	public function resizeOnline(int $size)
	{
		$this->call('resize_online', [$size]);
	}

	//TODO: implement set messages

	public function setTags(array $tags)
	{
		$this->set('tags', $tags);
	}

	public function snapshot(array $driver_params = array()): XenVirtualDiskImage
	{
		$refID = $this->call('snapshot', $driver_params);

		return new XenVirtualDiskImage($this->xenConnection, $refID);
	}

	public function update()
	{
		$this->call('update');
	}
}