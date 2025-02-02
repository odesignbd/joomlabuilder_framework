<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Response\JsonResponse;
use Joomla\Database\DatabaseDriver;

class JoomlaBuilderHelperBackup
{
    private static $backupPath = JPATH_ADMINISTRATOR . '/backups/joomlabuilder/';

    /**
     * Creates a full database backup and saves it as an SQL file.
     *
     * @return void
     */
    public static function createBackup()
    {
        try {
            $db = Factory::getDbo();
            $tables = $db->setQuery('SHOW TABLES')->loadColumn();
            
            if (!Folder::exists(self::$backupPath)) {
                Folder::create(self::$backupPath);
            }
            
            $backupFile = self::$backupPath . 'backup_' . date('Y-m-d_H-i-s') . '.sql';
            
            $backupData = "-- Joomla Builder Backup\n-- Created: " . date('Y-m-d H:i:s') . "\n\n";
            
            foreach ($tables as $table) {
                $createTable = $db->setQuery('SHOW CREATE TABLE ' . $db->quoteName($table))->loadRow();
                $backupData .= "DROP TABLE IF EXISTS `$table`;\n" . $createTable[1] . ";\n\n";
                
                $rows = $db->setQuery('SELECT * FROM ' . $db->quoteName($table))->loadAssocList();
                foreach ($rows as $row) {
                    $values = array_map([$db, 'quote'], array_values($row));
                    $backupData .= "INSERT INTO `$table` VALUES(" . implode(", ", $values) . ");\n";
                }
                $backupData .= "\n";
            }
            
            File::write($backupFile, $backupData);
            echo new JsonResponse(['success' => true, 'message' => 'Backup created successfully', 'file' => $backupFile]);
        } catch (Exception $e) {
            echo new JsonResponse(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Restores a database backup from an SQL file.
     *
     * @param string $backupFile The backup file path.
     * @return void
     */
    public static function restoreBackup($backupFile)
    {
        try {
            if (!File::exists($backupFile)) {
                throw new Exception('Backup file does not exist');
            }
            
            $db = Factory::getDbo();
            $backupContent = File::read($backupFile);
            $queries = array_filter(array_map('trim', explode(";\n", $backupContent)));
            
            foreach ($queries as $query) {
                $db->setQuery($query)->execute();
            }
            
            echo new JsonResponse(['success' => true, 'message' => 'Backup restored successfully']);
        } catch (Exception $e) {
            echo new JsonResponse(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Lists all available backup files.
     *
     * @return void
     */
    public static function listBackups()
    {
        try {
            if (!Folder::exists(self::$backupPath)) {
                Folder::create(self::$backupPath);
            }
            
            $files = Folder::files(self::$backupPath, '\\.sql$', false, true);
            echo new JsonResponse(['success' => true, 'backups' => $files]);
        } catch (Exception $e) {
            echo new JsonResponse(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
 
