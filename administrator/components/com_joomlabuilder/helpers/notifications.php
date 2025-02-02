<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\User\User;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Response\JsonResponse;

class JoomlaBuilderHelperNotifications
{
    /**
     * Sends a notification message to the Joomla system.
     *
     * @param string $message The message content.
     * @param string $type The message type (message, warning, error).
     */
    public static function sendNotification($message, $type = 'message')
    {
        Factory::getApplication()->enqueueMessage(Text::_($message), $type);
    }

    /**
     * Sends an email notification to a specific user.
     *
     * @param int $userId The ID of the recipient user.
     * @param string $subject The email subject.
     * @param string $body The email body content.
     * @return bool True if email sent successfully, false otherwise.
     */
    public static function sendEmailNotification($userId, $subject, $body)
    {
        $user = Factory::getUser($userId);
        if (!$user || !filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        
        $mailer = Factory::getMailer();
        $mailer->addRecipient($user->email);
        $mailer->setSubject(Text::_($subject));
        $mailer->setBody(Text::_($body));
        
        return $mailer->Send() === true;
    }

    /**
     * Gets a list of system notifications.
     *
     * @return array List of notifications.
     */
    public static function getNotifications()
    {
        // Dummy notification list - in real implementation, this should fetch from database.
        return [
            ['id' => 1, 'message' => Text::_('COM_JOOMLABUILDER_NOTIFICATION_1'), 'type' => 'info', 'timestamp' => time()],
            ['id' => 2, 'message' => Text::_('COM_JOOMLABUILDER_NOTIFICATION_2'), 'type' => 'warning', 'timestamp' => time() - 3600]
        ];
    }
    
    /**
     * Sends a JSON response with notifications.
     */
    public static function jsonResponse()
    {
        echo new JsonResponse(['success' => true, 'notifications' => self::getNotifications()]);
        Factory::getApplication()->close();
    }
}
 
