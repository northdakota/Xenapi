<?php
/**
 * Created by PhpStorm.
 * User: Oliver
 * Date: 19.11.2017
 * Time: 01:30
 */

namespace Sircamp\Xenapi\Element;

class XenStorageRepository extends XenElement
{

	protected $callPrefix = "SR";

	//TODO: implement add messages
	//TODO: implement add_to messages
	//TODO: implement assert messages

	//TODO: create blob
	public function destroy()
	{
		$this->call('destroy');
	}

	public function disableDatabaseReplication()
	{
		$this->call('disable_database_replication');
	}

	public function enableDatabaseReplication()
	{
		$this->call('enable_database_replication');
	}

	public function forget()
	{
		$this->call('forget');
	}

	public function forgetDataSourceArchives(string $data_source)
	{
		$this->call('forget_data_source_archives', [$data_source]);
	}

	//TODO: implement get messages
	public function introduce()
	{
		//TODO implement in XenClass
	}

	public function queryDataSource(string $data_source)
	{
		$this->call('query_data_source', [$data_source]);
	}

	public function recordDataSource(string $data_source)
	{
		$this->call('record_data_source', [$data_source]);
	}

	public function removeTags(string $value)
	{
		$this->call('remove_tags', [$value]);
	}

	public function scan()
	{
		$this->call('scan');
	}

	//TODO: implement set messages

	public function setTags(array $tags)
	{
		$this->call('set_tags', [$tags]);
	}

	public function update()
	{
		$this->call('update');
	}
}