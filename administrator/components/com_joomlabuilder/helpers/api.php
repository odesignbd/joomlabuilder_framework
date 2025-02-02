<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Response\JsonResponse;
use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\User\User;
use Joomla\Database\DatabaseDriver;

class JoomlaBuilderHelperAPI
{
    /**
     * Processes an API request and returns a JSON response.
     *
     * @param string $task The API task to perform.
     */
    public static function handleRequest($task)
    {
        try {
            $input = Factory::getApplication()->input;
            $user = Factory::getUser();
            
            if (!$user->authorise('core.manage', 'com_joomlabuilder')) {
                throw new Exception('Unauthorized access', 403);
            }

            switch ($task) {
                case 'getTemplates':
                    self::getTemplates();
                    break;
                case 'getSections':
                    self::getSections();
                    break;
                case 'saveTemplate':
                    self::saveTemplate();
                    break;
                case 'deleteTemplate':
                    self::deleteTemplate();
                    break;
                default:
                    throw new Exception('Invalid API request', 400);
            }
        } catch (Exception $e) {
            echo new JsonResponse(['success' => false, 'error' => $e->getMessage()], $e->getCode());
            Factory::getApplication()->close();
        }
    }

    /**
     * Fetches all Joomla Builder templates.
     */
    private static function getTemplates()
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__joomlabuilder_templates'));
        $db->setQuery($query);
        $templates = $db->loadObjectList();

        echo new JsonResponse(['success' => true, 'data' => $templates]);
        Factory::getApplication()->close();
    }

    /**
     * Fetches all sections for template building.
     */
    private static function getSections()
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__joomlabuilder_sections'));
        $db->setQuery($query);
        $sections = $db->loadObjectList();

        echo new JsonResponse(['success' => true, 'data' => $sections]);
        Factory::getApplication()->close();
    }

    /**
     * Saves a new Joomla Builder template.
     */
    private static function saveTemplate()
    {
        $input = Factory::getApplication()->input;
        $data = $input->get('data', '', 'RAW');
        
        if (!$data) {
            echo new JsonResponse(['success' => false, 'error' => 'Invalid template data'], 400);
            Factory::getApplication()->close();
        }

        $db = Factory::getDbo();
        $query = $db->getQuery(true)
            ->insert($db->quoteName('#__joomlabuilder_templates'))
            ->columns($db->quoteName(['name', 'data']))
            ->values($db->quote($data['name']) . ', ' . $db->quote(json_encode($data['content'])));
        $db->setQuery($query);
        $db->execute();

        echo new JsonResponse(['success' => true, 'message' => 'Template saved successfully']);
        Factory::getApplication()->close();
    }

    /**
     * Deletes a Joomla Builder template.
     */
    private static function deleteTemplate()
    {
        $input = Factory::getApplication()->input;
        $id = $input->getInt('id');
        
        if (!$id) {
            echo new JsonResponse(['success' => false, 'error' => 'Invalid template ID'], 400);
            Factory::getApplication()->close();
        }

        $db = Factory::getDbo();
        $query = $db->getQuery(true)
            ->delete($db->quoteName('#__joomlabuilder_templates'))
            ->where($db->quoteName('id') . ' = ' . (int) $id);
        $db->setQuery($query);
        $db->execute();

        echo new JsonResponse(['success' => true, 'message' => 'Template deleted successfully']);
        Factory::getApplication()->close();
    }
}
 
