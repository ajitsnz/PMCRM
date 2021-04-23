ALTER TABLE tasks CHANGE start_date start_date DATETIME NULL;
 
ALTER TABLE tickets CHANGE priority_id priority_id INT UNSIGNED DEFAULT NULL, CHANGE service_id service_id INT UNSIGNED DEFAULT NULL;
