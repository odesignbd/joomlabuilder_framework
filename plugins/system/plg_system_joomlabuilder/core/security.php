 
<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\User\UserHelper;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Log\Log;
use Joomla\CMS\Language\Text;

class JoomlaBuilderSecurity
{
    /**
     * Enforces secure session handling.
     */
    public static function enforceSecureSession()
    {
        $session = Factory::getSession();
        $session->restart();
    }

    /**
     * Sanitizes user input to prevent XSS attacks.
     *
     * @param string $input The user input.
     * @return string The sanitized input.
     */
    public static function sanitizeInput($input)
    {
        return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Checks for brute-force login attempts and blocks excessive attempts.
     */
    public static function preventBruteForce()
    {
        $app = Factory::getApplication();
        $ip = $_SERVER['REMOTE_ADDR'];
        $db = Factory::getDbo();

        $query = $db->getQuery(true)
            ->select('COUNT(*)')
            ->from($db->quoteName('#__failed_logins'))
            ->where($db->quoteName('ip') . ' = ' . $db->quote($ip))
            ->where($db->quoteName('attempt_time') . ' > DATE_SUB(NOW(), INTERVAL 15 MINUTE)');
        $db->setQuery($query);
        $attempts = $db->loadResult();

        if ($attempts > 5) {
            Log::add(Text::_('PLG_SYSTEM_JOOMLABUILDER_SECURITY_BRUTE_FORCE_BLOCKED') . ' - ' . $ip, Log::WARNING, 'security');
            $app->enqueueMessage(Text::_('PLG_SYSTEM_JOOMLABUILDER_SECURITY_TOO_MANY_ATTEMPTS'), 'error');
            $app->redirect(Uri::root());
        }
    }

    /**
     * Validates CSRF token to prevent cross-site request forgery attacks.
     */
    public static function validateCsrfToken()
    {
        $session = Factory::getSession();
        $token = $session->getFormToken();
        if (!isset($_POST[$token]) && !isset($_GET[$token])) {
            throw new Exception(Text::_('PLG_SYSTEM_JOOMLABUILDER_SECURITY_CSRF_ERROR'), 403);
        }
    }

    /**
     * Logs security-related events.
     *
     * @param string $message Security message.
     * @param string $level Log level (info, warning, error).
     */
    public static function logSecurityEvent($message, $level = 'warning')
    {
        Log::add($message, constant('JLog::' . strtoupper($level)), 'security');
    }
}
