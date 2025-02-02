<?php
/**
 * JoomlaBuilder Template - Main Joomla Template Entry Point
 * @package     JoomlaBuilder
 * @author      BS Digital Services & Ventures
 * @license     GNU General Public License
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Document\Document;
use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Uri\Uri;

$app       = Factory::getApplication();
$doc       = Factory::getDocument();
$template  = $app->getTemplate();
$params    = $app->getTemplate(true)->params;

// Load custom CSS & JS
$doc->addStyleSheet(Uri::root() . 'templates/' . $template . '/css/style.css');
$doc->addScript(Uri::root() . 'templates/' . $template . '/js/scripts.js');

// Enable dark mode if set in template settings
$darkMode = $params->get('enable_darkmode', 0) ? 'dark-mode' : '';
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <jdoc:include type="head" />
</head>
<body class="<?php echo $darkMode; ?>">
    <header class="header">
        <h1><?php echo $app->getCfg('sitename'); ?></h1>
        <nav class="navbar">
            <jdoc:include type="modules" name="mainmenu" style="none" />
        </nav>
    </header>
    <main class="container">
        <aside class="sidebar">
            <jdoc:include type="modules" name="sidebar" style="xhtml" />
        </aside>
        <section class="content">
            <jdoc:include type="message" />
            <jdoc:include type="component" />
        </section>
    </main>
    <footer class="footer">
        <p>&copy; <?php echo date('Y'); ?> JoomlaBuilder | Powered by Joomla</p>
        <jdoc:include type="modules" name="footer" style="none" />
    </footer>
</body>
</html>
 
