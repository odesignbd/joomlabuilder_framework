<?php
/**
 * JoomlaBuilder Plugin Parameters Configuration
 * @package     JoomlaBuilder
 * @subpackage  Plugin Parameters
 * @author      BS Digital Services & Ventures
 * @license     GNU General Public License
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Form\Form;

class JoomlaBuilderParams
{
    /**
     * Retrieve stored parameters
     * @return object  Parameters object
     */
    public static function getParams()
    {
        $plugin = Factory::getApplication()->getPlugin('system', 'joomlabuilder');
        return new JRegistry($plugin->params);
    }

    /**
     * Save updated parameters
     * @param   array  $params  Associative array of parameters
     * @return  boolean
     */
    public static function saveParams($params)
    {
        try {
            $db    = Factory::getDbo();
            $query = $db->getQuery(true);
            $query->update($db->quoteName('#__extensions'))
                  ->set($db->quoteName('params') . ' = ' . $db->quote(json_encode($params)))
                  ->where($db->quoteName('element') . ' = ' . $db->quote('joomlabuilder'))
                  ->where($db->quoteName('folder') . ' = ' . $db->quote('system'));
            $db->setQuery($query);
            $db->execute();
            return true;
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage(Text::_('PLG_SYSTEM_JOOMLABUILDER_ERROR_SAVING_PARAMS'), 'error');
            return false;
        }
    }
}
