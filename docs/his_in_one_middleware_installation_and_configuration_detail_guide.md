# Configure `config.json` step by step

This guide walks you through filling `config.json` from the template. Do the steps in order. Each step tells you **what to set**, **where the value comes from**, and **when you can skip it**.

**Never commit `config.json`** — it contains credentials.

---

## Before you start

You need:

- A running HIS-in-One with a technical user that may use webservices ([roles](his_in_one_configuration.md))
- Either a remote ECS server **or** a plan to use Local ECS (ILIAS polls this middleware)
- An ILIAS setup (or knowledge of the person-ID type it expects)
- Write access on the middleware host for queue and log directories

---

## Step 1 — Create the config file

```bash
cd /path/to/his_in_one_proxy
cp config.json.dist config.json
```

Open `config.json` in an editor. Leave unknown fields for later steps; replace placeholders as you go.

---

## Step 2 — Connect to HIS-in-One

Edit the `HIS` block:

| Key | What to enter | Where to get it |
|-----|---------------|-----------------|
| `username` | HIS technical user | HIS admin — account with SOAP/webservice rights |
| `password` | That user’s password | Same account |
| `url` | Base URL of SOAP services | `https://<your-his-host>/qisserver/services2/` |

Then set SOAP behaviour:

| Key | Suggested value | Notes |
|-----|-----------------|-------|
| `soap_caching` | `"0"` first, `"1"` later | Keep off until WSDLs are stable |
| `soap_debug` | `""` or `"0"` | Turn on only while debugging SOAP |
| `ssl_validation` | `"true"` in production | Empty/`"false"` only for self-signed/dev certs |

**Check:** With HIS credentials filled, later discovery commands (`ge`, `cm`, …) should talk to HIS. If they fail, fix Step 2 before continuing.

---

## Step 3 — Choose how jobs are stored (queue)

Decide your deployment style **before** ECS settings — Local ECS forces a DB queue.

### Option A — Classic (remote ECS)

```json
"queue_type": "file_based",
"Database": { "dsn": "" }
```

### Option B — Local ECS (ILIAS polls this middleware)

```json
"queue_type": "db_based",
"Database": {
  "dsn": "mysql:host=127.0.0.1;port=3306;dbname=his_proxy;user=his;password=SECRET"
}
```

| Key | What to enter | Where to get it |
|-----|---------------|-----------------|
| `queue_type` | `"file_based"` or `"db_based"` | Your choice above — **not** the dist placeholder |
| `Database.dsn` | PDO DSN | Your MySQL/MariaDB. Skip / leave empty for file queue |

If you chose **Option B**, create tables now:

```bash
php src/Database/DBUpdate.php
```

---

## Step 4 — Paths for queue and log

On the middleware host, create writable directories, then set:

| Key | Example | Notes |
|-----|---------|-------|
| `path_to_queue` | `/var/his-proxy/queue/` | Must be writable by the PHP user |
| `path_to_log` | `/var/his-proxy/log/debug.log` | Parent directory must exist |
| `queue_timer` | `"1"` | Poll interval in seconds for `php cmd.php sq` |
| `keep_elements_in_queue` | `""` or `"0"` | Set on only if you want to keep processed jobs for auditing |

```bash
mkdir -p /var/his-proxy/queue /var/his-proxy/log
# adjust owner to the user that runs php / the web server
```

---

## Step 5 — Configure the ECS target

### Option A — Remote ECS

| Key | What to enter | Where to get it |
|-----|---------------|-----------------|
| `use_local_ecs` | `""` (off) | — |
| `ecs_community_id` | often unused / optional | ECS admin if needed |
| `auth_id` | ECS auth user | ECS participant / nginx Basic Auth user ([ECS setup](ecs_installation_configuration.md)) |
| `password` | That password | Same ECS / htpasswd credential |
| `url` | ECS base URL | e.g. `https://ecs.example.edu/` |

### Option B — Local ECS

| Key | What to enter | Where to get it |
|-----|---------------|-----------------|
| `use_local_ecs` | `"true"` | Requires Step 3 Option B (`db_based`) |
| `ecs_community_id` | Community ID | Your Local ECS community setup |
| `auth_id` / `password` / `url` | can stay empty | Not used for remote delivery |

---

## Step 6 — Turn on discovery commands

Set temporarily:

```json
"debug": "true"
```

