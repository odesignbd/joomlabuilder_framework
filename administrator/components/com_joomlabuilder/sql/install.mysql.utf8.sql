-- JoomlaBuilder Installation SQL Script

-- Drop tables if they already exist
DROP TABLE IF EXISTS `#__joomlabuilder_templates`;
DROP TABLE IF EXISTS `#__joomlabuilder_sections`;
DROP TABLE IF EXISTS `#__joomlabuilder_settings`;

-- Create Templates Table
CREATE TABLE `#__joomlabuilder_templates` (
    `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `description` TEXT,
    `data` LONGTEXT NOT NULL,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `modified` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create Sections Table
CREATE TABLE `#__joomlabuilder_sections` (
    `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `template_id` INT(11) UNSIGNED NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `content` LONGTEXT NOT NULL,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`template_id`) REFERENCES `#__joomlabuilder_templates`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create Settings Table
CREATE TABLE `#__joomlabuilder_settings` (
    `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `key` VARCHAR(255) NOT NULL UNIQUE,
    `value` TEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert Default Settings
INSERT INTO `#__joomlabuilder_settings` (`key`, `value`) VALUES
('enable_logging', '1'),
('debug_mode', '0'),
('default_template', 'joomlabuilder_default');
 
