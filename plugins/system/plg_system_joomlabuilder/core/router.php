<?php
/**
 * JoomlaBuilder Router System
 * @package     JoomlaBuilder
 * @subpackage  Plugin Routing Management
 * @author      BS Digital Services & Ventures
 * @license     GNU General Public License
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Router\RouterView;
use Joomla\CMS\Router\RouterRulesInterface;
use Joomla\CMS\Factory;

class JoomlaBuilderRouter extends RouterView implements RouterRulesInterface
{
    /**
     * Constructor
     * @param object $app Joomla Application Instance
     * @param array  $params Component Parameters
     */
    public function __construct($app, $params)
    {
        parent::__construct($app, $params);
    }

    /**
     * Build SEF URL
     * @param array $query URL Query Parameters
     * @return array Processed Segments for SEF URL
     */
    public function build(&$query)
    {
        $segments = [];
        if (isset($query['view'])) {
            $segments[] = $query['view'];
            unset($query['view']);
        }
        if (isset($query['id'])) {
            $segments[] = $query['id'];
            unset($query['id']);
        }
        return $segments;
    }

    /**
     * Parse SEF URL
     * @param array $segments URL Segments
     * @return array Query Variables
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
}