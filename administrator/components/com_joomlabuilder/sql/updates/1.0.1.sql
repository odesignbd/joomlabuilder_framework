-- JoomlaBuilder Schema Update to v1.0.1

-- Add a new column for template version tracking
ALTER TABLE `#__joomlabuilder_templates`
ADD COLUMN `version` VARCHAR(10) NOT NULL DEFAULT '1.0.0';

-- Add an index to optimize template name searches
ALTER TABLE `#__joomlabuilder_templates`
ADD INDEX (`name`);

-- Insert new default settings if they do not exist
INSERT INTO `#__joomlabuilder_settings` (`key`, `value`) 
SELECT 'auto_backup', '1' FROM DUAL 
WHERE NOT EXISTS (SELECT `key` FROM `#__joomlabuilder_settings` WHERE `key` = 'auto_backup');
 
