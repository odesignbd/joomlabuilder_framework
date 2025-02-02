<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Router\Router;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\User\UserHelper;
use Joomla\CMS\Dispatcher\Dispatcher;
use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\MVC\Controller\BaseController;

// Load Joomla language files
Text::script('COM_JOOMLABUILDER_LOADING');
Text::script('COM_JOOMLABUILDER_ERROR');

// Get an instance of the application
$app = Factory::getApplication();
$input = $app->input;

// Load component helper
$componentParams = ComponentHelper::getParams('com_joomlabuilder');

// Include dependencies
JLoader::registerPrefix('JoomlaBuilder', JPATH_COMPONENT);

// Determine the controller
$controllerName = $input->get('controller', 'default');
$controllerClass = 'JoomlaBuilderController' . ucfirst($controllerName);

// Ensure the controller file exists
if (!class_exists($controllerClass)) {
    throw new Exception(Text::_('JERROR_ALERTNOAUTHOR'), 404);
}

// Execute the controller task
$controller = new $controllerClass();
$controller->execute($input->get('task', 'display'));
$controller->redirect();
 
