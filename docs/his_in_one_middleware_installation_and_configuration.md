# HISinOne Middleware Installation & Configuration  
  
**You need a running HISinOne, ECS Server and ILIAS installation.**  
  
## Needed packages  
    apt-get install php7.0 php7.0-xml php7.0-soap php7.0-curl
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
* _ssl_validation_: SSL validation (true/false)   
* _actual_term_id_ : If set this will be used as default term_id
* _actual_term_year_ : If set this will be used as default year
* _endpoint_: The Endpoint for the HISInOne Queue  
  1. _register_listener_: Listener active (true/false)  
  2. _listener_url_: URL/IP for listener  
  3. _listener_port_: Port for listener  
  4. _username_: Username for listener  
  5. _password_: Password for listener  
* _person_id_type_:  The identification value for the users. possible personIDtype values:  
  * ecs_PersonalUniqueCode 
  * ecs_ePPN 
  * ecs_login 
  * ecs_loginUID e
  * ecs_uid ecs_email 
* _login_suffix_: String which should be appended to login name  
* _blocked_ids_: Array of ids for inactive Accounts you can query the blocked ids from your HISinOne with:   
    `php cmd.php gb`  
* _text_: Which function should be used to retrieve a text from an object, possible values are: 
  * getShortText    
  * getDefaultText   
  * getLongText
  
#### Block ECS 
* _auth_id_: AUTH id for ecs server  
* _url_: URL to ecs server 
 
#### Block General  
* _HIStoECSMapping_: Maps the System Id from HISinOne to the ECS Server  
  * SYSTEM_ID_HIS : SYSTEM_ID_ECS (MembershipID (mid) Community)  
       **Use `php cmd.php ge` to get the course Elearning Id from your HIS installation**  
  
* _HIStoECSCourseMapping_: Maps the Course type from HISinOne to the course type in the target system   
  * COURSE_TYPE_ID_HIS : COURSE_TYPE_ID_ECS  
     **Use `php cmd.php cm` to get the course Mapping Id from your HIS installation**  
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
            "username"        :  "myGreatHISinOneUsername", 
            "password"        : "myGreatHISinOnePassword", 
            "url"             : "https://myGreatHISinOneURL/qisserver/services2/", 
            "soap_caching"    : "1", 
            "soap_debug"      : "false"
             "ssl_validation"     : "false",
            "actual_term_id"  : 2, 
            "actual_term_year" : 2017, 
            "endpoint"         : { 
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
              "password"           : "myHighlySecretPasswort47!!", 
              "url"                : "http://192.168.1.183:8080"
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
          "path_to_log"            : "/opt/his_middleware/log/debug.log",
          "keep_elements_in_queue" : "true", 
          "queue_timer"            : "1", 
          "debug"                  : "true", 
          "PHPUnit"                : 
            { 
              "coverage" : "true" 
            }
          }

### All possible command  
     php cmd.php


This should give you a list of all possible commands, below you see an example from the output:  

    Usage: php cmd.php function [term] [year] [param]  
       lc => Gets all lectures and add them to queue. 
       li => Gets a Lecture by id. Uses id as param. 
       in => Gets all institutions. cc => Gets course catalog. 
       ge => Gets all elearning platforms. 
       gb => Gets all blocked id states. 
       ts => Gets wsdls needed for unittests and runs tests. 
       sq => Starts queue which is used to communicate with the ecs server. 
       se => Starts his listener which listens to the system events from his server. 
       cm => Gets all course mapping types. 
       ro => (Debug) Get root id of term 
       le => (Debug) Gets course catalog leaf by id. 
       gg => (Debug) Gets all gender types. 
       gp => (Debug) Gets all parallel group types. 
       gw => (Debug) Gets all work status types. 
       gt => (Debug) Gets all term types. 
       gl => (Debug) Gets all language types. 
       ga => (Debug) Gets all eaddress tags. 
       gy => (Debug) Gets all eaddress types. 
       gf => (Debug) Gets all field of study types. 
       gm => (Debug) Gets all mayor field of studies types. 
       go => (Debug) Gets all org unit attributes types. 
       gs => (Debug) Gets all org unit types. 
       gc => (Debug) Gets all person group types. 
       dl => (Debug) Gets default language id. 
       ct => (Debug) Gets current term. 
       rs => (Debug) Read student with course of study by person id 
       ci => (Debug) Get course of study by id. 
       rp => (Debug) Reads person by id. 
       ra => (Debug) Reads account by id. 
       sa => (Debug) Reads accounts by person id. 
       ea => (Debug) Reads electronic addresses by person id. 
       et => (Debug) Reads element types. 
       cs => (Debug) Reads all event types. 

 

The functions with the `(Debug)` prefix only get printed to console if you have set the `debug` option to `true`  in your config file!  
  
### Example of usage  
The example below reads all courses which are exported to an elearning system for the second term in 2017:  
```  
php cmd.php lc 2 2017  
```  
The call below would export only the course with the id ```47117230```  
```  
php cmd.php li 2 2017 47117230  
```