This unlocks commands you need in the next steps (`gw`, `ct`, `gt`, …). You can set `"debug"` back to off after go-live.

**Check:**

```bash
php cmd.php
```

You should see the full command list, including debug entries.

---

## Step 7 — Map HIS e-learning systems → ECS memberships

1. List HIS e-learning platforms:

   ```bash
   php cmd.php ge
   ```

2. Note each platform **ID** you will export (keys).

3. Look up the matching ECS **membership ID** (community mid) in the ECS admin UI (or Local ECS community ID).

4. Fill `HIStoECSMapping`:

```json
"HIStoECSMapping": {
  "7": "666",
  "8": "512"
}
```

| Side | Source |
|------|--------|
| Key | Output of `php cmd.php ge` |
| Value | ECS membership / community mid |

**Warning:** An unknown HIS ID here stops the whole process. Re-run `ge` after HIS upgrades.

---

## Step 8 — Map course types → ILIAS parallel-group layout

1. List HIS course mapping types:

   ```bash
   php cmd.php cm
   ```

2. For each HIS type ID, choose an ILIAS scenario:

| Value | Meaning |
|-------|---------|
| `0` | One ILIAS course for all parallel groups |
| `1` | Groups inside one ILIAS course |
| `2` | One ILIAS course per parallel group |
| `3` | Separate courses per lecturer |

3. Fill `HIStoECSCourseMapping`:

```json
"HIStoECSCourseMapping": {
  "1": "0",
  "2": "1",
  "3": "2"
}
```

| Side | Source |
|------|--------|
| Key | Output of `php cmd.php cm` |
| Value | Fixed `0`–`3` (not from HIS) |

---

## Step 9 — Person identity (must match ILIAS)

| Key | What to enter | Where to get it |
|-----|---------------|-----------------|
| `person_id_type` | One of the values below | Must match ILIAS Campus Connect / ECS person-ID setting |
| `login_suffix` | Usually `""` | Only if logins need a fixed suffix (e.g. `@uni.example`) |

Allowed `person_id_type` values:

- `ecs_loginUID` (common default)
- `ecs_login`
- `ecs_uid`
- `ecs_email`
- `ecs_ePPN`
- `ecs_PersonalUniqueCode`

---

## Step 10 — Filters from HIS key tables

Keep the dist defaults for `work_status_ids` until you verify them.

| Key | Action | Command |
|-----|--------|---------|
| `blocked_ids` | Add IDs for inactive/blocked accounts to skip | `php cmd.php gb` |
| `blocked_form_of_studies_ids` | Add form-of-studies IDs to omit (or leave `[]`) | `php cmd.php gf` |
| `work_status_ids` | Confirm enrollment statuses to include | `php cmd.php gw` |

Example after discovery:

```json
"blocked_ids": [2, 4],
"blocked_form_of_studies_ids": [],
"work_status_ids": [1, 6, 26, 27, 22, 8, 20, 28, 30, 32]
```

---

## Step 11 — Optional: default term

Useful when CLI commands omit term/year.

1. Inspect current / available terms:

   ```bash
   php cmd.php ct
   php cmd.php gt
   ```

2. Set:

| Key | Meaning | Note |
|-----|---------|------|
| `actual_term_id` | Term **type value** ID (e.g. summer/winter) | Not a string like `2025.1.0` |
| `actual_term_year` | Calendar year | e.g. `2026` |

Leave both `null` if you always pass term and year on the command line (`php cmd.php lc 2 2026`).

---

## Step 12 — Optional: system event listener

Skip this if you only run scheduled or manual exports (`lc`, cron, etc.).

| Key | When to set | Where to get it |
|-----|-------------|-----------------|
| `register_listener` | `"true"` if HIS can reach this host | Otherwise `"false"` / off |
| `listener_url` | Hostname/IP HIS will call | Middleware host as seen from HIS’s network |
| `listener_port` | Port for `php cmd.php se` | Open in firewall HIS → middleware |
| `username` / `password` | Optional Basic Auth | Choose locally if HIS expects auth |

Start the listener later with `php cmd.php se`.

---

## Step 13 — Text labels and degree programmes

These keys choose which HIS name is sent to ILIAS for a course, its groups, the term, and the lecture type. IDs stay the same. After you change one, export again (`php cmd.php lc <term> <year>`) so ILIAS receives the new labels.

