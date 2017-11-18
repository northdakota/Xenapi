<?php namespace Sircamp\Xenapi\Element;

use GuzzleHttp\Client as Client;
use Respect\Validation\Validator as Validator;
use Sircamp\Xenapi\Connection\XenResponse as XenResponse;

class XenVirtualMachine extends XenElement
{

	protected $refID;
	protected $uuid;
	protected $name;

	public function __construct($xenConnection, $refID)
	{
		parent::__construct($xenConnection);
		$this->refID = $refID;
		$this->name  = $this->getNameLabel()->getValue();
		$this->uuid  = $this->getUUID()->getValue();
	}

	/**
	 * Hard Reboot a VM by passing her uuid.
	 *
	 * @param mixed $VM the uuid of VM
	 *
	 * @return mixed
	 */
	public function hardReboot()
	{
		return $this->getXenConnection()->VM__hard_reboot($this->getRefID());
	}

	/**
	 * Shutdown a VM by passing her uuid.
	 *
	 * @param mixed $VM the uuid of VM
	 *
	 * @return mixed
	 */
	public function hardShutdown()
	{
		return $this->getXenConnection()->VM__hard_shutdown($this->getRefID());
	}

	/**
	 * Suspend a VM by passing her uuid.
	 *
	 * @param mixed $VM the uuid of VM
	 *
	 * @return mixed
	 */
	public function suspend()
	{
		return $this->getXenConnection()->VM__suspend($this->getRefID());
	}

	/**
	 * Resume a VM by passing her uuid.
	 *
	 * @param mixed $VM the uuid of VM
	 *
	 * @return mixed
	 */
	public function resume()
	{
		return $this->getXenConnection()->VM__resume($this->getRefID());
	}

	/**
	 * Awaken the specified VM and resume it on a particular Host. This can only be called when the
	 * specified VM is in the Suspended state.
	 *
	 * @param mixed $VM the uuid of VM, $hostRef the ref of host whic resume the VM
	 *
	 * @return mixed
	 */
	public function resumeOn($hostRef = null)
	{
		$hostRefString = "";
		if ($hostRef == null)
		{
			throw new \IllegalArgumentException("hostRef must be not NULL", 1);

		}
		else
		{
			if (is_object($hostRef))
			{
				$hostRefString = $hostRef->getHostId();
			}
			else
			{
				$hostRefString = $hostRef;
			}
		}

		return $this->getXenConnection()->VM__resume_on($this->getRefID(), $hostRefString);
	}

	/**
	 * Migrate a VM to another Host. This can only be called when the specified VM is in the Running
	 * state.
	 *
	 * @param mixed $VM the uuid of VM, $hostRef the target host
	 *                  $optionsMap  Extra configuration operations
	 *
	 * @return mixed
	 */

	public function poolMigrate($hostRef = null, $optionsMap = array())
	{
		$hostRefString = "";
		if ($hostRef == null)
		{
			throw new \IllegalArgumentException("hostRef must be not NULL", 1);

		}
		else
		{
			if (is_object($hostRef))
			{
				$hostRefString = $hostRef->getHostId();
			}
			else
			{
				$hostRefString = $hostRef;
			}
		}

		return $this->getXenConnection()->VM__pool_migrate($this->getRefID(), $hostRefString, $optionsMap);
	}

	/**
	 * Migrate the VM to another host. This can only be called when the specified VM is in the Running
	 * state.
	 *
	 * @param mixed $VM the uuid of VM,
	 *                  $def The result of a Host.migrate receive call.
	 *                  $live The Live migration
	 *                  $vdiMap of source VDI to destination SR
	 *                  $vifMap of source VIF to destination network
	 *                  $optionsMap  Extra configuration operations
	 *
	 * @return mixed
	 */

	public function migrateSend($dest, $vdiMap, $vifMap, $options, $live = false)
	{
		return $this->getXenConnection()->VM__migrate_send($this->getRefID(), $dest, $live, $vdiMap, $vifMap, $options);
	}


