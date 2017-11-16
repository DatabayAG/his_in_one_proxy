# ECS Proxy
# Internes Projekt! Darf nicht veröffentlicht werden, da hier geschütze Inhalten enthalten sind. his_in_one_proxy ist das öffentliche Repo!
[![build status](https://gitlab.databay.de/ilias-utils/ecs_proxy/badges/master/build.svg)](https://gitlab.databay.de/ilias-utils/ecs_proxy/commits/master)
[![coverage report](https://gitlab.databay.de/ilias-utils/ecs_proxy/badges/master/coverage.svg)](https://gitlab.databay.de/ilias-utils/ecs_proxy/commits/master)

If the Unittest with coverage segfaults remove the opcache extension!

## Config description
	"HIS" : {
		"username"           : "Username for HisInOne Server",
		"password"           : "Password for HisInOne Server",
		"url"                : "URL for HisInOneServer with 'qisserver/services2/'",
		"soap_caching"       : "SOAP Caching active(1) or inactive (0)",
		"soap_debug"         : "SOAP Debug (true/false) if true all response xml gets dumpt to shell",
		"endpoint"           : {
			"register_listener"  : "Listener active (true/false)",
			"listener_url"       : "URL/IP for listener",
			"listener_port"      : "Port for listener",
			"username"           : "Username for listener",
			"password"           : "Password for listener"
		}
	},
	"ECS" : {
		"auth_id"            : "AUTH id for ecs server",
		"receiver_memberships": "Membership overwrite",
		"url"                : "URL to ecs server",
		"ssl_validation"     : "SSL validation (true/false)"
	},
	"path_to_queue"          : "Path to queue from his_in_one_proxy",
	"path_to_log"            : "Path to logfile from his_in_one_proxy",
	"keep_elements_in_queue" : "Keep elements in queue and do not delete them (true/false)",
	"queue_timer"            : "Timer for queue in seconds",
	"debug"                  : "Debug mode active for his_in_one_proxy (true/false)",
	"PHPUnit"                : {
			"coverage" : "PHPUnit coverage when running unittest (true/false)"
	}
