create table `activity_log`
(
    `id`           bigint unsigned not null auto_increment primary key,
    `log_name`     varchar(191) null,
    `description`  text not null,
    `subject_type` varchar(191) null,
    `subject_id`   bigint unsigned null,
    `causer_type`  varchar(191) null,
    `causer_id`    bigint unsigned null,
    `properties`   json null,
    `created_at`   timestamp null,
    `updated_at`   timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table `activity_log`
    add index `subject`(`subject_type`, `subject_id`);
alter table `activity_log`
    add index `causer`(`causer_type`, `causer_id`);
alter table `activity_log`
    add index `activity_log_log_name_index`(`log_name`);
