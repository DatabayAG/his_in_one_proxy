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
