<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;

class Person
{
	use Traits\GenderId, Traits\ObjGuid, Traits\SortingOrder, Traits\Text;

	/**
	 * @var string
	 */
	protected $first_name;

	/**
	 * @var string
	 */
	protected $all_first_names;

	/**
	 * @var string
	 */
	protected $sur_name;

	/**
	 * @var string
	 */
	protected $date_of_birth;

	/**
	 * @var string
	 */
	protected $birth_name;

	/**
	 * @var string
	 */
	protected $artist_name;

	/**
	 * @var string
	 */
	protected $name_prefix;

	/**
	 * @var string
	 */
	protected $name_suffix;

	/**
	 * @var string
	 */
	protected $academic_degree_suffix;

	/**
	 * @var string
	 */
	protected $academic_degree_id;

	/**
	 * @var int
	 */
	protected $title_id;

	/**
	 * @var string
	 */
	protected $birth_city;

	/**
	 * @var int
	 */
	protected $country_id;

	/**
	 * @var int
	 */
	protected $nationality_id;

	/**
	 * @var int
	 */
	protected $second_nationality_id;

	/**
	 * @var int
	 */
	protected $self_registration_status_id;

	/**
	 * @var string
	 */
	protected $updated_at;

	/**
	 * @return string
	 */
	public function getFirstName()
	{
		return $this->first_name;
	}

	/**
	 * @param string $first_name
	 */
	public function setFirstName($first_name)
	{
		$this->first_name = $first_name;
	}

	/**
	 * @return string
	 */
	public function getSurName()
	{
		return $this->sur_name;
	}

	/**
	 * @param string $sur_name
	 */
	public function setSurName($sur_name)
	{
		$this->sur_name = $sur_name;
	}

	/**
	 * @return string
	 */
	public function getAllFirstNames()
	{
		return $this->all_first_names;
	}

	/**
	 * @param string $all_first_names
	 */
	public function setAllFirstNames($all_first_names)
	{
		$this->all_first_names = $all_first_names;
	}

	/**
	 * @return string
	 */
	public function getDateOfBirth()
	{
		return $this->date_of_birth;
	}

	/**
	 * @param string $date_of_birth
	 */
	public function setDateOfBirth($date_of_birth)
	{
		$this->date_of_birth = $date_of_birth;
	}

	/**
	 * @return string
	 */
	public function getBirthName()
	{
		return $this->birth_name;
	}

	/**
	 * @param string $birth_name
	 */
	public function setBirthName($birth_name)
	{
		$this->birth_name = $birth_name;
	}

	/**
	 * @return string
	 */
	public function getArtistName()
	{
		return $this->artist_name;
	}

	/**
	 * @param string $artist_name
	 */
	public function setArtistName($artist_name)
	{
		$this->artist_name = $artist_name;
	}

	/**
	 * @return string
	 */
	public function getNamePrefix()
	{
		return $this->name_prefix;
	}

	/**
	 * @param string $name_prefix
	 */
	public function setNamePrefix($name_prefix)
	{
		$this->name_prefix = $name_prefix;
	}

	/**
	 * @return string
	 */
	public function getNameSuffix()
	{
		return $this->name_suffix;
	}

	/**
	 * @param string $name_suffix
	 */
	public function setNameSuffix($name_suffix)
	{
		$this->name_suffix = $name_suffix;
	}

	/**
	 * @return string
	 */
	public function getAcademicDegreeSuffix()
	{
		return $this->academic_degree_suffix;
	}

	/**
	 * @param string $academic_degree_suffix
	 */
	public function setAcademicDegreeSuffix($academic_degree_suffix)
	{
		$this->academic_degree_suffix = $academic_degree_suffix;
	}

	/**
	 * @return int
	 */
	public function getTitleId()
	{
		return $this->title_id;
	}

	/**
	 * @param int $title_id
	 */
	public function setTitleId($title_id)
	{
		$this->title_id = $title_id;
	}

	/**
	 * @return string
	 */
	public function getBirthCity()
	{
		return $this->birth_city;
	}

	/**
	 * @param string $birth_city
	 */
	public function setBirthCity($birth_city)
	{
		$this->birth_city = $birth_city;
	}

	/**
	 * @return int
	 */
	public function getCountryId()
	{
		return $this->country_id;
	}

	/**
	 * @param int $country_id
	 */
	public function setCountryId($country_id)
	{
		$this->country_id = $country_id;
	}

	/**
	 * @return int
	 */
	public function getNationalityId()
	{
		return $this->nationality_id;
	}

	/**
	 * @param int $nationality_id
	 */
	public function setNationalityId($nationality_id)
	{
		$this->nationality_id = $nationality_id;
	}

	/**
	 * @return int
	 */
	public function getSecondNationalityId()
	{
		return $this->second_nationality_id;
	}

	/**
	 * @param int $second_nationality_id
	 */
	public function setSecondNationalityId($second_nationality_id)
	{
		$this->second_nationality_id = $second_nationality_id;
	}

	/**
	 * @return int
	 */
	public function getSelfRegistrationStatusId()
	{
		return $this->self_registration_status_id;
	}

	/**
	 * @param int $self_registration_status_id
	 */
	public function setSelfRegistrationStatusId($self_registration_status_id)
	{
		$this->self_registration_status_id = $self_registration_status_id;
	}

	/**
	 * @return string
	 */
	public function getAcademicDegreeId()
	{
		return $this->academic_degree_id;
	}

	/**
	 * @param string $academic_degree_id
	 */
	public function setAcademicDegreeId($academic_degree_id)
	{
		$this->academic_degree_id = $academic_degree_id;
	}

	/**
	 * @return string
	 */
	public function getUpdatedAt()
	{
		return $this->updated_at;
	}

	/**
	 * @param string $updated_at
	 */
	public function setUpdatedAt($updated_at)
	{
		$this->updated_at = $updated_at;
	}
}