HIS stores up to three names for the same object. Each value under `HIS.text` must be one of:

| Value | HIS name |
|-------|----------|
| `getShortText` | Short name |
| `getDefaultText` | Usual name. Keep this unless a label looks wrong |
| `getLongText` | Long name |

A missing key, or any other value, falls back to `getDefaultText`.

### Degree programmes

`config.json.dist` still has the placeholder `"true|false"`. Replace it with a JSON boolean (`true` or `false`), not a string.

| Value | What ILIAS receives |
|-------|---------------------|
| `true` | If one course is linked to several study forms that share the same title, that title is sent once |
| `false` | Every study form is sent, even when the titles are identical |

Those titles always come from the HIS default text. `HIS.text` does not change them. Study forms listed in `blocked_form_of_studies_ids` (Step 10) are dropped before this check.

### Course, term, and lecture-type labels

| Key | Label in the export | Change it when |
|-----|---------------------|----------------|
| `text.unit` | Course title, when the course has more than one plan element | The course name should be the unit's short or long text |
| `text.plan_element` | Course title, when the course has exactly one plan element. Also each group title when `group_title_from_plan_element` is `true` | That name should be the plan element's short or long text |
| `text.event_type` | `lectureType` (for example lecture or seminar) | The type name should be the short or long text |
| `text.term` | Term name inside `termID`. The year is added after it, for example `Wintersemester 2026` | The term name should be the short or long text |
| `text.current_term` | Not used in the export | Leave `getDefaultText`. The current term only supplies its number and year |

### Group titles (`group_title_from_plan_element`)

This chooses `groups[].title`:

| Value | Title ILIAS gets |
|-------|------------------|
| `false` (default) | The parallel-group type, always its long text (for example "Übung"). `HIS.text` does not change this. List the types with `php cmd.php gp` |
| `true` | The plan-element title, using `text.plan_element` |

Set `true` when each ILIAS group should be named after its own plan element, not after the shared group type.

---

## Step 14 — Optional: ILIAS → HIS link sync

Skip unless you want ILIAS course URLs written back into HIS.

| Key | Suggested | Notes |
|-----|-----------|-------|
| `create_links` | `true` | Needs Local ECS + ILIAS posting URLs |
| `process_links_count` | `5` | Batch size per `php cmd.php ls` run |
| `link_creation_title` | `"ILIAS"` | Empty → lecture title is used |

---

## Step 15 — PHPUnit (developers only)

| Key | Suggested |
|-----|-----------|
| `PHPUnit.coverage` | `"false"` unless you measure coverage |

---

## Step 16 — Smoke-test the configuration

1. List commands:

   ```bash
   php cmd.php
   ```

2. Confirm discovery still works:

   ```bash
   php cmd.php ge
   php cmd.php cm
   php cmd.php gb
   ```

3. (Optional) Check term defaults:

   ```bash
   php cmd.php ct
   ```

4. Run a small export (use your term type ID and year from Step 11):

   ```bash
   php cmd.php lc 2 2026
   ```

5. Inspect `path_to_log` and `path_to_queue`.

6. Start the queue watcher when ready:

   ```bash
   php cmd.php sq
   ```

7. After go-live, set `"debug"` off if you do not need debug CLI commands.

---

## Checklist

Use this as a final pass:

- [ ] Step 2 — HIS `username`, `password`, `url`
- [ ] Step 3 — `queue_type` (+ `Database.dsn` if `db_based`)
- [ ] Step 4 — `path_to_queue`, `path_to_log`
- [ ] Step 5 — ECS remote **or** Local ECS
- [ ] Step 7 — `HIStoECSMapping` from `ge` + ECS mid
- [ ] Step 8 — `HIStoECSCourseMapping` from `cm` + `0`–`3`
- [ ] Step 9 — `person_id_type` matches ILIAS
- [ ] Step 10 — filters from `gb` / `gf` / `gw`
- [ ] Step 16 — smoke export succeeded

---

## Related docs

- Broader install: [his_in_one_middleware_installation_and_configuration.md](his_in_one_middleware_installation_and_configuration.md)
- HIS SOAP roles: [his_in_one_configuration.md](his_in_one_configuration.md)
- Classic ECS server: [ecs_installation_configuration.md](ecs_installation_configuration.md)
- Template: [`config.json.dist`](../config.json.dist)
