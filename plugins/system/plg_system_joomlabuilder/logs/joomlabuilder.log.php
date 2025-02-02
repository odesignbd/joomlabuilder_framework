<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Log\Log;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

class JoomlaBuilderLogger
{
    /**
     * Logs JoomlaBuilder events and errors.
     *
     * @param string $message The log message.
     * @param string $level The log level (debug, info, warning, error).
     */
    public static function log($message, $level = 'info')
    {
        try {
            Log::add($message, constant('JLog::' . strtoupper($level)), 'plg_system_joomlabuilder');
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage(Text::_('PLG_SYSTEM_JOOMLABUILDER_LOG_ERROR') . ': ' . $e->getMessage(), 'error');
        }
    }

    /**
     * Retrieves the last N log entries.
     *
     * @param int $limit Number of log entries to retrieve.
     * @return array List of log messages.
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
            Factory::getApplication()->enqueueMessage(Text::_('PLG_SYSTEM_JOOMLABUILDER_LOG_READ_ERROR') . ': ' . $e->getMessage(), 'error');
            return [];
        }
    }
}
 
