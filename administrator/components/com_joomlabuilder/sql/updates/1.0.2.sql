-- JoomlaBuilder Schema Update to v1.0.2

-- Add a new column to track last modified user in templates
ALTER TABLE `#__joomlabuilder_templates`
ADD COLUMN `modified_by` INT(11) UNSIGNED DEFAULT NULL AFTER `modified`;

-- Add foreign key constraint linking `modified_by` to Joomla users
ALTER TABLE `#__joomlabuilder_templates`
ADD CONSTRAINT `fk_templates_modified_by`
FOREIGN KEY (`modified_by`) REFERENCES `#__users`(`id`) ON DELETE SET NULL;

-- Create a new table for template revisions
CREATE TABLE `#__joomlabuilder_revisions` (
    `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `template_id` INT(11) UNSIGNED NOT NULL,
    `revision_number` INT(5) UNSIGNED NOT NULL,
    `data` LONGTEXT NOT NULL,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `created_by` INT(11) UNSIGNED NOT NULL,
    FOREIGN KEY (`template_id`) REFERENCES `#__joomlabuilder_templates`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`created_by`) REFERENCES `#__users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert a new setting for enabling/disabling template versioning
INSERT INTO `#__joomlabuilder_settings` (`key`, `value`) 
SELECT 'enable_versioning', '1' FROM DUAL 
WHERE NOT EXISTS (SELECT `key` FROM `#__joomlabuilder_settings` WHERE `key` = 'enable_versioning');
 
