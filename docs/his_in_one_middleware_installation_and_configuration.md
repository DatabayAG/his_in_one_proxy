# HISinOne Middleware Installation & Configuration

**You need a running HISinOne, ECS Server and ILIAS installation.**

## Needed packages
    apt-get install php-7.0 php7.0-xml php7.0-soap

## Clone the project 
    git clone https://gitlab.databay.de/ilias-utils/his_in_one_proxy

## Configure the middleware
### Create a config file
    cp config.json.dist config.json
### Config file in details
#### Block HIS
* _username_: Username for HisInOne Server
* _password_: Password for HisInOne Server
* _url_: URL for HisInOneServer with 'qisserver/services2/'
* _soap_caching_: SOAP Caching active(1) or inactive (0)
* _soap_debug_: SOAP Debug (true/false) if true all response xml gets dumpt to shell
* _endpoint_: The Endpoint for the HISInOne Queue
  1. _register_listener_: Listener active (true/false)
  2. _listener_url_: URL/IP for listener
  3. _listener_port_: Port for listener
  4. _username_: Username for listener
  5. _password_: Password for listener
* _person_id_type_:  The identification value for the users. possible personIDtype values:
  1. ecs_PersonalUniqueCode
  2. ecs_ePPN
  3. ecs_login
  4. ecs_loginUID
  5. ecs_uid
  6. ecs_email
* _login_suffix_: String which should be appended to login name
* _blocked_ids_: Array of ids for inactive Accounts you can query the blocked ids from your HISinOne with: 
    **php cmd.php gb**
* _text_: Which function should be used to retrieve a text from an object, possible values are
  1. getShortText 
  2. getDefaultText 
  3. getLongText
#### Block ECS 
* _auth_id_: AUTH id for ecs server
* _url_: URL to ecs server
* _ssl_validation_: SSL validation (true/false)
#### Block General
* _HIStoECSMapping_: Maps the System Id from HISinOne to the ECS Server
  1. SYSTEM_ID_HIS : SYSTEM_ID_ECS (MembershipID (mid) Community)
    
   **Use "php cmd.php ge" to get the course Elearning Id from your HIS installation**

* _HIStoECSCourseMapping_: Maps the Course type from HISinOne to the course type in the target system 
  1. COURSE_TYPE_ID_HIS : COURSE_TYPE_ID_ECS

   **Use "php cmd.php cm" to get the course Mapping Id from your HIS installation**

    * The ILIAS Course ids are the following:
      * PARALLEL_ONE_COURSE => 0
      * PARALLEL_GROUPS_IN_COURSE => 1
      * PARALLEL_ALL_COURSES => 2
      * PARALLEL_COURSES_FOR_LECTURERS => 3

* _path_to_queue_: Path to queue from his_in_one_proxy
* _path_to_log_: Path to logfile from his_in_one_proxy
* _keep_elements_in_queue_: Keep elements in queue and do not delete them (true/false)
* _queue_timer_: Timer for queue in seconds
* _debug_: Debug mode active for his_in_one_proxy (true/false)
* _PHPUnit_:   
  * _coverage_: PHPUnit coverage when running unittest (true/false)

## Example Config

    {
    	"HIS" : {
    		"username"           : "myGreatHISinOneUsername",
    		"password"           : "myGreatHISinOnePAssword",
    		"url"                : "https://myGreatHISinOneURL/qisserver/services2/",
    		"soap_caching"       : "1",
    		"soap_debug"         : "false",
    		"actual_term_id"     : 2,
    		"actual_term_year"   : 2017,
    		"endpoint"           : {
    			"register_listener"  : "false",
    			"listener_url"       : "192.168.1.2",
    			"listener_port"      : "83",
    			"username"           : "",
    			"password"           : ""
    		},
    		"person_id_type" : "ecs_loginUID",
    		"login_suffix" : "",
    		"blocked_ids" : [4, 2],
    		"text" : {
    			"current_term" : "getDefaultText",
    			"event_type"   : "getDefaultText",
    			"plan_element" : "getDefaultText",
    			"term"         : "getDefaultText",
    			"unit"         : "getLongText"
    		}
    	},
    	"ECS" : {
    		"auth_id"            : "myECSAuthId",
    		"url"                : "http://192.168.1.183:8080",
    		"ssl_validation"     : "false"
    	},
    	"HIStoECSMapping": {
    		"7" : "666",
    		"8" : "512"
    	},
    	"HIStoECSCourseMapping" : {
    		"1" : "0",
    		"2" : "1",
    		"3" : "2"
    	},
    	"path_to_queue"          : "/opt/his_middleware/simple_queue2/",
    	"path_to_log"            : "//opt/his_middleware/log/debug.log",
    	"keep_elements_in_queue" : "true",
    	"queue_timer"            : "1",
    	"debug"                  : "true",
    	"PHPUnit"                : {
    			"coverage" : "true"
    	}
    }
