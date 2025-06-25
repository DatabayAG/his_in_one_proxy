# If you want to use sqlite, you need to create following tables:

---
    DROP TABLE IF EXISTS maintenance_queue;
   
    CREATE TABLE maintenance_queue (
        maintenance_id INTEGER PRIMARY KEY AUTOINCREMENT,
        data BLOB DEFAULT NULL,
        func TEXT DEFAULT NULL,
        receiver TEXT DEFAULT NULL,
        unix_time TEXT DEFAULT NULL
    );

---
    DROP TABLE IF EXISTS participants;

    CREATE TABLE participants (
        participants_id INTEGER PRIMARY KEY AUTOINCREMENT,
        pid INTEGER NOT NULL,
        mid INTEGER NOT NULL,
        name TEXT NOT NULL,
        description TEXT NOT NULL,
        dns TEXT DEFAULT NULL,
        email TEXT NOT NULL,
        org_name TEXT NOT NULL,
        org_abbr TEXT NOT NULL
    );

---
    DROP TABLE IF EXISTS service_queue;

    CREATE TABLE service_queue (
        service_id INTEGER PRIMARY KEY AUTOINCREMENT,
        data BLOB DEFAULT NULL,
        func TEXT DEFAULT NULL,
        receiver TEXT DEFAULT NULL,
        unix_time TEXT DEFAULT NULL,
        checksum TEXT DEFAULT NULL,
        sent TEXT DEFAULT NULL,
        lecture_id TEXT DEFAULT NULL
    );

---

    DROP TABLE IF EXISTS link_queue;

    CREATE TABLE link_queue (
        link_id INTEGER PRIMARY KEY AUTOINCREMENT,
        unit_id INTEGER NOT NULL,
        term_type INTEGER NOT NULL,
        term_year INTEGER NOT NULL,
        description TEXT NOT NULL,
        link TEXT NOT NULL,
        ecs_course_url TEXT NOT NULL,
        checksum TEXT DEFAULT NULL,
        sent TEXT DEFAULT NULL
    );
