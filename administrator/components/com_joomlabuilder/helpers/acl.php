<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Access\Access;
use Joomla\CMS\User\User;

class JoomlaBuilderHelperACL
{
    /**
     * Checks if the current user has permission for a specific action.
     *
     * @param string $action The action to check (e.g., 'core.manage', 'core.create')
     * @param int|null $userId The user ID (optional, defaults to the current user)
     * @return bool True if the user has permission, false otherwise.
     */
    public static function hasPermission($action, $userId = null)
    {
        $user = Factory::getUser($userId);
        return $user->authorise($action, 'com_joomlabuilder');
    }

    /**
     * Gets a list of user groups that have access to a specific action.
     *
     * @param string $action The action to check (e.g., 'core.manage', 'core.create')
     * @return array List of user group IDs that have access.
     */
    public static function getAuthorizedGroups($action)
    {
        $groups = Access::getGroupsByAssetId(Access::getAssetId('com_joomlabuilder'));
        $authorizedGroups = [];
        
        foreach ($groups as $group) {
            if (Access::checkGroup($group, $action, 'com_joomlabuilder')) {
                $authorizedGroups[] = $group;
            }
        }
        return $authorizedGroups;
    }

    /**
     * Assigns ACL permissions to a user group dynamically.
     *
     * @param int $groupId The ID of the user group.
     * @param string $action The action to assign (e.g., 'core.manage', 'core.create').
     * @return bool True on success, false on failure.
     */
    public static function assignPermissionToGroup($groupId, $action)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        
        $query->insert($db->quoteName('#__assets'))
            ->columns($db->quoteName(['parent_id', 'level', 'rules']))
            ->values(
                $db->quote(1) . ', ' .
                $db->quote(1) . ', ' .
                $db->quote(json_encode([$action => 1]))
            );
        
        $db->setQuery($query);
        return $db->execute();
    }
}
 
