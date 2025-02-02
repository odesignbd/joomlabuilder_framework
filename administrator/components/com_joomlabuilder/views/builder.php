<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;

class JoomlaBuilderViewBuilder extends HtmlView
{
    protected $sections;
    protected $state;

    public function display($tpl = null)
    {
        $this->sections = $this->get('Sections');
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
        ToolbarHelper::title(Text::_('COM_JOOMLABUILDER_BUILDER_TITLE'), 'pencil');
        ToolbarHelper::addNew('section.add', Text::_('COM_JOOMLABUILDER_NEW_SECTION'));
        ToolbarHelper::deleteList('', 'sections.delete', Text::_('COM_JOOMLABUILDER_DELETE_SECTION'));
    }

    public function loadLayout()
    {
        $layout = new FileLayout('builder', JPATH_COMPONENT . '/layouts');
        return $layout->render(['sections' => $this->sections]);
    }
}
 
