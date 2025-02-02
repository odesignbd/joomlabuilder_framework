<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Http\HttpFactory;
use Joomla\CMS\Log\Log;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Filesystem\Folder;

class JoomlaBuilderUpdate
{
    /**
     * Checks for available updates.
     *
     * @return void
     */
    public static function checkForUpdates()
    {
        try {
            $updateUrl = 'https://updates.joomlabuilder.com/latest.json';
            $http = HttpFactory::getHttp();
            $response = $http->get($updateUrl);
            $updateData = json_decode($response->body, true);

            if (!empty($updateData['version']) && self::isNewVersionAvailable($updateData['version'])) {
                Factory::getApplication()->enqueueMessage(Text::sprintf('PLG_SYSTEM_JOOMLABUILDER_NEW_UPDATE_AVAILABLE', $updateData['version']), 'notice');
            }
        } catch (Exception $e) {
            Log::add(Text::_('PLG_SYSTEM_JOOMLABUILDER_UPDATE_CHECK_ERROR') . ': ' . $e->getMessage(), Log::ERROR, 'plg_system_joomlabuilder');
        }
    }

    /**
     * Determines if a new version is available.
     *
     * @param string $newVersion The latest available version.
     * @return bool True if an update is available, false otherwise.
     */
    private static function isNewVersionAvailable($newVersion)
    {
        $currentVersion = self::getCurrentVersion();
        return version_compare($currentVersion, $newVersion, '<');
    }

    /**
     * Gets the current installed version of JoomlaBuilder.
     *
     * @return string The installed version.
     */
    private static function getCurrentVersion()
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true)
            ->select($db->quoteName('value'))
            ->from($db->quoteName('#__joomlabuilder_settings'))
            ->where($db->quoteName('key') . ' = ' . $db->quote('joomlabuilder_version'));
        $db->setQuery($query);
        return $db->loadResult() ?: '1.0.0';
    }

    /**
     * Downloads and installs the latest update.
     *
     * @return bool True on success, false on failure.
     */
    public static function downloadAndInstallUpdate()
    {
        try {
            $updateUrl = 'https://updates.joomlabuilder.com/latest.zip';
            $tempFile = JPATH_SITE . '/tmp/joomlabuilder_update.zip';
            $installPath = JPATH_SITE . '/tmp/joomlabuilder_update/';
            
            // Download the update package
            $http = HttpFactory::getHttp();
            $response = $http->get($updateUrl);
            File::write($tempFile, $response->body);
            
            // Extract the update package
            Folder::create($installPath);
            JArchive::extract($tempFile, $installPath);
            
            // Perform update installation (manual processing required)
            self::processUpdateInstallation($installPath);
            
            return true;
        } catch (Exception $e) {
            Log::add(Text::_('PLG_SYSTEM_JOOMLABUILDER_UPDATE_INSTALL_ERROR') . ': ' . $e->getMessage(), Log::ERROR, 'plg_system_joomlabuilder');
            return false;
        }
    }

    /**
     * Processes the update installation.
     *
     * @param string $installPath The extracted update folder.
     * @return void
     */
    private static function processUpdateInstallation($installPath)
    {
        // Move new files to the Joomla system
        $destination = JPATH_SITE . '/plugins/system/joomlabuilder/';
        Folder::move($installPath, $destination);
        
        // Log successful update
        Log::add(Text::_('PLG_SYSTEM_JOOMLABUILDER_UPDATE_SUCCESS'), Log::INFO, 'plg_system_joomlabuilder');
    }
}
 
