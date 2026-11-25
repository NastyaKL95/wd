-- Adminer 6.3.1 MySQL 8.4.13 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE DATABASE `konkurs` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `konkurs`;

CREATE TABLE `awards` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `participant_id` bigint unsigned NOT NULL,
  `contest_id` bigint unsigned NOT NULL,
  `place` int NOT NULL,
  `award_description` text COLLATE utf8mb4_unicode_ci,
  `is_manual_override` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `consent_documents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `contest_attachment_fields` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `contest_id` bigint unsigned NOT NULL,
  `sort_order` smallint NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirements` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `contest_expert_pool` (
  `contest_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`contest_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `contest_moderators` (
  `contest_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`contest_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `contest_moderators` (`contest_id`, `user_id`) VALUES
(2,	1);

CREATE TABLE `contest_participants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `contest_id` bigint unsigned NOT NULL,
  `admitted_max_stage_order` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_contest_participants_user_contest` (`user_id`,`contest_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `contest_series` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(280) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `cover_image_path` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `contests` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` smallint NOT NULL DEFAULT '1',
  `document_intake_closed` tinyint(1) NOT NULL DEFAULT '0',
  `require_explicit_stage_admission` tinyint(1) NOT NULL DEFAULT '0',
  `stage_conduct_mode` tinyint(1) NOT NULL DEFAULT '0',
  `image_path` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `regulations_path` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `documents_link` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `series_id` bigint unsigned DEFAULT NULL,
  `is_external` tinyint(1) NOT NULL DEFAULT '0',
  `external_url` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `is_archived` tinyint(1) NOT NULL DEFAULT '0',
  `archived_at` timestamp NULL DEFAULT NULL,
  `archive_report_path` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_contests_series_id` (`series_id`),
  CONSTRAINT `contests_dates_check` CHECK ((`end_date` > `start_date`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `contests` (`id`, `title`, `start_date`, `end_date`, `description`, `status`, `document_intake_closed`, `require_explicit_stage_admission`, `stage_conduct_mode`, `image_path`, `regulations_path`, `documents_link`, `series_id`, `is_external`, `external_url`, `is_archived`, `archived_at`, `archive_report_path`) VALUES
(2,	'Черновик',	'2026-01-10',	'2026-12-31',	'Черновик',	1,	0,	0,	0,	NULL,	NULL,	'',	NULL,	0,	'',	0,	NULL,	NULL);

CREATE TABLE `criteria` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `stage_id` bigint unsigned NOT NULL,
  `group_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_points` int NOT NULL DEFAULT '0',
  `max_points` int NOT NULL,
  `weight` int NOT NULL DEFAULT '100',
  `sort_order` smallint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_criteria_criterion_group` (`group_id`),
  KEY `idx_criteria_stage_group_sort` (`stage_id`,`group_id`,`sort_order`,`id`),
  CONSTRAINT `fk_criteria_criterion_group` FOREIGN KEY (`group_id`) REFERENCES `criterion_groups` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `criterion_groups` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `stage_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` smallint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_criterion_groups_stage_sort` (`stage_id`,`sort_order`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `evaluations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `expert_id` bigint unsigned NOT NULL,
  `submission_id` bigint unsigned NOT NULL,
  `criterion_id` bigint unsigned NOT NULL,
  `points` int NOT NULL,
  `evaluated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `expert_id` (`expert_id`,`submission_id`,`criterion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `in_app_notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci,
  `link` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '/',
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_notifications_user_created` (`user_id`,`created_at` DESC),
  KEY `idx_notifications_user_read` (`user_id`,`is_read`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `participant_attachments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `contest_id` bigint unsigned NOT NULL,
  `field_id` bigint unsigned NOT NULL,
  `file_path` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`contest_id`,`field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `password_reset_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `token_hash` char(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_prt_token_hash` (`token_hash`),
  KEY `idx_prt_user` (`user_id`),
  KEY `idx_prt_expires` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `site_announcements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(280) COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `is_pinned` tinyint(1) NOT NULL DEFAULT '0',
  `published_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `site_announcements` (`id`, `title`, `slug`, `summary`, `body`, `is_published`, `is_pinned`, `published_at`, `created_at`, `updated_at`) VALUES
(1,	'Запустили сайт для конкурсов!',	'запустили-сайт-для-конкурсов',	'Новый инструмент для школьных и педагогических конкурсов',	'Педагоги, методисты, руководители образовательных проектов — у нас хорошие новости! Запущен сайт специально адаптированный под проведение профессиональных конкурсов.',	1,	1,	'2026-11-25 11:55:00',	'2026-11-25 02:56:06',	'2026-11-25 02:56:45');

CREATE TABLE `site_partners` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website_url` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `logo_path` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `stage_attachment_fields` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `stage_id` bigint unsigned NOT NULL,
  `sort_order` smallint NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirements` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `stage_experts` (
  `stage_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`stage_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `stages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `contest_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `instruction_file_path` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `external_link` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `external_link_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` int NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `submission_deadline` date DEFAULT NULL,
  `evaluation_mode` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'all',
  `experts_per_submission` smallint NOT NULL DEFAULT '2',
  `include_scores_in_final_ranking` tinyint(1) NOT NULL DEFAULT '0',
  `phase_status` tinyint NOT NULL DEFAULT '1',
  `stage_format` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_stages_contest_order` (`contest_id`,`sort_order`),
  CONSTRAINT `stages_dates_check` CHECK ((`end_date` > `start_date`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `stages` (`id`, `contest_id`, `title`, `description`, `instruction_file_path`, `external_link`, `external_link_enabled`, `sort_order`, `start_date`, `end_date`, `submission_deadline`, `evaluation_mode`, `experts_per_submission`, `include_scores_in_final_ranking`, `phase_status`, `stage_format`) VALUES
(3,	2,	'Ð­Ñ‚Ð°Ð¿ 1',	'ÐŸÐµÑ€Ð²Ñ‹Ð¹ ÑÑ‚Ð°Ð¿ (Ð´ÐµÐ¼Ð¾).',	NULL,	'',	0,	1,	'2026-01-10',	'2026-06-30',	NULL,	'all',	2,	0,	1,	0),
(4,	2,	'Ð­Ñ‚Ð°Ð¿ 2',	'Ð’Ñ‚Ð¾Ñ€Ð¾Ð¹ ÑÑ‚Ð°Ð¿ (Ð´ÐµÐ¼Ð¾).',	NULL,	'',	0,	2,	'2026-07-01',	'2026-12-31',	NULL,	'all',	2,	0,	1,	0);

CREATE TABLE `submission_assigned_experts` (
  `submission_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`submission_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `submission_attachments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `submission_id` bigint unsigned NOT NULL,
  `field_id` bigint unsigned NOT NULL,
  `file_path` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `submission_id` (`submission_id`,`field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `submissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `contest_id` bigint unsigned NOT NULL,
  `stage_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `work_link` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `optional_attachments_status` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'na',
  `optional_attachments_rejection_reason` text COLLATE utf8mb4_unicode_ci,
  `optional_attachments_reviewed_at` timestamp NULL DEFAULT NULL,
  `optional_attachments_reviewed_by` bigint unsigned DEFAULT NULL,
  `submission_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`stage_id`),
  KEY `idx_submissions_contest_stage` (`contest_id`,`stage_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `system_roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `system_roles` (`id`, `slug`, `name`) VALUES
(1,	'admin',	'Администратор'),
(2,	'moderator',	'Модератор'),
(3,	'expert',	'Эксперт'),
(4,	'participant',	'Участник');

CREATE TABLE `user_consents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `contest_id` bigint unsigned NOT NULL,
  `consent_file_path` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `rejection_reason` text COLLATE utf8mb4_unicode_ci,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `reviewed_by` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`contest_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `user_roles` (
  `user_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user_roles` (`user_id`, `role_id`) VALUES
(1,	1);

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `oauth_provider` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oauth_subject` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `middle_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `school` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `municipality` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_staff` tinyint(1) NOT NULL DEFAULT '0',
  `is_superuser` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `uq_users_oauth` (`oauth_provider`,`oauth_subject`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `email`, `password_hash`, `oauth_provider`, `oauth_subject`, `first_name`, `last_name`, `middle_name`, `date_of_birth`, `school`, `region`, `municipality`, `is_active`, `is_staff`, `is_superuser`, `created_at`, `updated_at`) VALUES
(1,	'admin@iro.local',	'$2y$10$Fs84F/UWhsruNLTPqPkvqewKLLKXGhTWGqltSjXQGPoGwnrHlZKqS',	NULL,	NULL,	'Админ',	'Сайта',	NULL,	NULL,	NULL,	NULL,	NULL,	1,	1,	1,	'2026-11-24 13:51:36',	'2026-11-24 13:51:36'),
(2,	'nastyaklopova.95.95@gmail.com',	'$2y$10$Fs84F/UWhsruNLTPqPkvqewKLLKXGhTWGqltSjXQGPoGwnrHlZKqS',	NULL,	NULL,	'Анастасия',	'Клопова',	'Владимировна',	NULL,	NULL,	'Забайкальский край',	'Чита',	1,	0,	0,	'2026-11-25 01:54:56',	'2026-11-25 01:54:56');

-- 2026-11-25 02:58:55 UTC
