# Update Informations

## Config.json
New entries in config.json, please take a look at the "config.json.dist" for details:
  - HIS/workstation_status_ids is now configurable in the config
  - ECS/use_local_ecs => true/false
    - If you want to use the new local implementation of the ecs campus management this value has to be set to true
  - ECS/ecs_community_id
  - Database
  - queue_type file_based/db_based
    - file_based => classic mode
    - db_based => new db based mode

## Commandline functions
New function shortcuts:

- Gets a Lecture by UnitId and force push this course. Uses id as param.


    php cmd.php fo TERM_TYPE_ID TERM_YEAR UNIT_ID

## Database
After configuring the database, following script has to run to create the database tables:

    php src/Database/DBUpdate.php

This will print something like this and create to files two track the updates:
   [cfg_update_info.php](cfg_update_info.php) - [cfg_update_running.php](cfg_update_running.php)

    File: cfg_update_info.php not found, initialising.
    File: cfg_update_running.php not found, initialising.
    Found 3 db updates in update file, 0 updates where applied.
    Trying to apply update 1...
    ...update nr 1 applied.
    Trying to apply update 2...
    ...update nr 2 applied.
    Trying to apply update 3...
    ...update nr 3 applied.


This will create three new tables, please ensure to configure your participants in the table "participants" in your database.

## ECS light implementation

To ensure ILIAS can connect the REST API and is authenticated, there must exist an participant in the table participant, which name matches an entry in the ".htpasswd" file.

To use the local ecs implementation you have to create a ".htpasswd" file and configure your nginx accordingly, you find an example bellow:

Example config for nginx:

    server {
        listen 80;
        server_name localhost;
        client_max_body_size 1024m;

        index index.php;
        root /PATH/TO/his_in_one_proxy2/src/EcsLocal/Routes;
        access_log  /PATH/TO/access.log;
        error_log  /PATH/TO/error.log;
    
        auth_basic           "ECS Area";
        auth_basic_user_file /PATH/TO/.htpasswd;
    
        location / {
            try_files $uri /index.php$is_args$args;
        }
    
        location ~ \.php {
            try_files $uri =404;
            fastcgi_split_path_info ^(.+\.php)(/.+)$;
            include fastcgi_params;
            fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
            fastcgi_param SCRIPT_NAME $fastcgi_script_name;
            fastcgi_index index.php;
            fastcgi_pass unix:/run/php/php8.1-fpm.sock;
            fastcgi_read_timeout 180;
        }
    }


# Helpful commands for installation

Displays the active course mapping types

    php cmd.php cm

Example output:

    HisInOneProxy\DataModel\Container\CourseMappingTypeContainer Object
    (
        [container:protected] => Array
        (
            [1] => HisInOneProxy\DataModel\CourseMappingType Object
            (
                [his_key_id:protected] => 2
                [language_id:protected] => 12
                [id:protected] => 1
                [sort_order:protected] => 1
                [default_text:protected] => Ein ILIAS-Kurs mit Gruppen
            )

            [2] => HisInOneProxy\DataModel\CourseMappingType Object
                (
                    [his_key_id:protected] => 1
                    [language_id:protected] => 12
                    [id:protected] => 2
                    [sort_order:protected] => 2
                    [default_text:protected] => Ein ILIAS-Kurs ohne Gruppen
                )
        )
    )

---

Displays the elearning plattform containers

    php cmd.php ge

Example output:

    HisInOneProxy\DataModel\Container\ElearningPlatformContainer Object
    (
    [container:protected] => Array
        (
            [1] => HisInOneProxy\DataModel\ElearningPlatform Object
                (
                    [his_key_id:protected] => 20
                    [language_id:protected] => 12
                    [id:protected] => 1
                    [sort_order:protected] => 1
                    [default_text:protected] => ILIAS (e-Learning)
                    [unique_name:protected] => ilias
                )
        )
    )

---
Displays all term types

    php cmd.php gt

Example output:

    (
        [30] => HisInOneProxy\DataModel\TermType Object
            (
                [language_id:protected] => 12
                [sort_order:protected] => 1
                [id:protected] => 30
                [short_text:protected] => SoSe
                [long_text:protected] => Sommersemester
                [default_text:protected] => Sommersemester
                [unique_name:protected] => SoSe
            )
    
        [31] => HisInOneProxy\DataModel\TermType Object
            (
                [language_id:protected] => 12
                [sort_order:protected] => 2
                [id:protected] => 31
                [short_text:protected] => WiSe
                [long_text:protected] => Wintersemester
                [default_text:protected] => Wintersemester
                [unique_name:protected] => WiSe
            )
    )
