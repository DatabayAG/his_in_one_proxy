# HISinOne Proxy
If the Unittest with coverage segfaults remove the opcache extension!

**For a more detailed instruction consult the ``docs`` folder!**

## Config description
	"HIS" : {
		"username"           : "Username for HisInOne Server",
		"password"           : "Password for HisInOne Server",
		"url"                : "URL for HisInOneServer with 'qisserver/services2/'",
		"soap_caching"       : "SOAP Caching active(1) or inactive (0)",
		"soap_debug"         : "SOAP Debug (true/false) if true all response xml gets dumpt to shell",
		"ssl_validation"     : "SSL validation (true/false)",
		"endpoint"           : {
			"register_listener"  : "Listener active (true/false)",
			"listener_url"       : "URL/IP for listener",
			"listener_port"      : "Port for listener",
			"username"           : "Username for listener",
			"password"           : "Password for listener"
		},
		"person_id_type" : "ecs_loginUID",
		// possible personIDtype values:
		//   ecs_PersonalUniqueCode
		//   ecs_ePPN
		//   ecs_login
		//   ecs_loginUID
		//   ecs_uid
		//   ecs_email
		"login_suffix" : "", // String which should be appended to login name
		"blocked_ids" : [], // Array of ids for inactive Accounts you can query the blocked ids from your HISinOne with php with "php cmd.php gb"
		"text" : { //getShortText | getDefaultText | getLongText
			"current_term" : "getDefaultText",
			"event_type"   : "getDefaultText",
			"plan_element" : "getDefaultText",
			"term"         : "getDefaultText",
			"unit"         : "getDefaultText"
		}
	},
	"ECS" : {
		"auth_id"            : "AUTH id for ecs server",
		"receiver_memberships": "Membership overwrite",
		"url"                : "URL to ecs server"
	},
		"HIStoECSMapping": {
			"SYSTEM_ID_HIS" : "SYSTEM_ID_ECS (MembershipID (mid) Community)"
			Use "php cmd.php ge" to get the course Elearning Id from your HIS installation
		"HIStoECSCourseMapping" : {
			"COURSE_TYPE_ID_HIS" : "COURSE_TYPE_ID_ECS"
			// 0 = No parallel groups ("base scenario") AND parallel group scenario 1, ie. just a course (see PDF)
			// 1 = Parallel group scenario 2, ie. a course with groups
			// 2 = Parallel group scenario 3, ie. a course for every group
			// 3 = Parallel group scenario 4, ie. a course with groups for every group lecturer
			Use "php cmd.php cm" to get the course Mapping Id from your HIS installation
		},
	"path_to_queue"          : "Path to queue from his_in_one_proxy",
	"path_to_log"            : "Path to logfile from his_in_one_proxy",
	"keep_elements_in_queue" : "Keep elements in queue and do not delete them (true/false)",
	"queue_timer"            : "Timer for queue in seconds",
	"debug"                  : "Debug mode active for his_in_one_proxy (true/false)",
	"PHPUnit"                : {
			"coverage" : "PHPUnit coverage when running unittest (true/false)"
	}