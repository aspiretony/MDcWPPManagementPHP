

--- new programs of 3.0.0
INSERT INTO system_program VALUES((select coalesce(max(id),0)+1 from system_program b),'System PHP Info','SystemPHPInfoView');
INSERT INTO system_program VALUES((select coalesce(max(id),0)+1 from system_program b),'System ChangeLog View','SystemChangeLogView');
INSERT INTO system_program VALUES((select coalesce(max(id),0)+1 from system_program b),'Welcome View','WelcomeView');
INSERT INTO system_program VALUES((select coalesce(max(id),0)+1 from system_program b),'System Sql Log','SystemSqlLogList');
INSERT INTO system_program VALUES((select coalesce(max(id),0)+1 from system_program b),'System Profile View','SystemProfileView');
INSERT INTO system_program VALUES((select coalesce(max(id),0)+1 from system_program b),'System Profile Form','SystemProfileForm');
INSERT INTO system_program VALUES((select coalesce(max(id),0)+1 from system_program b),'System SQL Panel','SystemSQLPanel');
INSERT INTO system_program VALUES((select coalesce(max(id),0)+1 from system_program b),'System Access Log','SystemAccessLogList');

INSERT INTO system_group_program VALUES((select coalesce(max(id),0)+1 from system_group_program b), 1,
                                        (select id from system_program where controller='SystemPHPInfoView'));
INSERT INTO system_group_program VALUES((select coalesce(max(id),0)+1 from system_group_program b), 1,
                                        (select id from system_program where controller='SystemChangeLogView'));
INSERT INTO system_group_program VALUES((select coalesce(max(id),0)+1 from system_group_program b), 1,
                                        (select id from system_program where controller='SystemSqlLogList'));
INSERT INTO system_group_program VALUES((select coalesce(max(id),0)+1 from system_group_program b), 1,
                                        (select id from system_program where controller='SystemSQLPanel'));
INSERT INTO system_group_program VALUES((select coalesce(max(id),0)+1 from system_group_program b), 1,
                                        (select id from system_program where controller='SystemAccessLogList'));
INSERT INTO system_group_program VALUES((select coalesce(max(id),0)+1 from system_group_program b), 2,
                                        (select id from system_program where controller='WelcomeView'));
INSERT INTO system_group_program VALUES((select coalesce(max(id),0)+1 from system_group_program b), 2,
                                        (select id from system_program where controller='SystemProfileView'));
INSERT INTO system_group_program VALUES((select coalesce(max(id),0)+1 from system_group_program b), 2,
                                        (select id from system_program where controller='SystemProfileForm'));
UPDATE system_user set frontpage_id = (select id from system_program b where controller='WelcomeView') where id=1;


--- new programs of 4.0
INSERT INTO system_program VALUES((select coalesce(max(id),0)+1 from system_program b),'System Message Form','SystemMessageForm');
INSERT INTO system_program VALUES((select coalesce(max(id),0)+1 from system_program b),'System Message List','SystemMessageList');
INSERT INTO system_program VALUES((select coalesce(max(id),0)+1 from system_program b),'System Message Form View','SystemMessageFormView');
INSERT INTO system_program VALUES((select coalesce(max(id),0)+1 from system_program b),'System Notification List','SystemNotificationList');
INSERT INTO system_program VALUES((select coalesce(max(id),0)+1 from system_program b),'System Notification Form View','SystemNotificationFormView');
INSERT INTO system_program VALUES((select coalesce(max(id),0)+1 from system_program b),'System Document Category List','SystemDocumentCategoryFormList');
INSERT INTO system_program VALUES((select coalesce(max(id),0)+1 from system_program b),'System Document Form','SystemDocumentForm');
INSERT INTO system_program VALUES((select coalesce(max(id),0)+1 from system_program b),'System Document Upload Form','SystemDocumentUploadForm');
INSERT INTO system_program VALUES((select coalesce(max(id),0)+1 from system_program b),'System Document List','SystemDocumentList');
INSERT INTO system_program VALUES((select coalesce(max(id),0)+1 from system_program b),'System Shared Document List','SystemSharedDocumentList');
INSERT INTO system_program VALUES((select coalesce(max(id),0)+1 from system_program b),'System Unit Form','SystemUnitForm');
INSERT INTO system_program VALUES((select coalesce(max(id),0)+1 from system_program b),'System Unit List','SystemUnitList');
INSERT INTO system_program VALUES((select coalesce(max(id),0)+1 from system_program b),'System Access stats','SystemAccessLogStats');
INSERT INTO system_program VALUES((select coalesce(max(id),0)+1 from system_program b),'System Preference form','SystemPreferenceForm');
INSERT INTO system_program VALUES((select coalesce(max(id),0)+1 from system_program b),'System Support form','SystemSupportForm');


