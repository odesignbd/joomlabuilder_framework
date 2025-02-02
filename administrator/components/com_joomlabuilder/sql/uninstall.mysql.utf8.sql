-- JoomlaBuilder Uninstallation SQL Script

-- Drop Tables if they exist
DROP TABLE IF EXISTS `#__joomlabuilder_templates`;
DROP TABLE IF EXISTS `#__joomlabuilder_sections`;
DROP TABLE IF EXISTS `#__joomlabuilder_settings`;

-- Remove Component Entry from Extensions Table
DELETE FROM `#__extensions` WHERE `element` = 'com_joomlabuilder' AND `type` = 'component';

-- Remove Component Permissions
DELETE FROM `#__assets` WHERE `name` = 'com_joomlabuilder';

-- Remove Menu Entries Related to JoomlaBuilder
DELETE FROM `#__menu` WHERE `link` LIKE '%option=com_joomlabuilder%';
