<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\Database\DatabaseDriver;
use Joomla\CMS\Response\JsonResponse;
use Joomla\CMS\Language\Text;

class JoomlaBuilderHelperDatabase
{
    /**
     * Retrieves all records from a given database table.
     *
     * @param string $table The database table name.
     * @return array|false The result set or false on failure.
     */
    public static function getRecords($table)
    {
        try {
            $db = Factory::getDbo();
            $query = $db->getQuery(true)
                ->select('*')
                ->from($db->quoteName($table));
            $db->setQuery($query);
            return $db->loadObjectList();
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage($e->getMessage(), 'error');
            return false;
        }
    }

    /**
     * Inserts a new record into a database table.
     *
     * @param string $table The database table name.
     * @param array $data The associative array of column => value.
     * @return bool True on success, false on failure.
     */
    public static function insertRecord($table, $data)
    {
        try {
            $db = Factory::getDbo();
            $columns = array_keys($data);
            $values = array_map([$db, 'quote'], array_values($data));
            
            $query = $db->getQuery(true)
                ->insert($db->quoteName($table))
                ->columns($db->quoteName($columns))
                ->values(implode(',', $values));
            $db->setQuery($query);
            $db->execute();
            return true;
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage($e->getMessage(), 'error');
            return false;
        }
    }

    /**
     * Updates a record in a database table.
     *
     * @param string $table The database table name.
     * @param array $data The associative array of column => value.
     * @param array $conditions The associative array of column => value for WHERE clause.
     * @return bool True on success, false on failure.
     */
    public static function updateRecord($table, $data, $conditions)
    {
        try {
            $db = Factory::getDbo();
            $fields = [];
            foreach ($data as $column => $value) {
                $fields[] = $db->quoteName($column) . ' = ' . $db->quote($value);
            }
            
            $where = [];
            foreach ($conditions as $column => $value) {
                $where[] = $db->quoteName($column) . ' = ' . $db->quote($value);
            }
            
            $query = $db->getQuery(true)
                ->update($db->quoteName($table))
                ->set($fields)
                ->where($where);
            $db->setQuery($query);
            $db->execute();
            return true;
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage($e->getMessage(), 'error');
            return false;
        }
    }

    /**
     * Deletes records from a database table.
     *
     * @param string $table The database table name.
     * @param array $conditions The associative array of column => value for WHERE clause.
     * @return bool True on success, false on failure.
     */
    public static function deleteRecord($table, $conditions)
    {
        try {
            $db = Factory::getDbo();
            $where = [];
            foreach ($conditions as $column => $value) {
                $where[] = $db->quoteName($column) . ' = ' . $db->quote($value);
            }
            
            $query = $db->getQuery(true)
                ->delete($db->quoteName($table))
                ->where($where);
            $db->setQuery($query);
            $db->execute();
            return true;
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage($e->getMessage(), 'error');
            return false;
        }
    }
}
 
