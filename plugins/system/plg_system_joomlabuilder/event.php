<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Log\Log;
use Joomla\CMS\Language\Text;

class PlgSystemJoomlaBuilderEvent extends CMSPlugin
{
    /**
     * Event triggered after the application is initialized.
     */
    public function onAfterInitialise()
    {
        Log::add(Text::_('PLG_SYSTEM_JOOMLABUILDER_EVENT_INIT'), Log::INFO, 'plg_system_joomlabuilder');
    }

    /**
     * Event triggered before rendering the page.
     */
    public function onBeforeRender()
    {
        Log::add(Text::_('PLG_SYSTEM_JOOMLABUILDER_EVENT_BEFORE_RENDER'), Log::INFO, 'plg_system_joomlabuilder');
    }

    /**
     * Event triggered after the page is rendered.
     */
    public function onAfterRender()
    {
        Log::add(Text::_('PLG_SYSTEM_JOOMLABUILDER_EVENT_AFTER_RENDER'), Log::INFO, 'plg_system_joomlabuilder');
    }

    /**
     * Event triggered before saving content.
     *
     * @param string $context The context of the content being saved.
     * @param object $article The article object.
     * @param bool $isNew Indicates if the content is new.
     * @return void
     */
    public function onContentBeforeSave($context, $article, $isNew)
    {
        Log::add(Text::_('PLG_SYSTEM_JOOMLABUILDER_EVENT_BEFORE_SAVE'), Log::INFO, 'plg_system_joomlabuilder');
    }

    /**
     * Event triggered after saving content.
     *
     * @param string $context The context of the content being saved.
     * @param object $article The article object.
     * @param bool $isNew Indicates if the content is new.
     * @return void
     */
    public function onContentAfterSave($context, $article, $isNew)
    {
        Log::add(Text::_('PLG_SYSTEM_JOOMLABUILDER_EVENT_AFTER_SAVE'), Log::INFO, 'plg_system_joomlabuilder');
    }
}
 
