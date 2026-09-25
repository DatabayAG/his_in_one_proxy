# Configuration

Copy `config.json.dist` to `config.json` in the project root. Do not commit `config.json`. It contains passwords.

`queue_type` is `file_based` or `db_based`. Local ECS (`ECS.use_local_ecs`) requires `db_based` and `Database.dsn`.

For on/off settings, use JSON `true` and `false`. A non-empty string, including `"false"`, is treated as on. `HIS.ssl_validation` is the exception: only the string `"true"` turns certificate checks on.

`HIS.text.*` is one of `getShortText`, `getDefaultText`, or `getLongText`. A missing or unknown value falls back to `getDefaultText`.

Step-by-step setup: [his_in_one_middleware_installation_and_configuration_detail_guide.md](his_in_one_middleware_installation_and_configuration_detail_guide.md).

| Key | What it does |
|-----|----------------|
| `HIS.username` | Technical user for HIS SOAP |
| `HIS.password` | Password of that user |
| `HIS.url` | SOAP base URL, ending in `/qisserver/services2/` |
| `HIS.soap_caching` | `1` caches WSDLs, `0` does not |
| `HIS.soap_debug` | Writes SOAP response XML to the shell |
| `HIS.ssl_validation` | `"true"` checks the HIS TLS certificate. Any other value skips the check |
| `HIS.actual_term_id` | Default term type id when a command omits it. `null` means no default |
| `HIS.actual_term_year` | Default calendar year when a command omits it. `null` means no default |
| `HIS.endpoint.register_listener` | Registers this host with HIS for system events (`php cmd.php se`) |
| `HIS.endpoint.listener_url` | Host HIS calls for those events |
| `HIS.endpoint.listener_port` | Port of that listener |
| `HIS.endpoint.username` | Optional basic auth user for the listener |
| `HIS.endpoint.password` | Optional basic auth password for the listener |
| `HIS.person_id_type` | Person id sent to ILIAS: `ecs_loginUID`, `ecs_login`, `ecs_uid`, `ecs_email`, `ecs_ePPN`, or `ecs_PersonalUniqueCode` |
| `HIS.login_suffix` | Text appended to the login. Empty string appends nothing |
| `HIS.blocked_ids` | Account state ids to skip. List them with `php cmd.php gb` |
| `HIS.blocked_form_of_studies_ids` | Form-of-studies ids left out of degree programmes. List them with `php cmd.php gf` |
| `HIS.work_status_ids` | Enrollment work-status ids requested from HIS. List them with `php cmd.php gw` |
| `HIS.remove_duplicate_degree_programmes` | `true` sends a repeated study-form title on one course only once. Titles always use the HIS default text |
| `HIS.group_title_from_plan_element` | `false`: group title is the parallel-group type (long text). `true`: group title is the plan element name. Missing key means `false` |
| `HIS.text.current_term` | Unused. The current term only supplies its number and year |
| `HIS.text.event_type` | Lecture type label in the export |
| `HIS.text.plan_element` | Plan element name. Course title when the course has one plan element. Group title when `HIS.group_title_from_plan_element` is `true` |
| `HIS.text.term` | Term name. The year is appended |
| `HIS.text.unit` | Course title when the course has more than one plan element |
| `ECS.use_local_ecs` | `true`: ILIAS polls this proxy. Requires `queue_type` `db_based` |
| `ECS.ecs_community_id` | Community id for Local ECS |
| `ECS.auth_id` | Auth id of the remote ECS server |
| `ECS.password` | Password of the remote ECS server |
| `ECS.url` | URL of the remote ECS server |
| `HIStoECSMapping` | HIS e-learning system id to ECS membership id. Discover HIS ids with `php cmd.php ge`. An unknown HIS id stops the export |
| `HIStoECSCourseMapping` | HIS course type id to an ILIAS scenario: `0` one course, `1` groups in one course, `2` one course per group, `3` one course per lecturer. Discover HIS ids with `php cmd.php cm`. An unknown type becomes `0` |
| `Database.dsn` | PDO DSN for the DB queue. Empty when `queue_type` is `file_based` |
| `create_links` | Writes ILIAS course URLs back into HIS. Group URLs (`/go/grp/`) are ignored |
| `process_links_count` | How many queued links `php cmd.php ls` sends per run |
| `link_creation_title` | Title stored on the HIS link. Empty uses the lecture title |
| `queue_type` | `file_based` or `db_based`. Empty or unknown stops startup |
| `path_to_queue` | Directory for the file queue |
| `path_to_log` | Log file path |
| `keep_elements_in_queue` | Keeps delivered jobs instead of deleting them |
| `queue_timer` | Seconds between queue watcher runs (`php cmd.php sq`) |
| `debug` | Shows debug commands in `php cmd.php` |
| `PHPUnit.coverage` | Collects coverage when tests run. Can crash together with opcache |
