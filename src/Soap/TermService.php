<?php

namespace HisInOneProxy\Soap;

use HisInOneProxy\Log\Log;
use HisInOneProxy\Parser;

/**
 * Class TermService
 * @package HisInOneProxy\Soap
 */
class TermService extends SoapService
{

    /**
     * CourseCatalogService constructor.
     * @param Log               $log
     * @param SoapServiceRouter $soap_service_router
     */
    public function __construct($log, $soap_service_router)
    {
        parent::__construct($log, $soap_service_router);
    }

    /**
     * @param null $lang
     * @return \HisInOneProxy\DataModel\CurrentTerm | null
     */
    public function getCurrentTerm($lang = null)
    {
        $params = array(array('lang' => $lang));
        try {
            $response = $this->soap_service_router->getSoapClientTermService()->__soapCall('getCurrentTerm', $params);
            $parser   = new Parser\ParseCurrentTerm($this->log);
            if (isset($response->currentTerm)) {
                $current_term = $parser->parse($response->currentTerm);
                return $current_term;
            } else {
                $this->log->error('No current term object found in response, now we have a real problem!');
            }
        } catch (\SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

}