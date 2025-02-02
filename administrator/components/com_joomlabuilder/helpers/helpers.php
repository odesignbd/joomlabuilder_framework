<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\User\User;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Filesystem\Folder;
use Joomla\Registry\Registry;

class JoomlaBuilderHelper
{
    /**
     * Gets the current user object.
     *
     * @return User The Joomla user object.
     */
    public static function getCurrentUser()
    {
        return Factory::getUser();
    }

    /**
     * Checks if a user has a specific permission.
     *
     * @param string $action The action to check.
     * @param int|null $userId The user ID (default is the current user).
     * @return bool True if the user has permission, false otherwise.
     */
    public static function hasPermission($action, $userId = null)
    {
        $user = Factory::getUser($userId);
        return $user->authorise($action, 'com_joomlabuilder');
    }

    /**
     * Loads a language string.
     *
     * @param string $key The language key.
     * @return string The translated string.
     */
    public static function translate($key)
    {
        return Text::_($key);
    }

    /**
     * Logs a message to Joomla’s log system.
     *
     * @param string $message The log message.
     * @param string $category The log category.
     */
    public static function log($message, $category = 'joomlabuilder')
    {
        Factory::getApplication()->enqueueMessage($message, 'message');
    }

    /**
     * Gets a configuration parameter from Joomla.
     *
     * @param string $param The configuration parameter.
     * @return mixed The parameter value.
     */
    public static function getConfig($param)
    {
        return Factory::getConfig()->get($param);
    }

    /**
     * Reads a file’s contents.
     *
     * @param string $filePath The file path.
     * @return string|false The file contents or false if an error occurs.
     */
    public static function readFile($filePath)
    {
        return File::exists($filePath) ? File::read($filePath) : false;
    }

    /**
     * Writes data to a file.
     *
     * @param string $filePath The file path.
     * @param string $data The data to write.
     * @return bool True on success, false on failure.
     */
    public static function writeFile($filePath, $data)
    {
        return File::write($filePath, $data);
    }

    /**
     * Creates a directory if it does not exist.
     *
     * @param string $folderPath The directory path.
     * @return bool True on success, false on failure.
     */
    public static function createFolder($folderPath)
    {
        return Folder::exists($folderPath) ? true : Folder::create($folderPath);
    }

    /**
     * Converts an array to a JSON response and outputs it.
     *
     * @param array $data The data to convert.
     */
    public static function jsonResponse($data)
    {
        echo new JsonResponse($data);
        Factory::getApplication()->close();
    }
}
 