INSERT INTO system_group_program VALUES((select coalesce(max(id),0)+1 from system_group_program b), 2,
                                        (select id from system_program where controller='SystemMessageForm'));
INSERT INTO system_group_program VALUES((select coalesce(max(id),0)+1 from system_group_program b), 2,
                                        (select id from system_program where controller='SystemMessageList'));
INSERT INTO system_group_program VALUES((select coalesce(max(id),0)+1 from system_group_program b), 2,
                                        (select id from system_program where controller='SystemMessageFormView'));
INSERT INTO system_group_program VALUES((select coalesce(max(id),0)+1 from system_group_program b), 2,
                                        (select id from system_program where controller='SystemNotificationList'));
INSERT INTO system_group_program VALUES((select coalesce(max(id),0)+1 from system_group_program b), 2,
                                        (select id from system_program where controller='SystemNotificationFormView'));
INSERT INTO system_group_program VALUES((select coalesce(max(id),0)+1 from system_group_program b), 1,
                                        (select id from system_program where controller='SystemDocumentCategoryFormList'));
INSERT INTO system_group_program VALUES((select coalesce(max(id),0)+1 from system_group_program b), 2,
                                        (select id from system_program where controller='SystemDocumentForm'));
INSERT INTO system_group_program VALUES((select coalesce(max(id),0)+1 from system_group_program b), 2,
                                        (select id from system_program where controller='SystemDocumentUploadForm'));
INSERT INTO system_group_program VALUES((select coalesce(max(id),0)+1 from system_group_program b), 2,
                                        (select id from system_program where controller='SystemDocumentList'));
INSERT INTO system_group_program VALUES((select coalesce(max(id),0)+1 from system_group_program b), 2,
                                        (select id from system_program where controller='SystemSharedDocumentList'));
INSERT INTO system_group_program VALUES((select coalesce(max(id),0)+1 from system_group_program b), 1,
                                        (select id from system_program where controller='SystemUnitForm'));
INSERT INTO system_group_program VALUES((select coalesce(max(id),0)+1 from system_group_program b), 1,
                                        (select id from system_program where controller='SystemUnitList'));
INSERT INTO system_group_program VALUES((select coalesce(max(id),0)+1 from system_group_program b), 1,
                                        (select id from system_program where controller='SystemAccessLogStats'));
INSERT INTO system_group_program VALUES((select coalesce(max(id),0)+1 from system_group_program b), 1,
                                        (select id from system_program where controller='SystemPreferenceForm'));
INSERT INTO system_group_program VALUES((select coalesce(max(id),0)+1 from system_group_program b), 2,
                                        (select id from system_program where controller='SystemSupportForm'));

CREATE TABLE system_unit (
    id INTEGER PRIMARY KEY NOT NULL,
    name varchar(100));
    
ALTER TABLE system_user add column system_unit_id int references system_unit(id);
ALTER TABLE system_user add column active char(1);
UPDATE system_user set active='Y';

CREATE TABLE system_preference (
    id text,
    value text
);


--- new programs of 5.0
CREATE TABLE system_user_unit (
    id INTEGER PRIMARY KEY NOT NULL,
    system_user_id int,
    system_unit_id int,
    FOREIGN KEY(system_user_id) REFERENCES system_user(id),
    FOREIGN KEY(system_unit_id) REFERENCES system_unit(id));

INSERT INTO system_program VALUES((select coalesce(max(id),0)+1 from system_program b),'System PHP Error','SystemPHPErrorLogView');

