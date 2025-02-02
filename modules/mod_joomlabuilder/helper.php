<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Database\DatabaseDriver;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Cache\Cache;

class ModJoomlaBuilderHelper
{
    /**
     * Retrieves a list of active JoomlaBuilder templates from the database.
     *
     * @return array List of templates.
     */
    public static function getTemplates()
    {
        try {
            $db = Factory::getDbo();
            $query = $db->getQuery(true)
                ->select('*')
                ->from($db->quoteName('#__joomlabuilder_templates'))
                ->where($db->quoteName('published') . ' = 1')
                ->order('created DESC');
            $db->setQuery($query);
            
            return $db->loadObjectList();
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage(Text::_('MOD_JOOMLABUILDER_ERROR_LOADING_TEMPLATES'), 'error');
            return [];
        }
    }

    /**
     * Fetches template details by ID.
     *
     * @param int $templateId The template ID.
     * @return object|null Template data or null if not found.
     */
    public static function getTemplateById($templateId)
    {
        try {
            $db = Factory::getDbo();
            $query = $db->getQuery(true)
                ->select('*')
                ->from($db->quoteName('#__joomlabuilder_templates'))
                ->where($db->quoteName('id') . ' = ' . (int) $templateId);
            $db->setQuery($query);
            
            return $db->loadObject();
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage(Text::_('MOD_JOOMLABUILDER_ERROR_FETCHING_TEMPLATE'), 'error');
            return null;
        }
    }

    /**
     * Checks if caching is enabled and returns the cache instance.
     *
     * @return Cache Joomla cache instance.
     */
    public static function getCacheInstance()
    {
        $cache = Factory::getCache('mod_joomlabuilder', 'output');
        return $cache;
    }
}
 
