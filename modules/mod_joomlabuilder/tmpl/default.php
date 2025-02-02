<?php
/**
 * JoomlaBuilder Module - Default Template
 * @package     JoomlaBuilder
 * @author      BS Digital Services & Ventures
 * @license     GNU General Public License
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Language\Text;

// Get module parameters
$app       = Factory::getApplication();
$doc       = Factory::getDocument();
$moduleID  = $module->id;
$params    = $module->params;
$customCSS = $params->get('custom_css', '');

// Load module assets
$doc->addStyleSheet(Uri::base() . 'modules/mod_joomlabuilder/assets/style.css');
$doc->addScript(Uri::base() . 'modules/mod_joomlabuilder/assets/script.js');

// Get any custom parameters
$moduleTitle = $params->get('module_title', 'JoomlaBuilder Module');
$description = $params->get('module_description', 'This is a JoomlaBuilder module displaying dynamic content.');
$buttonText  = $params->get('button_text', 'Learn More');
$link        = $params->get('button_link', '#');
?>

<div class="mod-joomlabuilder" id="joomlabuilder-module-<?php echo $moduleID; ?>">
    <div class="joomlabuilder-header">
        <h2><?php echo htmlspecialchars($moduleTitle, ENT_QUOTES, 'UTF-8'); ?></h2>
    </div>
    <div class="joomlabuilder-content">
        <p><?php echo htmlspecialchars($description, ENT_QUOTES, 'UTF-8'); ?></p>
        <a href="<?php echo htmlspecialchars($link, ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary">
            <?php echo htmlspecialchars($buttonText, ENT_QUOTES, 'UTF-8'); ?>
        </a>
    </div>
</div>

<style>
<?php echo $customCSS; ?>
</style>
