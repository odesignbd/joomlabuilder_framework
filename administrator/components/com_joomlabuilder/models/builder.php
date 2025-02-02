 
<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Factory;
use Joomla\CMS\Table\Table;
use Joomla\Database\DatabaseQuery;
use Joomla\Utilities\ArrayHelper;

class JoomlaBuilderModelBuilder extends ListModel
{
    protected $context = 'com_joomlabuilder.builder';

    public function __construct($config = array())
    {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = [
                'id', 'name', 'created', 'modified'
            ];
        }
        parent::__construct($config);
    }

    public function getSections()
    {
        try {
            $db = Factory::getDbo();
            $query = $db->getQuery(true)
                ->select('*')
                ->from($db->quoteName('#__joomlabuilder_sections'))
                ->order('created DESC');
            $db->setQuery($query);
            $sections = $db->loadObjectList();

            return $sections;
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage($e->getMessage(), 'error');
            return [];
        }
    }

    public function deleteSection($id)
    {
        try {
            $db = Factory::getDbo();
            $query = $db->getQuery(true)
                ->delete($db->quoteName('#__joomlabuilder_sections'))
                ->where($db->quoteName('id') . ' = ' . (int) $id);
            $db->setQuery($query);
            $db->execute();
            return true;
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage($e->getMessage(), 'error');
            return false;
        }
    }

    public function saveSection($data)
    {
        try {
            $db = Factory::getDbo();
            $query = $db->getQuery(true)
                ->insert($db->quoteName('#__joomlabuilder_sections'))
                ->columns($db->quoteName(['name', 'content']))
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
