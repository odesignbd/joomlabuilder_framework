-- JoomlaBuilder Schema Update to v1.0.3

-- Add a new column for storing template metadata
ALTER TABLE `#__joomlabuilder_templates`
ADD COLUMN `metadata` TEXT NULL AFTER `data`;

-- Create a new table for storing template usage statistics
CREATE TABLE `#__joomlabuilder_usage_stats` (
    `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `template_id` INT(11) UNSIGNED NOT NULL,
    `views` INT(11) UNSIGNED DEFAULT 0,
    `downloads` INT(11) UNSIGNED DEFAULT 0,
    `last_used` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`template_id`) REFERENCES `#__joomlabuilder_templates`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert a new setting for tracking template analytics
INSERT INTO `#__joomlabuilder_settings` (`key`, `value`) 
SELECT 'track_template_usage', '1' FROM DUAL 
WHERE NOT EXISTS (SELECT `key` FROM `#__joomlabuilder_settings` WHERE `key` = 'track_template_usage');
