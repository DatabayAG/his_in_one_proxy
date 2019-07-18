<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;

/**
 * Class ParsePerson
 * @package HisInOneProxy\Parser
 */
class ParsePerson extends SimpleXmlParser
{

    /**
     * @param $xml
     * @return DataModel\Person
     */
    public function parse($xml)
    {
        $person = new DataModel\Person();
        if ($this->isAttributeValid($xml, 'id')) {
            $person->setId($xml->id);
            $this->log->info(sprintf('Found user with id %s.', $person->getId()));
            if ($this->isAttributeValid($xml, 'objGuid')) {
                $person->setObjGuid($xml->objGuid);
            }
            if ($this->isAttributeValid($xml, 'firstname')) {
                $person->setFirstName($xml->firstname);
            }
            if ($this->isAttributeValid($xml, 'surname')) {
                $person->setSurName($xml->surname);
            }
            if ($this->isAttributeValid($xml, 'allfirstnames')) {
                $person->setAllFirstNames($xml->allfirstnames);
            }
            if ($this->isAttributeValid($xml, 'dateofbirth')) {
                $person->setDateOfBirth($xml->dateofbirth);
            }
            if ($this->isAttributeValid($xml, 'genderId')) {
                $person->setGenderId($xml->genderId);
            }
            if ($this->isAttributeValid($xml, 'birthname')) {
                $person->setBirthName($xml->birthname);
            }
            if ($this->isAttributeValid($xml, 'artistname')) {
                $person->setArtistName($xml->artistname);
            }
            if ($this->isAttributeValid($xml, 'nameprefix')) {
                $person->setNamePrefix($xml->nameprefix);
            }
            if ($this->isAttributeValid($xml, 'namesuffix')) {
                $person->setNameSuffix($xml->namesuffix);
            }
            if ($this->isAttributeValid($xml, 'academicdegreesuffix')) {
                $person->setAcademicDegreeSuffix($xml->academicdegreesuffix);
            }
            if ($this->isAttributeValid($xml, 'academicdegreeId')) {
                $person->setAcademicDegreeId($xml->academicdegreeId);
            }
            if ($this->isAttributeValid($xml, 'titleId')) {
                $person->setTitleId($xml->titleId);
            }
            if ($this->isAttributeValid($xml, 'birthcity')) {
                $person->setBirthCity($xml->birthcity);
            }
            if ($this->isAttributeValid($xml, 'countryId')) {
                $person->setCountryId($xml->countryId);
            }
            if ($this->isAttributeValid($xml, 'personinfo')) {
                if ($this->isAttributeValid($xml->personinfo, 'nationalityId')) {
                    $person->setNationalityId($xml->personinfo->nationalityId);
                }
                if ($this->isAttributeValid($xml->personinfo, 'secondNationalityId')) {
                    $person->setSecondNationalityId($xml->personinfo->secondNationalityId);
                }
            }
            if ($this->isAttributeValid($xml, 'updatedAt')) {
                $person->setUpdatedAt($xml->updatedAt);
            }
            if ($this->isAttributeValid($xml, 'selfregistrationStatusId')) {
                $person->setSelfRegistrationStatusId($xml->selfregistrationStatusId);
            }
        } else {
            $this->log->warning('No id given for user, skipping!');
        }
        return $person;
    }
}
