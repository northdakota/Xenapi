<?php
/**
 * Created by PhpStorm.
 * User: Oliver
 * Date: 19.11.2017
 * Time: 01:01
 */

namespace Sircamp\Xenapi\Exception;


class XenException extends \Exception
{

	protected $errorArray;

	public function __construct(array $errorArray, $code)
	{
		$this->errorArray = $errorArray;
		$message = print_r($errorArray, true);
		parent::__construct($message, $code);
	}

	/**
	 * @return array
	 */
	public function getErrorArray(): array
	{
		return $this->errorArray;
	}

}