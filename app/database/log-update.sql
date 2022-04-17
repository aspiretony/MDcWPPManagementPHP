--- changes from 7.0.0
ALTER TABLE system_access_log add column impersonated char(1);

ALTER TABLE system_access_log add column access_ip TEXT;
ALTER TABLE system_sql_log    add column access_ip TEXT;
ALTER TABLE system_change_log add column access_ip TEXT;

ALTER TABLE system_sql_log    add column transaction_id TEXT;
ALTER TABLE system_change_log add column transaction_id TEXT;

ALTER TABLE system_sql_log    add column log_trace TEXT;
ALTER TABLE system_change_log add column log_trace TEXT;

ALTER TABLE system_sql_log    add column session_id TEXT;
ALTER TABLE system_change_log add column session_id TEXT;

ALTER TABLE system_sql_log    add column php_sapi TEXT;
ALTER TABLE system_change_log add column php_sapi TEXT;

ALTER TABLE system_sql_log    add column class_name TEXT;
ALTER TABLE system_change_log add column class_name TEXT;

ALTER TABLE system_sql_log    add column request_id TEXT;

CREATE TABLE system_request_log (
    id INTEGER PRIMARY KEY NOT NULL,
    endpoint TEXT,
    logdate TEXT,
    log_year varchar(4),
    log_month varchar(2),
    log_day varchar(2),
    session_id TEXT,
    login TEXT,
    access_ip TEXT,
    class_name TEXT,
    http_host TEXT,
    server_port TEXT,
    request_uri TEXT,
    request_method TEXT,
    query_string TEXT,
    request_headers TEXT,
    request_body TEXT,
    request_duration INT
);

ALTER TABLE system_access_log ADD COLUMN login_year varchar(4);
ALTER TABLE system_access_log ADD COLUMN login_month varchar(2);
ALTER TABLE system_access_log ADD COLUMN login_day varchar(2);

ALTER TABLE system_sql_log ADD COLUMN log_year varchar(4);
ALTER TABLE system_sql_log ADD COLUMN log_month varchar(2);
ALTER TABLE system_sql_log ADD COLUMN log_day varchar(2);

ALTER TABLE system_change_log ADD COLUMN log_year varchar(4);
ALTER TABLE system_change_log ADD COLUMN log_month varchar(2);
ALTER TABLE system_change_log ADD COLUMN log_day varchar(2);

--- changes from 7.4.0
ALTER TABLE system_access_log ADD COLUMN impersonated_by text;

CREATE TABLE system_access_notification_log (
    id INTEGER PRIMARY KEY NOT NULL,
    login TEXT,
    email TEXT,
    ip_address TEXT,
    login_time TEXT
);