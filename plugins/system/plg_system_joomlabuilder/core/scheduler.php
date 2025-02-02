<?php
/**
 * JoomlaBuilder Task Scheduler
 * @package     JoomlaBuilder
 * @subpackage  Plugin Task Scheduling
 * @author      BS Digital Services & Ventures
 * @license     GNU General Public License
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Log\Log;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Date\Date;

class JoomlaBuilderScheduler
{
    /**
     * Schedule a task for execution
     * @param string $taskName Task name
     * @param callable $callback Function to execute
     * @param string $interval Interval for execution (e.g., 'daily', 'hourly')
     * @return void
     */
    public static function scheduleTask($taskName, callable $callback, $interval = 'daily')
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*')
            ->from($db->quoteName('#__joomlabuilder_tasks'))
            ->where($db->quoteName('task_name') . ' = ' . $db->quote($taskName));
        $db->setQuery($query);
        $task = $db->loadObject();

        $now = new Date();
        if (!$task || strtotime($task->last_run) + self::getIntervalSeconds($interval) < time()) {
            $callback();
            
            $query = $db->getQuery(true);
            if ($task) {
                $query->update($db->quoteName('#__joomlabuilder_tasks'))
                    ->set($db->quoteName('last_run') . ' = ' . $db->quote($now->toSql()))
                    ->where($db->quoteName('task_name') . ' = ' . $db->quote($taskName));
            } else {
                $query->insert($db->quoteName('#__joomlabuilder_tasks'))
                    ->columns($db->quoteName(['task_name', 'last_run']))
                    ->values($db->quote($taskName) . ', ' . $db->quote($now->toSql()));
            }
            $db->setQuery($query);
            $db->execute();
            Log::add('Task ' . $taskName . ' executed successfully.', Log::INFO, 'plg_system_joomlabuilder');
        }
    }

    /**
     * Convert interval string to seconds
     * @param string $interval Interval format (e.g., 'daily', 'hourly')
     * @return int Interval in seconds
     */
    private static function getIntervalSeconds($interval)
    {
        switch ($interval) {
            case 'hourly':
                return 3600;
            case 'daily':
                return 86400;
            case 'weekly':
                return 604800;
            default:
                return 86400;
        }
    }
}
