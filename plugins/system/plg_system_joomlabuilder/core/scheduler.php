<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Log\Log;
use Joomla\CMS\Date\Date;
use Joomla\CMS\Language\Text;

class JoomlaBuilderScheduler
{
    /**
     * Executes scheduled tasks for JoomlaBuilder.
     *
     * @return void
     */
    public static function runScheduledTasks()
    {
        try {
            // Check last execution time
            $lastRun = self::getLastRunTime();
            $currentTime = new Date();
            
            // Run scheduled tasks only if an interval has passed
            if (self::shouldExecute($lastRun, $currentTime)) {
                self::performTasks();
                self::updateLastRunTime($currentTime);
            }
        } catch (Exception $e) {
            Log::add(Text::_('PLG_SYSTEM_JOOMLABUILDER_SCHEDULER_ERROR') . ': ' . $e->getMessage(), Log::ERROR, 'plg_system_joomlabuilder');
        }
    }

    /**
     * Determines if scheduled tasks should execute.
     *
     * @param Date|null $lastRun Last execution time.
     * @param Date $currentTime Current time.
     * @return bool True if execution should proceed, false otherwise.
     */
    private static function shouldExecute($lastRun, $currentTime)
    {
        if (!$lastRun) {
            return true;
        }
        
        // Define execution interval (e.g., every 24 hours)
        $intervalHours = 24;
        $intervalSeconds = $intervalHours * 3600;
        
        return ($currentTime->toUnix() - $lastRun->toUnix()) >= $intervalSeconds;
    }

    /**
     * Performs scheduled JoomlaBuilder tasks.
     *
     * @return void
     */
    private static function performTasks()
    {
        // Example task: Clean outdated cache
        JoomlaBuilderCache::clearAllCache();
        
        // Example task: Log execution
        Log::add(Text::_('PLG_SYSTEM_JOOMLABUILDER_SCHEDULER_EXECUTED'), Log::INFO, 'plg_system_joomlabuilder');
    }

    /**
     * Retrieves the last run time of scheduled tasks.
     *
     * @return Date|null Last execution time or null if not set.
     */
    private static function getLastRunTime()
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true)
            ->select($db->quoteName('value'))
            ->from($db->quoteName('#__joomlabuilder_settings'))
            ->where($db->quoteName('key') . ' = ' . $db->quote('scheduler_last_run'));
        $db->setQuery($query);
        
        $result = $db->loadResult();
        return $result ? new Date($result) : null;
    }

    /**
     * Updates the last run time of scheduled tasks.
     *
     * @param Date $time The current time.
     * @return void
     */
    private static function updateLastRunTime($time)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true)
            ->update($db->quoteName('#__joomlabuilder_settings'))
            ->set($db->quoteName('value') . ' = ' . $db->quote($time->toSql()))
            ->where($db->quoteName('key') . ' = ' . $db->quote('scheduler_last_run'));
        $db->setQuery($query);
        $db->execute();
    }
}
 
