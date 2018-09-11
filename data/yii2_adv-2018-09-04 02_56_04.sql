-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.6.37 - MySQL Community Server (GPL)
-- Операционная система:         Win32
-- HeidiSQL Версия:              9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Дамп структуры базы данных yii2_adv
CREATE DATABASE IF NOT EXISTS `yii2_adv` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `yii2_adv`;

-- Дамп структуры для таблица yii2_adv.migration
DROP TABLE IF EXISTS `migration`;
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы yii2_adv.migration: ~7 rows (приблизительно)
DELETE FROM `migration`;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` (`version`, `apply_time`) VALUES
	('m000000_000000_base', 1534971735),
	('m130524_201442_init', 1534971757),
	('m180827_124022_create_task_table', 1535378953),
	('m180827_132557_create_project_table', 1535378954),
	('m180827_132702_create_project_user_table', 1535378954),
	('m180903_122010_add_active_column_to_project_table', 1535978003),
	('m180903_144445_add_project_id_column_to_task_table', 1535986374);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;

-- Дамп структуры для таблица yii2_adv.project
DROP TABLE IF EXISTS `project`;
CREATE TABLE IF NOT EXISTS `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `active` tinyint(1) DEFAULT '0',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fx_project_user_1` (`created_by`),
  KEY `fx_project_user_2` (`updated_by`),
  CONSTRAINT `fx_project_user_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fx_project_user_2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы yii2_adv.project: ~0 rows (приблизительно)
DELETE FROM `project`;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
INSERT INTO `project` (`id`, `title`, `description`, `active`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
	(2, 'first', 'first project', 1, 1, NULL, 0, NULL);
/*!40000 ALTER TABLE `project` ENABLE KEYS */;

-- Дамп структуры для таблица yii2_adv.project_user
DROP TABLE IF EXISTS `project_user`;
CREATE TABLE IF NOT EXISTS `project_user` (
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role` enum('manager','developer','tester') DEFAULT NULL,
  KEY `fx_project_user_user` (`user_id`),
  KEY `fx_project_user_project` (`project_id`),
  CONSTRAINT `fx_project_user_project` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fx_project_user_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы yii2_adv.project_user: ~0 rows (приблизительно)
DELETE FROM `project_user`;
/*!40000 ALTER TABLE `project_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_user` ENABLE KEYS */;

-- Дамп структуры для таблица yii2_adv.task
DROP TABLE IF EXISTS `task`;
CREATE TABLE IF NOT EXISTS `task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `estimation` int(11) NOT NULL,
  `project_id` int(11) NOT NULL DEFAULT '1',
  `executor_id` int(11) DEFAULT NULL,
  `started_at` int(11) DEFAULT NULL,
  `completed_at` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fx_task_user_1` (`executor_id`),
  KEY `fx_task_user_2` (`created_by`),
  KEY `fx_task_user_3` (`updated_by`),
  KEY `idx-task-project_id` (`project_id`),
  CONSTRAINT `fk-task-project_id` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fx_task_user_1` FOREIGN KEY (`executor_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fx_task_user_2` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fx_task_user_3` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы yii2_adv.task: ~0 rows (приблизительно)
DELETE FROM `task`;
/*!40000 ALTER TABLE `task` DISABLE KEYS */;
INSERT INTO `task` (`id`, `title`, `description`, `estimation`, `project_id`, `executor_id`, `started_at`, `completed_at`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
	(7, '1st task', 'my first task', 1, 2, NULL, NULL, NULL, 1, NULL, 0, NULL);
/*!40000 ALTER TABLE `task` ENABLE KEYS */;

-- Дамп структуры для таблица yii2_adv.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы yii2_adv.user: ~0 rows (приблизительно)
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'admin', 'nzs0J84JgTDjmvkWfH6LKeyk9-1CiIy9', '$2y$13$RyZ0s6kXLkd/AC1odNbb7ueAN4Xjf72k0gMCuXgbQ40D6OLA9wVx6', NULL, 'admin@adm.in', 10, 1536015979, 1536015979),
	(2, 'admin2', 'Lqk9c_4VZoK1Wo2lrhyIDscyxopJA2H5', '$2y$13$UfiM9bZ9AHFgX29hQr7JKeeDAtva7ez/3gSzVuimUa8ciMfGUVJSW', NULL, 'admin2@adm.in', 10, 1536016038, 1536016038),
	(4, 'admin3', '_lvje6ziez4iUxl4zY1CoRjA1uY5qa09', '$2y$13$G1HXPHHc908y5qxADZo3ZOpbjiIaB4blNL13Ii.5v37GbNlpV2nVy', NULL, 'admin_3@adm.in', 10, 1536016698, 1536016846);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
