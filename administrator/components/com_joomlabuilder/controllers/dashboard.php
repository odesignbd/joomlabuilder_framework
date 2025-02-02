<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Factory;
use Joomla\CMS\Response\JsonResponse;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\Database\DatabaseQuery;
use Joomla\Utilities\ArrayHelper;

class JoomlaBuilderControllerDashboard extends BaseController
{
    protected $default_view = 'dashboard';

    public function display($cachable = false, $urlparams = [])
    {
        $view = $this->input->getCmd('view', 'dashboard');
        $this->input->set('view', $view);
        parent::display($cachable, $urlparams);
    }

    public function getTemplates()
    {
        try {
            $db = Factory::getDbo();
            $query = $db->getQuery(true)
                ->select('*')
                ->from($db->quoteName('#__joomlabuilder_templates'));
            $db->setQuery($query);
            $templates = $db->loadObjectList();

            if (!$templates) {
                throw new Exception(Text::_('COM_JOOMLABUILDER_NO_TEMPLATES_FOUND'));
            }

            echo new JsonResponse(['success' => true, 'data' => $templates]);
        } catch (Exception $e) {
            echo new JsonResponse(['success' => false, 'error' => $e->getMessage()], 500);
        }
        Factory::getApplication()->close();
    }

    public function deleteTemplate()
    {
        try {
            $input = Factory::getApplication()->input;
            $id = $input->getInt('id');
            if (!$id) {
                throw new Exception(Text::_('COM_JOOMLABUILDER_INVALID_TEMPLATE_ID'));
            }
            
            $db = Factory::getDbo();
            $query = $db->getQuery(true)
                ->delete($db->quoteName('#__joomlabuilder_templates'))
                ->where($db->quoteName('id') . ' = ' . (int) $id);
            $db->setQuery($query);
            $db->execute();

            echo new JsonResponse(['success' => true, 'message' => Text::_('COM_JOOMLABUILDER_TEMPLATE_DELETED')]);
        } catch (Exception $e) {
            echo new JsonResponse(['success' => false, 'error' => $e->getMessage()], 500);
        }
        Factory::getApplication()->close();
    }

    public function createTemplate()
    {
        try {
            $input = Factory::getApplication()->input;
            $data = $input->get('data', '', 'RAW');
            if (!$data) {
                throw new Exception(Text::_('COM_JOOMLABUILDER_INVALID_TEMPLATE_DATA'));
            }
            
            $db = Factory::getDbo();
            $query = $db->getQuery(true)
                ->insert($db->quoteName('#__joomlabuilder_templates'))
                ->columns($db->quoteName(['name', 'data']))
                ->values($db->quote($data['name']) . ', ' . $db->quote(json_encode($data['content'])));
            $db->setQuery($query);
            $db->execute();

            echo new JsonResponse(['success' => true, 'message' => Text::_('COM_JOOMLABUILDER_TEMPLATE_CREATED')]);
        } catch (Exception $e) {
            echo new JsonResponse(['success' => false, 'error' => $e->getMessage()], 500);
        }
        Factory::getApplication()->close();
    }
}
 
