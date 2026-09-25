# HIS-in-One Proxy

The HIS-in-One Proxy reads lectures, memberships, and the course catalog from HIS-in-One and publishes them to ILIAS.

HIS-in-One and ILIAS do not exchange this data directly. The proxy turns HIS SOAP responses into Campus Connect messages and delivers them, either by pushing to an ECS server or by letting ILIAS poll this host.

## Requirements

- PHP 8.1 or 8.2 with `php-xml`, `php-soap`, and `php-curl`
- HIS-in-One 2025.06 and a technical user that may call the webservices
- ILIAS
- A remote ECS server, or MySQL/MariaDB on this host for Local ECS

## Documentation

| Document | What it covers |
|----------|----------------|
| [docs/his_in_one_middleware_config_short_overview.md](docs/his_in_one_middleware_config_short_overview.md) | Every `config.json` key in one table |
| [docs/his_in_one_middleware_installation_and_configuration_detail_guide.md](docs/his_in_one_middleware_installation_and_configuration_detail_guide.md) | Fill `config.json` step by step, including where each value comes from |
| [docs/his_in_one_middleware_installation_and_configuration.md](docs/his_in_one_middleware_installation_and_configuration.md) | Install outline, packages, and an example `config.json` |
| [docs/his_in_one_configuration.md](docs/his_in_one_configuration.md) | HIS webservice roles and permissions the technical user needs |
| [docs/ecs_installation_configuration.md](docs/ecs_installation_configuration.md) | Install and configure a standalone ECS 4 server |
| [docs/SQLite.md](docs/SQLite.md) | `CREATE TABLE` statements when the queue database is SQLite |

Release notes are in [CHANGELOG.md](CHANGELOG.md). Upgrade steps from a standalone ECS setup are in [UPDATE.md](UPDATE.md).
