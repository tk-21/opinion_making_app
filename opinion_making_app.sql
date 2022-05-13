DROP DATABASE opinion_making_app;
CREATE DATABASE IF NOT EXISTS opinion_making_app DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE opinion_making_app;



-- ---
-- Table 'topics'
--
-- ---

DROP TABLE IF EXISTS `topics`;

CREATE TABLE `topics` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'トピックID',
  `title` varchar(30) NOT NULL COMMENT 'トピックタイトル',
  `body` text NOT NULL COMMENT 'トピック本文',
  `position` text NOT NULL COMMENT 'トピックに対して自らがとるポジション',
  `complete_flg` int(1) NOT NULL DEFAULT '0' COMMENT '完了フラグ（1:完了　0:未完了）',
  `category_id` int(10) DEFAULT NULL COMMENT 'カテゴリーID',
  `user_id` varchar(10) NOT NULL COMMENT '作成したユーザーID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最終更新日時',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '削除日時',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;



-- ---
-- Table 'users'
--
-- ---

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ユーザーID',
  `name` varchar(10) NOT NULL COMMENT 'ユーザーネーム',
  `password` varchar(60) NOT NULL COMMENT 'パスワード',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最終更新日時',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '削除日時',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;



-- ---
-- Table 'objections'
-- 反論テーブル
-- ---

DROP TABLE IF EXISTS `objections`;

CREATE TABLE `objections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `body` text NOT NULL COMMENT '反論本文',
  `topic_id` int(10) NOT NULL COMMENT 'トピックID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最終更新日時',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '削除日時',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB COMMENT '反論テーブル';



-- ---
-- Table 'counter_objections'
-- 反論への反論
-- ---

DROP TABLE IF EXISTS `counter_objections`;

CREATE TABLE `counter_objections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `body` text NOT NULL COMMENT '反論への反論本文',
  `topic_id` int(10) NOT NULL COMMENT 'トピックID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最終更新日時',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '削除日時',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB COMMENT '反論への反論';



-- ---
-- Table 'opinions'
-- 最終的な自分の意見
-- ---

DROP TABLE IF EXISTS `opinions`;

CREATE TABLE `opinions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `opinion` text NOT NULL COMMENT '意見本文',
  `reason` text NOT NULL COMMENT 'その理由',
  `topic_id` int(10) NOT NULL COMMENT 'トピックID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最終更新日時',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '削除日時',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB COMMENT '最終的な自分の意見';



-- ---
-- Table 'categories'
-- カテゴリー
-- ---

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL COMMENT 'カテゴリ名',
  `user_id` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最終更新日時',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '削除日時',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB COMMENT 'カテゴリー';


