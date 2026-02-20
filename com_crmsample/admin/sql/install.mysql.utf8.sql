CREATE TABLE IF NOT EXISTS `#__crmsample_companies` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `current_stage` VARCHAR(50) NOT NULL DEFAULT 'Ice',
    `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `modified` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_current_stage` (`current_stage`),
    INDEX `idx_created` (`created`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__crmsample_stages` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `stage_code` VARCHAR(50) NOT NULL,
    `title` VARCHAR(100) NOT NULL,
    `ordering` INT NOT NULL DEFAULT 0,
    `allow_skip_to` TEXT,
    `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `modified` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `idx_stage_code` (`stage_code`),
    INDEX `idx_ordering` (`ordering`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__crmsample_events` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `company_id` INT UNSIGNED NOT NULL,
    `event_type` VARCHAR(50) NOT NULL,
    `event_data` TEXT,
    `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_company_id` (`company_id`),
    INDEX `idx_created` (`created`),
    INDEX `idx_event_type` (`event_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__crmsample_stage_history` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `company_id` INT UNSIGNED NOT NULL,
    `from_stage` VARCHAR(50) NOT NULL,
    `to_stage` VARCHAR(50) NOT NULL,
    `user_id` INT UNSIGNED NOT NULL,
    `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_company_id` (`company_id`),
    INDEX `idx_created` (`created`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

INSERT INTO `#__crmsample_stages` (`stage_code`, `title`, `ordering`, `allow_skip_to`) VALUES
('Ice', 'Ice', 1, '["Touched"]'),
('Touched', 'Touched', 2, '["Aware"]'),
('Aware', 'Aware', 3, '["Interested"]'),
('Interested', 'Interested', 4, '["demo_planned"]'),
('demo_planned', 'demo planned', 5, '["Demo_done"]'),
('Demo_done', 'Demo done', 6, '["Committed"]'),
('Committed', 'Committed', 7, '["Customer"]'),
('Customer', 'Customer', 8, '["Activated"]'),
('Activated', 'Activated', 9, '[]'),
('Null', 'Null', 10, '[]');