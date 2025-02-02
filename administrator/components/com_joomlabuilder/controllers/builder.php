 
<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Factory;
use Joomla\CMS\Response\JsonResponse;
use Joomla\CMS\Language\Text;
use Joomla\Database\DatabaseQuery;

class JoomlaBuilderControllerBuilder extends BaseController
{
    protected $default_view = 'builder';

    public function display($cachable = false, $urlparams = [])
    {
        $view = $this->input->getCmd('view', 'builder');
        $this->input->set('view', $view);
        parent::display($cachable, $urlparams);
    }

    public function getSections()
    {
        try {
            $db = Factory::getDbo();
            $query = $db->getQuery(true)
                ->select('*')
                ->from($db->quoteName('#__joomlabuilder_sections'));
            $db->setQuery($query);
            $sections = $db->loadObjectList();

            if (!$sections) {
                throw new Exception(Text::_('COM_JOOMLABUILDER_NO_SECTIONS_FOUND'));
            }

            echo new JsonResponse(['success' => true, 'data' => $sections]);
        } catch (Exception $e) {
            echo new JsonResponse(['success' => false, 'error' => $e->getMessage()], 500);
        }
        Factory::getApplication()->close();
    }

    public function addSection()
    {
        try {
            $input = Factory::getApplication()->input;
            $data = $input->get('data', '', 'RAW');
            if (!$data) {
                throw new Exception(Text::_('COM_JOOMLABUILDER_INVALID_SECTION_DATA'));
            }

            $db = Factory::getDbo();
            $query = $db->getQuery(true)
                ->insert($db->quoteName('#__joomlabuilder_sections'))
                ->columns($db->quoteName(['name', 'content']))
                ->values($db->quote($data['name']) . ', ' . $db->quote(json_encode($data['content'])));
            $db->setQuery($query);
            $db->execute();

            echo new JsonResponse(['success' => true, 'message' => Text::_('COM_JOOMLABUILDER_SECTION_ADDED')]);
        } catch (Exception $e) {
            echo new JsonResponse(['success' => false, 'error' => $e->getMessage()], 500);
        }
        Factory::getApplication()->close();
    }

    public function deleteSection()
    {
        try {
            $input = Factory::getApplication()->input;
            $id = $input->getInt('id');
            if (!$id) {
                throw new Exception(Text::_('COM_JOOMLABUILDER_INVALID_SECTION_ID'));
            }
            
            $db = Factory::getDbo();
            $query = $db->getQuery(true)
                ->delete($db->quoteName('#__joomlabuilder_sections'))
                ->where($db->quoteName('id') . ' = ' . (int) $id);
            $db->setQuery($query);
            $db->execute();

            echo new JsonResponse(['success' => true, 'message' => Text::_('COM_JOOMLABUILDER_SECTION_DELETED')]);
        } catch (Exception $e) {
            echo new JsonResponse(['success' => false, 'error' => $e->getMessage()], 500);
        }
        Factory::getApplication()->close();
    }
}
