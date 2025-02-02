<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Factory;
use Joomla\CMS\Log\Log;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Application\CMSApplicationInterface;

class PlgSystemJoomlaBuilder extends CMSPlugin
{
    /** @var CMSApplicationInterface The Joomla application instance */
    protected $app;

    /**
     * Constructor.
     * @param object &$subject The object to observe
     * @param array $config An optional associative array of configuration settings.
     */
    public function __construct(&$subject, $config = [])
    {
        parent::__construct($subject, $config);
        $this->app = Factory::getApplication();
    }

    /**
     * Triggers on Joomla application after initialization.
     */
    public function onAfterInitialise()
    {
        if ($this->app->isClient('administrator')) {
            return;
        }
        
        $this->initializePlugin();
    }

    /**
     * Initializes the JoomlaBuilder plugin functionalities.
     */
    protected function initializePlugin()
    {
        // Load language file
        $this->loadLanguage();

        // Run system health checks
        $this->checkSystemHealth();
        
        // Execute auto-update mechanism if enabled
        if ($this->params->get('auto_update', 1)) {
            $this->runAutoUpdate();
        }
    }

    /**
     * Check system health for JoomlaBuilder dependencies.
     */
    protected function checkSystemHealth()
    {
        if (!class_exists('JoomlaBuilderHelper')) {
            Factory::getApplication()->enqueueMessage(Text::_('PLG_SYSTEM_JOOMLABUILDER_ERROR_MISSING_CORE_FILES'), 'error');
        }
    }

    /**
     * Run auto-update checks.
     */
    protected function runAutoUpdate()
    {
        require_once __DIR__ . '/core/updates.php';
        JoomlaBuilderUpdate::checkForUpdates();
    }

    /**
     * Event triggered before rendering the page.
     */
    public function onBeforeRender()
    {
        Log::add(Text::_('PLG_SYSTEM_JOOMLABUILDER_EVENT_BEFORE_RENDER'), Log::INFO, 'plg_system_joomlabuilder');
    }

    /**
     * Event triggered after rendering the page.
     */
    public function onAfterRender()
    {
        Log::add(Text::_('PLG_SYSTEM_JOOMLABUILDER_EVENT_AFTER_RENDER'), Log::INFO, 'plg_system_joomlabuilder');
    }
}
