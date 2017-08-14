<?php

namespace HisInOneProxy\System\Console;
/**
 * Class FunctionObject
 * @package HisInOneProxy\System\Console
 */
class FunctionObject
{
	/**
	 * @var string
	 */
	protected $id;

	/**
	 * @var string
	 */
	protected $function;

	/**
	 * @var string
	 */
	protected $comment;

	/**
	 * @var boolean
	 */
	protected $debug = false;

	/**
	 * @return string
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param string $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return string
	 */
	public function getFunction()
	{
		return $this->function;
	}

	/**
	 * @param string $function
	 */
	public function setFunction($function)
	{
		$this->function = $function;
	}

	/**
	 * @return string
	 */
	public function getComment()
	{
		return $this->comment;
	}

	/**
	 * @param string $comment
	 */
	public function setComment($comment)
	{
		$this->comment = $comment;
	}

	/**
	 * @return bool
	 */
	public function isDebug()
	{
		return $this->debug;
	}

	/**
	 * @param bool $debug
	 */
	public function setDebug($debug)
	{
		$this->debug = $debug;
	}
}