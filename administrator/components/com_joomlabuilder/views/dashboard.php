<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;

class JoomlaBuilderViewDashboard extends HtmlView
{
    protected $items;
    protected $pagination;
    protected $state;

    public function display($tpl = null)
    {
        $this->items = $this->get('Templates');
        $this->pagination = $this->get('Pagination');
        $this->state = $this->get('State');

        if (count($errors = $this->get('Errors'))) {
            Factory::getApplication()->enqueueMessage(implode("\n", $errors), 'error');
            return false;
        }

        $this->addToolbar();
        parent::display($tpl);
    }

    protected function addToolbar()
    {
        ToolbarHelper::title(Text::_('COM_JOOMLABUILDER_DASHBOARD_TITLE'), 'home');
        ToolbarHelper::addNew('template.add', Text::_('COM_JOOMLABUILDER_NEW_TEMPLATE'));
        ToolbarHelper::deleteList('', 'templates.delete', Text::_('COM_JOOMLABUILDER_DELETE'));
    }

    public function loadLayout()
    {
        $layout = new FileLayout('dashboard', JPATH_COMPONENT . '/layouts');
        return $layout->render(['items' => $this->items, 'pagination' => $this->pagination]);
    }
}
 
