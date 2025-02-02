<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Cache\CacheControllerFactory;
use Joomla\CMS\Cache\Cache;
use Joomla\CMS\Language\Text;

class JoomlaBuilderCache
{
    /**
     * Retrieves the cache instance for JoomlaBuilder.
     *
     * @return Cache The cache instance.
     */
    public static function getCache()
    {
        return Factory::getCache('plg_system_joomlabuilder', 'output');
    }

    /**
     * Stores data in the cache.
     *
     * @param string $key The cache key.
     * @param mixed $data The data to store.
     * @param int $lifetime The cache lifetime in seconds.
     * @return bool True on success, false on failure.
     */
    public static function setCache($key, $data, $lifetime = 3600)
    {
        try {
            $cache = self::getCache();
            return $cache->store($data, $key, '', $lifetime);
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage(Text::_('PLG_SYSTEM_JOOMLABUILDER_CACHE_ERROR') . ': ' . $e->getMessage(), 'error');
            return false;
        }
    }

    /**
     * Retrieves data from the cache.
     *
     * @param string $key The cache key.
     * @return mixed The cached data or false if not found.
     */
    public static function getCacheData($key)
    {
        try {
            $cache = self::getCache();
            return $cache->get($key);
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage(Text::_('PLG_SYSTEM_JOOMLABUILDER_CACHE_ERROR_RETRIEVE') . ': ' . $e->getMessage(), 'error');
            return false;
        }
    }

    /**
     * Clears a specific cache key.
     *
     * @param string $key The cache key to clear.
     * @return bool True on success, false on failure.
     */
    public static function clearCacheKey($key)
    {
        try {
            $cache = self::getCache();
            return $cache->remove($key);
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage(Text::_('PLG_SYSTEM_JOOMLABUILDER_CACHE_ERROR_CLEAR') . ': ' . $e->getMessage(), 'error');
            return false;
        }
    }

    /**
     * Clears all JoomlaBuilder cache.
     *
     * @return bool True on success, false on failure.
     */
    public static function clearAllCache()
    {
        try {
            $cache = self::getCache();
            return $cache->clean();
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage(Text::_('PLG_SYSTEM_JOOMLABUILDER_CACHE_ERROR_CLEAR_ALL') . ': ' . $e->getMessage(), 'error');
            return false;
        }
    }
}
 
