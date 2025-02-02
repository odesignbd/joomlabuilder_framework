<?php
/**
 * JoomlaBuilder Helper Functions
 * @package     JoomlaBuilder
 * @subpackage  Plugin Helpers
 * @author      BS Digital Services & Ventures
 * @license     GNU General Public License
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Log\Log;
use Joomla\Registry\Registry;

class JoomlaBuilderHelper
{
    /**
     * Get plugin parameters
     * @return Registry Plugin parameters
     */
    public static function getParams()
    {
        $plugin = Factory::getApplication()->getPlugin('system', 'joomlabuilder');
        return new Registry($plugin->params);
    }

    /**
     * Write log entry
     * @param string $message Log message
     * @param string $level Log level (INFO, WARNING, ERROR)
     */
    public static function log($message, $level = 'INFO')
    {
        Log::add($message, constant('JLog::' . strtoupper($level)), 'plg_system_joomlabuilder');
    }

    /**
     * Fetch Joomla user details
     * @param int $userId Joomla user ID
     * @return object User data
     */
    public static function getUser($userId)
    {
        return Factory::getUser($userId);
    }

    /**
     * Generate a secure token
     * @return string Secure CSRF token
     */
    public static function generateToken()
    {
        return Factory::getSession()->getFormToken();
    }

    /**
     * Sanitize input data
     * @param mixed $data Input data
     * @return mixed Sanitized data
     */
    public static function sanitize($data)
    {
        if (is_array($data)) {
            return array_map('htmlspecialchars', $data);
        }
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
}
