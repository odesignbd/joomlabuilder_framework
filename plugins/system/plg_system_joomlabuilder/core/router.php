 
<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Router\RouterView;
use Joomla\CMS\Router\RouterViewConfiguration;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Factory;

class JoomlaBuilderRouter extends RouterView
{
    public function __construct($app = null, $menu = null)
    {
        $app = $app ?: Factory::getApplication();
        $menu = $menu ?: $app->getMenu();
        parent::__construct($app, $menu);

        // Define the default view
        $this->registerView(new RouterViewConfiguration('dashboard'));
        $this->registerView(new RouterViewConfiguration('templates'));
        $this->registerView(new RouterViewConfiguration('settings'));
    }

    /**
     * Processes a SEF URL and maps it to the internal Joomla structure.
     *
     * @param array $segments The URL segments.
     * @return array The mapped query parameters.
     */
    public function parse(&$segments)
    {
        $vars = [];
        
        if (!empty($segments[0])) {
            $vars['view'] = $segments[0];
        }

        if (!empty($segments[1])) {
            $vars['id'] = (int) $segments[1];
        }
        
        return $vars;
    }

    /**
     * Constructs a SEF URL from Joomla query parameters.
     *
     * @param array $query The Joomla query parameters.
     * @return array The SEF URL segments.
     */
    public function build(&$query)
    {
        $segments = [];

        if (!empty($query['view'])) {
            $segments[] = $query['view'];
            unset($query['view']);
        }

        if (!empty($query['id'])) {
            $segments[] = (int) $query['id'];
            unset($query['id']);
        }
        
        return $segments;
    }
}
