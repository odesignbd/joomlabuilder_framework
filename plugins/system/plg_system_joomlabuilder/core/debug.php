 
<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Log\Log;
use Joomla\CMS\Language\Text;

class JoomlaBuilderDebug
{
    /**
     * Logs debug messages to Joomla's log system.
     *
     * @param string $message The debug message.
     * @param string $level The log level (debug, warning, error).
     */
    public static function logMessage($message, $level = 'debug')
    {
        try {
            Log::add($message, constant('JLog::' . strtoupper($level)), 'plg_system_joomlabuilder');
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage(Text::_('PLG_SYSTEM_JOOMLABUILDER_DEBUG_ERROR') . ': ' . $e->getMessage(), 'error');
        }
    }

    /**
     * Logs an error message.
     *
     * @param string $error The error message.
     */
    public static function logError($error)
    {
        self::logMessage($error, 'error');
    }

    /**
     * Retrieves the last N log entries.
     *
     * @param int $limit The number of log entries to retrieve.
     * @return array List of log entries.
     */
    public static function getLogEntries($limit = 50)
    {
        try {
            $logPath = JPATH_LOGS . '/plg_system_joomlabuilder.php';
            if (!file_exists($logPath)) {
                return [];
            }
            
            $lines = array_reverse(file($logPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
            return array_slice($lines, 0, $limit);
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage(Text::_('PLG_SYSTEM_JOOMLABUILDER_DEBUG_READ_ERROR') . ': ' . $e->getMessage(), 'error');
            return [];
        }
    }
}
