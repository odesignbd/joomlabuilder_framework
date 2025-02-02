<?php
/**
 * JoomlaBuilder Logging System
 * @package     JoomlaBuilder
 * @subpackage  Plugin Logging
 * @author      BS Digital Services & Ventures
 * @license     GNU General Public License
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Log\Log;
use Joomla\CMS\Factory;

class JoomlaBuilderLogger
{
    /**
     * Initialize the logging system
     */
    public static function init()
    {
        Log::addLogger(
            [
                'text_file' => 'joomlabuilder.log.php',
                'text_entry_format' => '{DATETIME} {PRIORITY} {CATEGORY} {MESSAGE}',
                'text_file_path' => JPATH_ROOT . '/logs',
            ],
            Log::ALL,
            ['plg_system_joomlabuilder']
        );
    }

    /**
     * Write log entry
     * @param string $message Log message
     * @param string $level Log level (INFO, WARNING, ERROR)
     */
    public static function write($message, $level = 'INFO')
    {
        self::init();
        Log::add($message, constant('JLog::' . strtoupper($level)), 'plg_system_joomlabuilder');
    }
}
