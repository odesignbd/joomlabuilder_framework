<?php
/**
 * JoomlaBuilder System Plugin
 * @package     JoomlaBuilder
 * @subpackage  Plugin
 * @author      BS Digital Services & Ventures
 * @license     GNU General Public License
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Log\Log;

class PlgSystemJoomlaBuilder extends CMSPlugin
{
    /** @var bool */
    protected $autoloadLanguage = true;

    /**
     * Constructor
     * @param   object  $subject  The object to observe
     * @param   array   $config   Configuration parameters
     */
    public function __construct($subject, $config)
    {
        parent::__construct($subject, $config);
        Log::add('JoomlaBuilder System Plugin Loaded', Log::INFO, 'plg_system_joomlabuilder');
    }

    /**
     * Event triggered on Joomla initialization
     */
    public function onAfterInitialise()
    {
        $app = Factory::getApplication();
        if ($app->isClient('administrator')) {
            return;
        }
        
        // Inject frontend assets
        $doc = Factory::getDocument();
        $doc->addStyleSheet(Uri::base() . 'plugins/system/joomlabuilder/assets/css/style.css');
        $doc->addScript(Uri::base() . 'plugins/system/joomlabuilder/assets/js/script.js');
    }

    /**
     * Event triggered before rendering the page
     */
    public function onBeforeRender()
    {
        $app = Factory::getApplication();
        if (!$app->isClient('administrator')) {
            return;
        }
        
        // Inject admin assets
        $doc = Factory::getDocument();
        $doc->addStyleSheet(Uri::base() . 'plugins/system/joomlabuilder/assets/css/admin.css');
        $doc->addScript(Uri::base() . 'plugins/system/joomlabuilder/assets/js/admin.js');
    }

    /**
     * Event triggered when a user logs in
     * @param   array   $user     User details
     * @param   array   $options  Login options
     */
    public function onUserLogin($user, $options = array())
    {
        Log::add('User ' . $user['username'] . ' logged in.', Log::INFO, 'plg_system_joomlabuilder');
    }

    /**
     * Event triggered when a user logs out
     * @param   array   $user  User details
     */
    public function onUserLogout($user)
    {
        Log::add('User ' . $user['username'] . ' logged out.', Log::INFO, 'plg_system_joomlabuilder');
    }
}
