<?php

namespace HisInOneProxy\Soap;

use HisInOneProxy\Config\GlobalSettings;
use HisInOneProxy\Soap\Interactions\DataCache;
use HisInOneProxy\Soap\SoapService\ConfigClient;
use HisInOneProxy\System\Utils;
use Noodlehaus\Exception;

class WSSoapClient extends \SoapClient
{
	private $OASIS = 'http://docs.oasis-open.org/wss/2004/01';

	/**
	 * @var bool
	 */
	protected $soap_debug = false;
	
	/**
	 * @var string
	 */
	private $username;

	/**
	 * @var string
	 */
	private $password;

	/**
	 * @var bool
	 */
	private $add_secure_header = true;

	/**
	 * WSSoapClient constructor.
	 * @param mixed      $wsdl
	 * @param array|null $options
	 */
	public function __construct($wsdl, array $options = null)
	{
		ini_set("soap.wsdl_cache_enabled", GlobalSettings::getInstance()->isSoapCaching());

		$client_config = new ConfigClient();
		$config = array('stream_context'	=> $client_config->getSSlConfig(),
						'trace'				=> true, 
						'exception'			=> 1,
						'location'			=> GlobalSettings::getInstance()->getHisServerUrl() . $options['path'] . '/'
		);

		if(array_key_exists('remove_secure_header',$options) && $options['remove_secure_header'] == true)
		{
			$this->add_secure_header = false;
		}

		$this->soap_debug =  GlobalSettings::getInstance()->isSoapDebug();
		#try{
			$this->__setUsernameToken(GlobalSettings::getInstance()->getHisUserName(), GlobalSettings::getInstance()->getHisPassword());
			parent::__construct($wsdl, $config);
		#}catch(\Exception $e){
			#DataCache::getInstance()->getLog()->critical($e->getMessage());
		#}
	}

	/**
	 * @param string $username
	 * @param string $password
	 */
	protected function __setUsernameToken($username, $password)
	{
		$this->username = $username;
		$this->password = $password;
	}

	/**
	 * @param string $function_name
	 * @param array  $arguments
	 * @param null   $options
	 * @param null   $input_headers
	 * @param null   $output_headers
	 * @return mixed
	 */
	public function __soapCall($function_name, $arguments, $options = NULL, $input_headers = NULL, &$output_headers = NULL)
	{
		#try{
			if($this->add_secure_header === true)
			{
				$this->__setSoapHeaders($this->generateWSSecurityHeader());
			}

			return parent::__soapCall($function_name, $arguments, $options, $input_headers, $output_headers);
		#}
		#catch(\Exception $e){
			#DataCache::getInstance()->getLog()->critical($e->getMessage());
		#}
	}

	public function __doRequest($request, $location, $action, $version, $one_way = 0)
	{
		$result = parent::__doRequest($request, $location, $action, $version, $one_way);
		$result = str_replace('<his:childOrgUnit>', '<his:orgunit>', $result);
		$result = str_replace('</his:childOrgUnit>', '</his:orgunit>', $result);

		if($this->soap_debug)
		{
			echo "Request:\n" . $request . "\n";
			echo "Response:\n" . $result . "\n";
		}

		return $result;
	}

	/**
	 * @return \SoapHeader
	 */
	protected function generateWSSecurityHeader()
	{
		$xml = '<wsse:Security SOAP-ENV:mustUnderstand="1" xmlns:wsse="' . $this->OASIS . '/oasis-200401-wss-wssecurity-secext-1.0.xsd">
					<wsse:UsernameToken>
						<wsse:Username>' . $this->username . '</wsse:Username>
						<wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">' . $this->password . '</wsse:Password>
					</wsse:UsernameToken>
				</wsse:Security>';

		$soap_header = new \SoapHeader(
			$this->OASIS . '/oasis-200401-wss-wssecurity-secext-1.0.xsd',
			'Security',
			new \SoapVar($xml, XSD_ANYXML),
			true);

		return $soap_header;
	}
}