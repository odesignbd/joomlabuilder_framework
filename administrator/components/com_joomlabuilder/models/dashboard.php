<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Factory;
use Joomla\CMS\Table\Table;
use Joomla\Database\DatabaseQuery;
use Joomla\Utilities\ArrayHelper;

class JoomlaBuilderModelDashboard extends ListModel
{
    protected $context = 'com_joomlabuilder.dashboard';

    public function __construct($config = array())
    {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = [
                'id', 'name', 'created', 'modified'
            ];
        }
        parent::__construct($config);
    }

    public function getTemplates()
    {
        try {
            $db = Factory::getDbo();
            $query = $db->getQuery(true)
                ->select('*')
                ->from($db->quoteName('#__joomlabuilder_templates'))
                ->order('created DESC');
            $db->setQuery($query);
            $templates = $db->loadObjectList();

            return $templates;
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage($e->getMessage(), 'error');
            return [];
        }
    }

    public function deleteTemplate($id)
    {
        try {
            $db = Factory::getDbo();
            $query = $db->getQuery(true)
                ->delete($db->quoteName('#__joomlabuilder_templates'))
                ->where($db->quoteName('id') . ' = ' . (int) $id);
            $db->setQuery($query);
            $db->execute();
            return true;
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage($e->getMessage(), 'error');
            return false;
        }
    }

    public function saveTemplate($data)
    {
        try {
            $db = Factory::getDbo();
            $query = $db->getQuery(true)
                ->insert($db->quoteName('#__joomlabuilder_templates'))
                ->columns($db->quoteName(['name', 'data']))
                ->values($db->quote($data['name']) . ', ' . $db->quote(json_encode($data['content'])));
            $db->setQuery($query);
            $db->execute();
            return $db->insertid();
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage($e->getMessage(), 'error');
            return false;
        }
    }
}
 