INSERT INTO system_group_program VALUES((select coalesce(max(id),0)+1 from system_group_program b), 1,
                                        (select id from system_program where controller='SystemPHPErrorLogView'));

INSERT INTO system_program VALUES((select coalesce(max(id),0)+1 from system_program b),'System Database Browser','SystemDatabaseExplorer');
INSERT INTO system_program VALUES((select coalesce(max(id),0)+1 from system_program b),'System Table List','SystemTableList');
INSERT INTO system_program VALUES((select coalesce(max(id),0)+1 from system_program b),'System Data Browser','SystemDataBrowser');

INSERT INTO system_group_program VALUES((select coalesce(max(id),0)+1 from system_group_program b), 1,
                                        (select id from system_program where controller='SystemDatabaseExplorer'));
                                        
INSERT INTO system_group_program VALUES((select coalesce(max(id),0)+1 from system_group_program b), 1,
                                        (select id from system_program where controller='SystemTableList'));
                                        
INSERT INTO system_group_program VALUES((select coalesce(max(id),0)+1 from system_group_program b), 1,
                                        (select id from system_program where controller='SystemDataBrowser'));
                                        
--- new programs of 7.0
INSERT INTO system_program VALUES((select coalesce(max(id),0)+1 from system_program b),'System Menu Editor','SystemMenuEditor');
INSERT INTO system_group_program VALUES((select coalesce(max(id),0)+1 from system_group_program b), 1,
                                        (select id from system_program where controller='SystemMenuEditor'));

INSERT INTO system_program VALUES((select coalesce(max(id),0)+1 from system_program b),'System Request Log','SystemRequestLogList');
INSERT INTO system_group_program VALUES((select coalesce(max(id),0)+1 from system_group_program b), 1,
                                        (select id from system_program where controller='SystemRequestLogList'));
                                        
INSERT INTO system_program VALUES((select coalesce(max(id),0)+1 from system_program b),'System Request Log View','SystemRequestLogView');
INSERT INTO system_group_program VALUES((select coalesce(max(id),0)+1 from system_group_program b), 1,
                                        (select id from system_program where controller='SystemRequestLogView'));
                                        
INSERT INTO system_program VALUES((select coalesce(max(id),0)+1 from system_program b),'System Administration Dashboard','SystemAdministrationDashboard');
INSERT INTO system_group_program VALUES((select coalesce(max(id),0)+1 from system_group_program b), 1,
                                        (select id from system_program where controller='SystemAdministrationDashboard'));
                                        
INSERT INTO system_program VALUES((select coalesce(max(id),0)+1 from system_program b),'System Log Dashboard','SystemLogDashboard');
INSERT INTO system_group_program VALUES((select coalesce(max(id),0)+1 from system_group_program b), 1,
                                        (select id from system_program where controller='SystemLogDashboard'));
                                        
ALTER TABLE system_unit add column connection_name TEXT;
                                        
INSERT INTO system_program VALUES((select coalesce(max(id),0)+1 from system_program b),'System Session dump','SystemSessionDumpView');
INSERT INTO system_group_program VALUES((select coalesce(max(id),0)+1 from system_group_program b), 1,
                                        (select id from system_program where controller='SystemSessionDumpView'));

--- new programs of 7.4
INSERT INTO system_program VALUES((select coalesce(max(id),0)+1 from system_program b),'System files diff','SystemFilesDiff');
INSERT INTO system_group_program VALUES((select coalesce(max(id),0)+1 from system_group_program b), 1,
                                        (select id from system_program where controller='SystemFilesDiff'));

INSERT INTO system_program VALUES((select coalesce(max(id),0)+1 from system_program b),'System Information','SystemInformationView');
INSERT INTO system_group_program VALUES((select coalesce(max(id),0)+1 from system_group_program b), 1,
                                        (select id from system_program where controller='SystemInformationView'));

--- new columns of 7.4
ALTER TABLE system_user add column accepted_term_policy char(1);
ALTER TABLE system_user add column accepted_term_policy_at TEXT;
UPDATE system_user set accepted_term_policy='N';
