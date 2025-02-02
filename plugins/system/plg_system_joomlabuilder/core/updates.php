<?php
/**
 * JoomlaBuilder Auto Update System
 * @package     JoomlaBuilder
 * @subpackage  Plugin Update Management
 * @author      BS Digital Services & Ventures
 * @license     GNU General Public License
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Http\HttpFactory;
use Joomla\CMS\Log\Log;
use Joomla\CMS\Filesystem\File;

class JoomlaBuilderUpdater
{
    /**
     * Check for updates
     * @return array|false Update details if available, false if no update
     */
    public static function checkForUpdates()
    {
        $http = HttpFactory::getHttp();
        $updateUrl = 'https://update.joomlabuilder.com/latest.json';
        
        try {
            $response = $http->get($updateUrl);
            $data = json_decode($response->body, true);
            
            if (!isset($data['version'])) {
                return false;
            }
            
            $currentVersion = Factory::getApplication()->get('joomlabuilder_version');
            
            if (version_compare($data['version'], $currentVersion, '>')) {
                return $data;
            }
        } catch (Exception $e) {
            Log::add('Update check failed: ' . $e->getMessage(), Log::ERROR, 'plg_system_joomlabuilder');
        }
        
        return false;
    }

    /**
     * Download and install an update
     * @param string $downloadUrl URL to the update package
     * @return bool True on success, false on failure
     */
    public static function installUpdate($downloadUrl)
    {
        $http = HttpFactory::getHttp();
        $tmpPath = JPATH_SITE . '/tmp/joomlabuilder_update.zip';
        
        try {
            $response = $http->get($downloadUrl);
            File::write($tmpPath, $response->body);
            
            // Extract and replace files (simplified example)
            $zip = new ZipArchive;
            if ($zip->open($tmpPath) === true) {
                $zip->extractTo(JPATH_SITE);
                $zip->close();
                File::delete($tmpPath);
                Log::add('Update installed successfully', Log::INFO, 'plg_system_joomlabuilder');
                return true;
            }
        } catch (Exception $e) {
            Log::add('Update installation failed: ' . $e->getMessage(), Log::ERROR, 'plg_system_joomlabuilder');
        }
        
        return false;
    }
}
