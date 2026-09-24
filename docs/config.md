# Configuration (`config.json`)

Copy the template and edit:

```bash
cp config.json.dist config.json
```

Do not commit `config.json` — it holds passwords.

The app loads `./config.json`, or `../../../config.json` in some deployment layouts.

---

## HIS — connection to HIS-in-One

| Option | What it does |
|--------|--------------|
| `username`, `password` | SOAP login for HIS-in-One |
| `url` | Base URL, must end with `/qisserver/services2/` |
| `soap_caching` | `0` = off, `1` = cache WSDL files |
| `soap_debug` | Dump SOAP responses to the terminal |
| `ssl_validation` | `"true"` = verify HTTPS certificates; empty = skip verification (typical for dev) |
| `actual_term_id` | Default semester type when CLI omits it (e.g. `2` = summer). Not the HIS term string like `2025.1.0` |
| `actual_term_year` | Default year, pairs with `actual_term_id` |

### Event listener (`HIS.endpoint`)

HIS can push change events to the middleware. Only needed if you run the listener daemon (`php cmd.php se`).

| Option | What it does |
|--------|--------------|
| `register_listener` | Register this middleware with HIS on startup |
| `listener_url` | Hostname HIS can reach |
| `listener_port` | Port for the listener |
| `username`, `password` | Optional basic auth for the listener |

If HIS cannot reach your server, set `register_listener` to `false`.

### Export behaviour

| Option | What it does |
|--------|--------------|
| `person_id_type` | How users are identified in ILIAS/ECS JSON. Common value: `ecs_loginUID`. Also: `ecs_login`, `ecs_uid`, `ecs_email`, `ecs_ePPN`, `ecs_PersonalUniqueCode` |
| `login_suffix` | Text appended to usernames in the export (e.g. `@uni.example.edu`) |
| `blocked_ids` | Skip accounts with these blocked-state IDs. Find IDs: `php cmd.php gb` |
| `blocked_form_of_studies_ids` | Skip degree programmes with these study-form IDs. Find IDs: `php cmd.php gf` |
| `work_status_ids` | Only export students with these enrollment statuses. Find IDs: `php cmd.php gw` |
| `remove_duplicate_degree_programmes` | `true` removes duplicate programme titles from the export |

### Text labels (`HIS.text`)

Chooses which HIS text field is used for names in the export:

- `getDefaultText` — standard (default)
- `getShortText` — short label
- `getLongText` — long label

Applies per entity: `current_term`, `event_type`, `plan_element`, `term`, `unit`.

---

## ECS — connection to ILIAS (via ECS)

Two modes:

**Remote ECS** — middleware pushes to an ECS server:

```json
"ECS": {
  "use_local_ecs": "false",
  "url": "https://ecs.example.edu/",
  "auth_id": "...",
  "password": "..."
}
```

**Local ECS** — ILIAS polls this middleware directly:

```json
"ECS": {
  "use_local_ecs": "true",
  "ecs_community_id": "123"
}
```

Local ECS requires `queue_type: db_based` (see below).

| Option | What it does |
|--------|--------------|
| `use_local_ecs` | `true` = built-in ECS API; `false` = remote ECS server |
| `ecs_community_id` | Community ID (local ECS only) |
| `url` | Remote ECS server URL |
| `auth_id`, `password` | Remote ECS credentials |

---

## Mappings (required)

These connect HIS data to your ILIAS setup. Get the IDs from your HIS installation before the first export.

### `HIStoECSMapping`

Maps HIS e-learning system ID → ECS membership ID.

```json
"HIStoECSMapping": { "7": "666", "8": "512" }
```

Find IDs: `php cmd.php ge`

If a course uses an HIS ID that is not listed here, the export stops with an error.

### `HIStoECSCourseMapping`

Maps HIS course mapping type → ILIAS parallel-group layout:

| Value | Meaning |
|-------|---------|
| `0` | One ILIAS course for all groups |
| `1` | Groups inside one ILIAS course |
| `2` | Separate ILIAS course per group |
| `3` | Separate courses per lecturer |

```json
"HIStoECSCourseMapping": { "1": "0", "2": "1", "3": "2" }
```

Find IDs: `php cmd.php cm`

---

## Queue and logging

| Option | What it does |
|--------|--------------|
| `queue_type` | `file_based` (jobs as files) or `db_based` (MySQL). Required. |
| `path_to_queue` | Directory for queue files |
| `path_to_log` | Log file path |
| `queue_timer` | Seconds between queue checks (watcher: `php cmd.php sq`) |
| `keep_elements_in_queue` | Keep processed jobs instead of deleting them |
| `debug` | Show extra CLI debug commands (`php cmd.php`) |

### `Database.dsn`

PDO connection string. Required when `queue_type` is `db_based`.

```
mysql:host=127.0.0.1;dbname=his_proxy;user=his;password=secret
```

---

## ILIAS link sync (optional)

Creates links in HIS-in-One pointing to ILIAS courses.

| Option | What it does |
|--------|--------------|
| `create_links` | Enable link sync |
| `process_links_count` | How many links to send per run |
| `link_creation_title` | Link title in HIS. Empty = use lecture title |

Trigger manually: `php cmd.php ls`

---

## PHPUnit

| Option | What it does |
|--------|--------------|
| `PHPUnit.coverage` | Enable code coverage in tests. Can cause PHP crashes with opcache — leave off unless needed |

---

## Quick setup checklist

1. `cp config.json.dist config.json`
2. Fill in `HIS.username`, `HIS.password`, `HIS.url`
3. Run `php cmd.php ge` → fill `HIStoECSMapping`
4. Run `php cmd.php cm` → fill `HIStoECSCourseMapping`
5. Set `queue_type`, `path_to_queue`, `path_to_log`
6. Configure `ECS` (remote or local)
7. If local ECS: set `Database.dsn` and `queue_type: db_based`
8. Test: `php cmd.php lc 2 2025` (replace term/year)

---

## Notes

**Booleans as strings:** Many flags accept `"true"` / `"false"` as strings. Avoid the literal string `"false"` for off — PHP treats any non-empty string as true. Use JSON `false`, `""`, or `"0"` instead.

**Term arguments:** CLI commands use term *type* ID and year, not the HIS term ID string:
```bash
php cmd.php lc 2 2025    # all courses for term type 2, year 2025
php cmd.php li 2 2025 47117230   # single course
```
