<?php

namespace HisInOneProxy\Soap;

use Exception;
use HisInOneProxy\Config\GlobalSettings;
use HisInOneProxy\DataModel\Endpoint;
use HisInOneProxy\Log\Log;
use HisInOneProxy\Soap\Interactions\DataCache;
use SoapFault;

/**
 * Class SystemEventAbonnenmentService
 * @package HisInOneProxy\Soap
 */
class SystemEventAbonnenmentService extends SoapService
{

    protected $objects = array(
        'person'                => 'Person',
        'personinfo'            => 'Personinfo',
        'student'               => 'Student',
        'account'               => 'Account',
        'chipcard'              => 'Chipcard',
        'rolle'                 => 'Rolle',
        'postaddress'           => 'Postaddress',
        'email'                 => 'EMail',
        'phone'                 => 'Phone',
        'personorgunit'         => 'Personorgunit',
        'degreeprogram'         => 'DegreeProgram',
        'degreeprogramprogress' => 'DegreeProgramProgress',
        'personattribute'       => 'PersonAttribute',
        'individualdate'        => 'IndividualDate',
        'examrelation'          => 'Examrelation'
    );

    protected $event_types = array(
        'create'        => 'CREATE',
        'read'          => 'READ',
        'update'        => 'UPDATE',
        'delete'        => 'DELETE',
        'association'   => 'ASSOCIATION',
        'deassociation' => 'DEASSOCIATION'
    );

    /**
     * @var string
     */
    protected $subscriber_name = 'HisInOneProxy';

    /**
     * SystemEventAbonnenmentService constructor.
     * @param Log               $log
     * @param SoapServiceRouter $soap_service_router
     */
    public function __construct($log, $soap_service_router)
    {
        parent::__construct($log, $soap_service_router);
        #$this->quitAllRegistrations();
        #$this->registerAll();
    }

    /**
     * @throws Exception
     */
    public function registerAll()
    {
        $endpoint = GlobalSettings::getInstance()->getEndPoint();
        foreach ($this->objects as $key => $name) {
            $this->register($name, $endpoint);
            if (!defined('PHPUNIT')) {
                echo "Registration for " . $name . " done. \n";
            }
        }
    }

    /**
     * @param          $object_type
     * @param Endpoint $endpoint
     * @return null
     * @throws Exception
     */
    public function register($object_type, $endpoint)
    {
        $key = strtolower($object_type);
        if (array_key_exists($key, $this->objects)) {
            $params = array(
                array(
                    'objecttype'     => $object_type,
                    'subscriberName' => $this->subscriber_name,
                    'endpoint'       => array(
                        'endpointUrl'      => $endpoint->getUrlWithPort(),
                        'webServiceMethod' => $endpoint->getWebServiceMethod(),
                        'username'         => $endpoint->getUserName(),
                        'password'         => $endpoint->getPassword()
                    ),
                    'events'         => array('CREATE', 'READ', 'UPDATE', 'DELETE', 'ASSOCIATION', 'DEASSOCIATION')
                )
            );
            try {
                $response = $this->soap_service_router->getSoapSystemEventAbonnenmentClient()->__soapCall('register60', $params);
                var_dump($response);
            } catch (SoapFault $exception) {
                $this->log->error($exception->getMessage());
            }
        } else {
            DataCache::getInstance()->getLog()->error(printf('Trying to register unknown object type (%s', $object_type));
        }
        return null;
    }

    public function quitAllRegistrations()
    {
        foreach ($this->objects as $key => $name) {
            if (!defined('PHPUNIT')) {
                echo "Quitting registration for " . $name . " done. \n";
            }
            $this->quitRegistration($name);
        }
    }

    /**
     * @param string $object_type
     * @return null
     * @throws Exception
     */
    public function quitRegistration($object_type)
    {
        $key = strtolower($object_type);
        if (array_key_exists($key, $this->objects)) {
            $params = array(
                array(
                    'objecttype'     => $object_type,
                    'subscriberName' => $this->subscriber_name,
                )
            );
            try {
                $response = $this->soap_service_router->getSoapSystemEventAbonnenmentClient()->__soapCall('quitRegistration', $params);
                var_dump($response);
            } catch (SoapFault $exception) {
                $this->log->error($exception->getMessage());
            }
        } else {
            DataCache::getInstance()->getLog()->error(printf('Trying to quit registration for unknown object type (%s', $object_type));
        }
        return null;
    }

}