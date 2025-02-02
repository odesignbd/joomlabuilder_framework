<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Cache\Cache;
use Joomla\CMS\Document\Document;

class ModJoomlaBuilderHelper
{
    /**
     * Retrieves module parameters and processes the template output.
     *
     * @param object $params Module parameters.
     * @return array Processed module data.
     */
    public static function getModuleData($params)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__joomlabuilder_templates'))
            ->order('created DESC');
        $db->setQuery($query);
        
        return $db->loadObjectList();
    }
}

// Load module parameters
$layout = $params->get('layout', 'default');
$enableCaching = (bool) $params->get('enable_caching', 1);
$moduleClassSfx = htmlspecialchars($params->get('module_class_sfx', ''));

// Check caching
$cache = Factory::getCache('mod_joomlabuilder', 'output');
$cache->setCaching($enableCaching);

// Load template and display output
require JModuleHelper::getLayoutPath('mod_joomlabuilder', $layout);
 