	/**
	 * Assert whether a VM can be migrated to the specified destination.
	 *
	 * @param mixed $VM the uuid of VM,
	 *                  $def The result of a Host.migrate receive call.
	 *                  $live The Live migration
	 *                  $vdiMap of source VDI to destination SR
	 *                  $vifMap of source VIF to destination network
	 *                  $optionsMap  Extra configuration operations
	 *
	 * @return mixed
	 */
	public function assertCanMigrate($dest, $vdiMap, $vifMap, $options, $live = false)
	{
		return $this->getXenConnection()->VM__assert_can_migrate($this->getRefID(), $dest, $live, $vdiMap, $vifMap, $options);
	}

	/**
	 * Clean Reboot a VM by passing her uuid.
	 *
	 * @param mixed $VM the uuid of VM
	 *
	 * @return mixed
	 */
	public function cleanReboot()
	{
		return $this->getXenConnection()->VM__clean_reboot($this->getRefID());
	}

	/**
	 * Clean Shutdown a VM by passing her uuid.
	 *
	 * @param mixed $VM the uuid of VM
	 *
	 * @return mixed
	 */
	public function cleanShutdown()
	{
		return $this->getXenConnection()->VM__clean_shutdown($this->getRefID());
	}


	/**
	 * Pause a VM by passing her uuid.
	 *
	 * @param mixed $VM the uuid of VM
	 *
	 * @return mixed
	 */
	public function pause()
	{
		return $this->getXenConnection()->VM__pause($this->getRefID());
	}

	/**
	 * UnPause a VM by passing her uuid.
	 *
	 * @param mixed $VM the uuid of VM
	 *
	 * @return mixed
	 */
	public function unpuse()
	{
		return $this->getXenConnection()->VM__unpause($this->getRefID());
	}


	/**
	 * Start a VM by passing her uuid.
	 *
	 * @param mixed $VM the uuid of VM,
	 *                  $pause Instantiate VM in paused state if set to true.
	 *                  Attempt to force the VM to start. If this flag
	 *                  is false then the VM may fail pre-boot safety
	 *                  checks (e.g. if the CPU the VM last booted
	 *                  on looks substantially different to the current one)
	 *
	 * @return mixed
	 */
	public function start($pause = false, $force = true)
	{

		return $this->getXenConnection()->VM__start($this->getRefID(), $pause, $force);
	}

	/**
	 * Start the specified VM on a particular host. This function can only be called with the VM is in
	 * the Halted State.
	 *
	 * @param mixed $VM the uuid of VM, $hostRef the Host on which to start the VM
	 *                  $pause Instantiate VM in paused state if set to true.
	 *                  Attempt to force the VM to start. If this flag
	 *                  is false then the VM may fail pre-boot safety
	 *                  checks (e.g. if the CPU the VM last booted
	 *                  on looks substantially different to the current one)
	 *
	 * @return mixed
	 */
	public function startOn($hostRef, $pause = false, $force = true)
	{

		$hostRefString = "";
		if ($hostRef == null)
		{
			throw new \IllegalArgumentException("The where you want start new machine, must be set!", 1);

		}
		else
		{
			if (is_object($hostRef))
			{
				$hostRefString = $hostRef->getHostId();
			}
			else
			{
				$hostRefString = $hostRef;
			}
		}

		return $this->getXenConnection()->VM__start_on($this->getRefID(), $hostRefString, $pause, $force);
	}

	/**
	 * Clone a VM by passing her uuid.
	 *
	 * @param mixed $VM the uuid of VM and $name the name of cloned vM
	 *
	 * @return mixed
	 */
	public function clonevm($name)
	{
		return $this->getXenConnection()->VM__clone($this->getRefID(), $name);
	}

	/**
	 * Get the UUID of a VM .
	 *
	 * @param
	 *
	 * @return mixed
	 */
	function getUUID()
	{
		return $this->getXenConnection()->VM__get_uuid($this->getRefID());
	}

