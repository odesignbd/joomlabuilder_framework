<?php
/**
 * JoomlaBuilder Caching System
 * @package     JoomlaBuilder
 * @subpackage  Plugin Cache Management
 * @author      BS Digital Services & Ventures
 * @license     GNU General Public License
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Cache\CacheController;

class JoomlaBuilderCache
{
    /**
     * Retrieve cache instance
     * @return CacheController Cache object
     */
    public static function getCache()
    {
        return Factory::getCache('plg_system_joomlabuilder', 'output');
    }

    /**
     * Store data in cache
     * @param string $key Cache key
     * @param mixed  $data Data to store
     * @param int    $lifetime Cache lifetime in seconds (default: 3600)
     */
    public static function set($key, $data, $lifetime = 3600)
    {
        $cache = self::getCache();
        $cache->setCaching(true);
        $cache->store($data, $key, 'plg_system_joomlabuilder', $lifetime);
    }

    /**
     * Retrieve data from cache
     * @param string $key Cache key
     * @return mixed Cached data or false if not found
     */
    public static function get($key)
    {
        $cache = self::getCache();
        return $cache->get($key, 'plg_system_joomlabuilder');
    }

    /**
     * Clear cache
     * @param string $key Optional specific key to clear (default: clear all cache)
     */
    public static function clear($key = null)
    {
        $cache = self::getCache();
        if ($key) {
            $cache->remove($key, 'plg_system_joomlabuilder');
        } else {
            $cache->clean('plg_system_joomlabuilder');
        }
    }
}
