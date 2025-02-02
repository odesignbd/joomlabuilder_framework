<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\User\User;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Log\Log;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Filesystem\Folder;

class JoomlaBuilderHelper
{
    /**
     * Retrieves the current logged-in user details.
     *
     * @return User|null Joomla user object or null if no user is logged in.
     */
    public static function getCurrentUser()
    {
        return Factory::getUser();
    }

    /**
     * Generates a secure token for CSRF protection.
     *
     * @return string Secure token.
     */
    public static function getCsrfToken()
    {
        return Factory::getSession()->getFormToken();
    }

    /**
     * Writes log entries for JoomlaBuilder.
     *
     * @param string $message The log message.
     * @param string $level The log level (debug, info, warning, error).
     */
    public static function logEvent($message, $level = 'info')
    {
        Log::add($message, constant('JLog::' . strtoupper($level)), 'plg_system_joomlabuilder');
    }

    /**
     * Deletes a directory and its contents.
     *
     * @param string $path Path to the directory.
     * @return bool True on success, false on failure.
     */
    public static function deleteDirectory($path)
    {
        if (Folder::exists($path)) {
            return Folder::delete($path);
        }
        return false;
    }

    /**
     * Retrieves the site base URL.
     *
     * @return string Base URL.
     */
    public static function getBaseUrl()
    {
        return Uri::base();
    }
}
 