	/**
	 * Get the consoles instances a VM by passing her uuid.
	 *
	 * @param
	 *
	 * @return mixed
	 */
	function getConsoles()
	{
		return $this->getXenConnection()->VM__get_consoles($this->getRefID());
	}

	/**
	 * Get the console UIID of a VM by passing her uuid.
	 *
	 * @param mixed $CN the uuid of conosle of VM
	 *
	 * @return mixed
	 */
	function getConsoleUUID($CN)
	{
		return $this->getXenConnection()->console__get_uuid($CN);
	}

	/**
	 * Get th VM status by passing her uuid.
	 *
	 * @param mixed $VM the uuid of VM and $name the name of cloned vM
	 *
	 * @return mixed
	 */
	function getPowerState()
	{
		return $this->getXenConnection()->VM__get_power_state($this->getRefID());
	}

	/**
	 * Reset the power-state of the VM to halted in the database only. (Used to recover from slave failures
	 * in pooling scenarios by resetting the power-states of VMs running on dead slaves to halted.) This
	 *  is a potentially dangerous operation; use with care.
	 *
	 * @param mixed $VM the uuid of VM and $name the name of cloned vM
	 *
	 * @return mixed
	 */
	function powerStateReset()
	{
		return $this->getXenConnection()->VM__power_state_reset($this->getRefID());
	}


	/**
	 * Get the VM guest metrics by passing her uuid.
	 *
	 * @param mixed $VM the uuid of VM and $name the name of cloned vM
	 *
	 * @return mixed
	 */
	function getGuestMetrics()
	{
		$VMG = $this->getXenConnection()->VM__get_guest_metrics($this->getRefID());

		return $this->getXenConnection()->VM_guest_metrics__get_record($VMG->getValue());
	}

	/**
	 * Get the VM metrics by passing her uuid.
	 *
	 * @param mixed $VM the uuid of VM and $name the name of cloned vM
	 *
	 * @return mixed
	 */
	function getMetrics()
	{
		$VMG = $this->getXenConnection()->VM__get_metrics($this->getRefID());

		return $this->getXenConnection()->VM_metrics__get_record($VMG->getValue());
	}


	/**
	 * Get the VM stats by passing her uuid.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	function getStats()
	{

		$user     = $this->getXenConnection()->getUser();
		$password = $this->getXenConnection()->getPassword();
		$ip       = $this->getXenConnection()->getUrl();
		$uuid     = $this->getUUID($this->getRefID());

		$url = 'http://' . $user . ':' . $password . '@' . $ip . '/vm_rrd?uuid=' . $uuid->getValue() . '&start=1000000000‏';


		$client   = new Client();
		$response = $client->get($url);

		$body = $response->getBody();
		$xml  = "";

		while (!$body->eof())
		{
			$xml .= $body->read(1024);
		}

		$response = new XenResponse(array('Value' => array(0 => '')));

		if (Validator::string()->validate($xml))
		{
			$response = new XenResponse(array('Value' => $xml, 'Status' => 'Success'));
		}
		else
		{
			$response = new XenResponse(array('Value' => '', 'Status' => 'Failed'));
		}

		return $response;
	}

	/**
	 * Get the VM disk space by passing her uuid.
	 *
	 * @param mixe $size the currency of size of disk space
	 *
	 * @return XenResponse $response
	 */
	function getDiskSpace($size = null)
	{
		$VBD    = $this->getXenConnection()->VBD__get_all();
		$memory = 0;
		foreach ($VBD->getValue() as $bd)
		{
			$responsevm   = $this->getXenConnection()->VBD__get_VM($bd);
			$responsetype = $this->getXenConnection()->VBD__get_type($bd);

			if ($responsevm->getValue() == $this->getRefID() && $responsetype->getValue() == "Disk")
			{
				$VDI    = $this->getXenConnection()->VBD__get_VDI($bd);
				$memory += intval($this->getXenConnection()->VDI__get_virtual_size($VDI->getValue())->getValue());
			}
		}

		$response = null;
		if (Validator::numeric()->validate($memory))
		{

			return new XenResponse(array('Value' => $memory, 'Status' => 'Success'));
		}
		else
		{
			return new XenResponse(array('Value' => 0, 'Status' => 'Failed'));
		}

		return $response;
	}

