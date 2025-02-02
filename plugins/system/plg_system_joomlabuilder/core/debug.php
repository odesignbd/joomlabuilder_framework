<?php
/**
 * JoomlaBuilder Debugging System
 * @package     JoomlaBuilder
 * @subpackage  Plugin Debug Management
 * @author      BS Digital Services & Ventures
 * @license     GNU General Public License
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Log\Log;

class JoomlaBuilderDebug
{
    /**
     * Enable debugging mode
     */
    public static function enableDebug()
    {
        $config = Factory::getConfig();
        $config->set('debug', 1);
        Log::add('JoomlaBuilder Debugging Enabled', Log::INFO, 'plg_system_joomlabuilder');
    }

    /**
     * Disable debugging mode
     */
    public static function disableDebug()
    {
        $config = Factory::getConfig();
        $config->set('debug', 0);
        Log::add('JoomlaBuilder Debugging Disabled', Log::INFO, 'plg_system_joomlabuilder');
    }

    /**
     * Log debug message
     * @param string $message Debug message
     * @param string $level Debug level (INFO, WARNING, ERROR)
     */
    public static function log($message, $level = 'INFO')
    {
        Log::add('[DEBUG] ' . $message, constant('JLog::' . strtoupper($level)), 'plg_system_joomlabuilder');
    }
}
