<?php namespace Sircamp\Xenapi\Element;

class XenNetwork extends XenElement
{

	protected $callPrefix = "network";

	//TODO: implement add messages
	public function addTags(string $tags)
	{
		$this->call('add_tags', [$tags]);
	}
	
	//TODO: implement add_to message

	public function create(array $network_record)
	{
		$refID = $this->call('create', [$network_record])->getValue();
		return new XenNetwork($this->getXenConnection(), $refID);
	}

	//TODO create blob message

	public function destroy()
	{
		$this->call('destroy');
	}

	//TODO: implement get messages
	public function getTags(): array
	{
		return $this->call('get_tags')->getValue();
	}

	//TODO implement remove from messages

	public function removePurpose(string $network_purpose)
	{
		$this->call('remove_purpose', [$network_purpose]);
	}

	public function remove_tags(string $tags)
	{
		$this->call('remove_tags', [$tags]);
	}

	//TODO: implement set messages

	public function setTags(array $tags = array())
	{
		$this->call('set_tags', [$tags]);
	}
}

?>
	