	/**
	 * Gets the value of name.
	 *
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Sets the value of name.
	 *
	 * @param mixed $name the name
	 *
	 * @return self
	 */
	private function _setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * Gets the value of vmId.
	 *
	 * @return mixed
	 */
	public function getRefID()
	{
		return $this->refID;
	}

	/**
	 * Sets the value of vmId.
	 *
	 * @param mixed $vmId the vm id
	 *
	 * @return self
	 */
	private function _setVmId($vmId)
	{
		$this->refID = $vmId;

		return $this;
	}

	/**
	 * Snapshots the specified VM, making a new VM.
	 * Snapshot automatically exploits the capabilities of the underlying storage repository
	 * in which the VM’s disk images are stored
	 *
	 * @param string $name the name of snapshot
	 *
	 * @return XenResponse $response
	 */
	public function snapshot($name)
	{
		return $this->getXenConnection()->VM__snapshot($this->getRefID(), $name);
	}

	//TOFIX

	/**
	 * Snapshots the specified VM with quiesce, making a new VM.
	 * Snapshot automatically exploits the capabilities of the underlying
	 * storage repository in which the VM’s disk images are stored
	 *
	 * @param string $name the name of snapshot
	 *
	 * @return XenResponse $response
	 */
	public function snapshotWithQuiesce($name)
	{
		return $this->getXenConnection()->VM__snapshot_with_quiesce($this->getRefID(), $name);
	}

	/**
	 * Get the snapshot info field of the given VM.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getSnapshotInfo()
	{
		return $this->getXenConnection()->VM__get_snapshot_info($this->getRefID());
	}


	/**
	 * Copied the specified VM, making a new VM. Unlike clone, copy does not exploits the capabilities
	 * of the underlying storage repository in which the VM’s disk images are stored. Instead, copy
	 * guarantees that the disk images of the newly created VM will be ’full disks’ - i.e. not part of a
	 * CoW chain. This function can only be called when the VM is in the Halted State
	 *
	 * @param string $name the name of new vm
	 *
	 * @return XenResponse $response
	 */
	public function copy($name)
	{
		return $this->getXenConnection()->VM__copy($this->getRefID(), $name, "");
	}


	/**
	 * Destroy the specified VM. The VM is completely removed from the system. This function can
	 * only be called when the VM is in the Halted State.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function destroy()
	{
		return $this->getXenConnection()->VM__destroy($this->getRefID());
	}

	/**
	 * Reverts the specified VM to a previous state
	 *
	 * @param string $snapshotID the ID of snapshot
	 *
	 * @return XenResponse $response
	 */
	public function revert($snapshotID)
	{
		return $this->getXenConnection()->VM__revert($this->getRefID(), $snapshotID);
	}

	/**
	 * Checkpoints the specified VM, making a new VM. Checkpoint automatically exploits the capabil-
	 * ities of the underlying storage repository in which the VM’s disk images are stored (e.g. Copy on
	 * Write) and saves the memory image as well
	 *
	 * @param string $name the name of new VPS
	 *
	 * @return XenResponse $response
	 */
	public function checkpoint($name)
	{
		return $this->getXenConnection()->VM__checkpoint($this->getRefID(), $name);
	}


	/**
	 * Set this VM’s start delay in seconds.
	 *
	 * @param int seconds of delay
	 *
	 * @return XenResponse $response
	 */
	public function setStartDelay($seconds)
	{
		return $this->getXenConnection()->VM__set_start_delay($this->getRefID(), $seconds);
	}

	/**
	 * Set this VM’s start delay in seconds.
	 *
	 * @param int seconds of delay
	 *
	 * @return XenResponse $response
	 */
	public function setShutdownDelay($seconds)
	{
		return $this->getXenConnection()->VM__set_shutdown_delay($this->getRefID(), $seconds);
	}

