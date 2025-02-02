<?php
/**
 * JoomlaBuilder Security System
 * @package     JoomlaBuilder
 * @subpackage  Plugin Security Management
 * @author      BS Digital Services & Ventures
 * @license     GNU General Public License
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Uri\Uri;

class JoomlaBuilderSecurity
{
    /**
     * Check if user is logged in
     * @return bool True if user is logged in, False otherwise
     */
    public static function isUserLoggedIn()
    {
        $user = Factory::getUser();
        return !$user->guest;
    }

    /**
     * Generate CSRF Token
     * @return string CSRF Token
     */
    public static function generateToken()
    {
        return Session::getFormToken();
    }

    /**
     * Validate CSRF Token
     * @return bool True if valid, False otherwise
     */
    public static function validateToken()
    {
        return Session::checkToken();
    }

    /**
     * Sanitize Input Data
     * @param mixed $data Input data
     * @return mixed Sanitized data
     */
    public static function sanitizeInput($data)
    {
        if (is_array($data)) {
            return array_map('htmlspecialchars', $data);
        }
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Enforce HTTPS
     */
    public static function enforceHTTPS()
    {
        if (!Uri::getInstance()->isSSL()) {
            header('Location: ' . Uri::getInstance()->toString(['scheme', 'host', 'path']), true, 301);
            exit;
        }
    }
}
