<?php
/**
 * JoomlaBuilder Plugin Events Handler
 * @package     JoomlaBuilder
 * @subpackage  Plugin Events
 * @author      BS Digital Services & Ventures
 * @license     GNU General Public License
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Log\Log;

class JoomlaBuilderEvent
{
    /**
     * Trigger event when a new article is created
     * @param   object  $context  The context of the content passed to the plugin
     * @param   object  $article  The article data
     * @param   bool    $isNew    Indicates if the article is new
     */
    public static function onContentAfterSave($context, &$article, $isNew)
    {
        if ($context !== 'com_content.article') {
            return;
        }

        $status = $isNew ? 'created' : 'updated';
        Log::add('Article ' . $article->id . ' has been ' . $status . '.', Log::INFO, 'plg_system_joomlabuilder');
    }

    /**
     * Trigger event before an article is deleted
     * @param   object  $context  The context of the content passed to the plugin
     * @param   object  $article  The article data
     */
    public static function onContentBeforeDelete($context, &$article)
    {
        if ($context !== 'com_content.article') {
            return;
        }

        Log::add('Article ' . $article->id . ' is about to be deleted.', Log::WARNING, 'plg_system_joomlabuilder');
    }

    /**
     * Trigger event when a user logs in
     * @param   array   $user     User details
     * @param   array   $options  Login options
     */
    public static function onUserLogin($user, $options = array())
    {
        Log::add('User ' . $user['username'] . ' has logged in.', Log::INFO, 'plg_system_joomlabuilder');
    }

    /**
     * Trigger event when a user logs out
     * @param   array   $user  User details
     */
    public static function onUserLogout($user)
    {
        Log::add('User ' . $user['username'] . ' has logged out.', Log::INFO, 'plg_system_joomlabuilder');
    }
}