	/**
	 * Get the start delay field of the given VM.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getStartDelay()
	{
		return $this->getXenConnection()->VM__get_start_delay($this->getRefID());
	}

	/**
	 * Get the shutdown delay field of the given VM.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getShutdownDelay()
	{
		return $this->getXenConnection()->VM__get_shutdown_delay($this->getRefID());
	}

	/**
	 * Get the current operations field of the given VM.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getCurrentOperations()
	{
		return $this->getXenConnection()->VM__get_current_operations($this->getRefID());
	}

	/**
	 * Get the allowed operations field of the given VM.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getAllowedOperations()
	{
		return $this->getXenConnection()->VM__get_allowed_operations($this->getRefID());
	}


	/**
	 * Get the name/description field of the given VM.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getNameDescription()
	{
		return $this->getXenConnection()->VM__get_name_description($this->getRefID());
	}

	/**
	 * Set the name/description field of the given VM.
	 *
	 * @param string name
	 *
	 * @return XenResponse $response
	 */
	public function setNameDescription($name)
	{
		return $this->getXenConnection()->VM__set_name_description($this->getRefID(), $name);
	}

	/**
	 * Get the is a template field of the given VM.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getIsATemplate()
	{
		return $this->getXenConnection()->VM__get_is_a_template($this->getRefID());
	}

	/**
	 * Set the is a template field of the given VM.
	 *
	 * @param bool $template
	 *
	 * @return XenResponse $response
	 */
	public function setIsATemplate($template)
	{
		return $this->getXenConnection()->VM__set_is_a_template($this->getRefID(), $template);
	}


	/**
	 * Get the resident on field of the given VM.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getResidentOn()
	{
		$xenHost  = null;
		$response = $this->getXenConnection()->VM__get_resident_on($this->getRefID());
		if ($response->getValue() != "")
		{
			$xenHost = new XenHost($this->getXenConnection(), null, $response->getValue());
			$name    = $xenHost->getNameLabel()->getValue();
			$xenHost->_setName($name);
		}
		$response->_setValue($xenHost);

		return $response;
	}

	/**
	 * Get the platform field of the given VM.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getPlatform()
	{
		return $this->getXenConnection()->VM__get_platform($this->getRefID());
	}


	/**
	 * Set the platform field of the given VM.
	 *
	 * @param $value array
	 *
	 * @return XenResponse $response
	 */
	public function setPlatform($value = array())
	{
		return $this->getXenConnection()->VM__set_platform($this->getRefID(), $value);
	}


	/**
	 * Get the other config field of the given VM.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getOtherConfig()
	{
		return $this->getXenConnection()->VM__get_other_config($this->getRefID());
	}

	/**
	 * Set the other config field of the given VM.
	 *
	 * @param $value array
	 *
	 * @return XenResponse $response
	 */
	public function setOtherConfig($array = array())
	{
		return $this->getXenConnection()->VM__set_other_config($this->getRefID(), $array);
	}

	/**
	 * Add the given key-value pair to the other config field of the given vm.
	 *
	 * @param $key string
	 *
	 * @return XenResponse $response
	 */
	public function addToOtherConfig($key, $value)
	{
		return $this->getXenConnection()->VM__add_to_other_config($this->getRefID(), $key, $value);
	}

	/**
	 * Remove the given key and its corresponding value from the other config field of the given vm. If
	 * the key is not in that Map, then do nothing.
	 *
	 * @param $key string
	 *
	 * @return XenResponse $response
	 */
	public function removeFromOtherConfig($key)
	{
		return $this->getXenConnection()->VM__remove_from_other_config($this->getRefID(), $key);
	}

	/**
	 * Get name label VM.
	 *
	 * @param
	 *
	 * @return XenResponse $response
	 */
	public function getNameLabel()
	{
		return $this->getXenConnection()->VM__get_name_label($this->getRefID());
	}

}

?>
	
