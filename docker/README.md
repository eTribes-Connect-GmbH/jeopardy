# Shopware 6 docker setup

This repository provides a docker setup for the most basic Shopware 6 project possible, without ElasticSearch or any other fancy stuff.

## Scripts

### generate_config.sh

This script is responsible for interactively creating new environment files for Shopware.

```shell script
# Usage
./generate_config.sh <name of the environment>

# Variables
ENV="<name of the environment>"
```

### compose_dev.sh

This script runs the docker-compose command with the required configs for the development environment set via the `-f` parameter.

```shell script
# Usage
./compose_dev.sh <docker-compose arguments>
```

### import_dump.sh

This script imports a database dump and updates the sales_channel URLs. This step will replace `$APP_ENV` in the sales channel URL column with whatever is defined in the `../.$ENV.env` (this is the Shopware env/config file) file for the variable `$APP_ENV`.

```shell script
# Usage
./import_dump.sh <path to sql_file>

## Piped usage
xzcat <some import file>.sql.xz | ./import_dump.sh

# Variables
ENV="<name of the environment the URL should be used from (default prod)>"
```

## Compatibility

This setup should run on all systems that match the following **requirements**:
- docker-compose >= 1.22.0
- docker >= 19.0.0

### File Sync

Files have to be synced in by using SFTP. The server runs by default on `127.0.0.1:22222`. The username and password is ssh by default.

**NOTE: The SFTP server is only running with the docker-compose.dev.yml** \
**NOTE:** There is no direct mount for Linux users!
