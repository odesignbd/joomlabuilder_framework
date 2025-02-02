<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\Registry\Registry;

class JoomlaBuilderParams
{
    /**
     * Retrieves plugin parameters.
     *
     * @return Registry Plugin parameters as a Joomla Registry object.
     */
    public static function getParams()
    {
        $plugin = Factory::getApplication()->getPlugin('system', 'joomlabuilder');
        return new Registry($plugin->params);
    }

    /**
     * Gets a specific parameter value.
     *
     * @param string $key The parameter key.
     * @param mixed $default The default value if the key is not set.
     * @return mixed The parameter value.
     */
    public static function getParam($key, $default = null)
    {
        $params = self::getParams();
        return $params->get($key, $default);
    }

    /**
     * Checks if debugging mode is enabled.
     *
     * @return bool True if debug mode is enabled, false otherwise.
     */
    public static function isDebugMode()
    {
        return self::getParam('debug_mode', false);
    }

    /**
     * Retrieves auto-update setting.
     *
     * @return bool True if auto-updates are enabled, false otherwise.
     */
    public static function isAutoUpdateEnabled()
    {
        return self::getParam('enable_auto_update', true);
    }

    /**
     * Retrieves the log level setting.
     *
     * @return string Log level (debug, info, warning, error).
     */
    public static function getLogLevel()
    {
        return self::getParam('log_level', 'info');
    }

    /**
     * Checks if security check is enabled.
     *
     * @return bool True if security check is enabled, false otherwise.
     */
    public static function isSecurityCheckEnabled()
    {
        return self::getParam('security_check', true);
    }
}
