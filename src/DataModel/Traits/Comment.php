<?php

namespace HisInOneProxy\DataModel\Traits;
/**
 * Trait Comment
 * @package HisInOneProxy\DataModel\Traits
 */
trait Comment
{
	/**
	 * @var string
	 */
	protected $text;

	/**
	 * @var string
	 */
	protected $short_comment;

	/**
	 * @return string
	 */
	public function getComment()
	{
		return $this->text;
	}

	/**
	 * @param string $text
	 */
	public function setComment($text)
	{
		$this->text = $text;
	}

	/**
	 * @return string
	 */
	public function getShortComment()
	{
		return $this->short_comment;
	}

	/**
	 * @param string $short_comment
	 */
	public function setShortComment($short_comment)
	{
		$this->short_comment = $short_comment;
	}
}
