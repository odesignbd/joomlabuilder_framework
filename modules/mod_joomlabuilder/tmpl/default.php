<?php
/**
 * JoomlaBuilder Module - Default Template (Refined Version)
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
$customCSS = htmlspecialchars($params->get('custom_css', ''), ENT_QUOTES, 'UTF-8');

// Load module assets
$doc->addStyleSheet(Uri::base() . 'modules/mod_joomlabuilder/assets/style.css');
$doc->addScript(Uri::base() . 'modules/mod_joomlabuilder/assets/script.js');

// Get any custom parameters
$moduleTitle = htmlspecialchars($params->get('module_title', 'JoomlaBuilder Module'), ENT_QUOTES, 'UTF-8');
$description = htmlspecialchars($params->get('module_description', 'This is a JoomlaBuilder module displaying dynamic content.'), ENT_QUOTES, 'UTF-8');
$buttonText  = htmlspecialchars($params->get('button_text', 'Learn More'), ENT_QUOTES, 'UTF-8');
$link        = htmlspecialchars($params->get('button_link', '#'), ENT_QUOTES, 'UTF-8');
?>

<div class="mod-joomlabuilder" id="joomlabuilder-module-<?php echo (int) $moduleID; ?>">
    <div class="joomlabuilder-header">
        <h2><?php echo $moduleTitle; ?></h2>
    </div>
    <div class="joomlabuilder-content">
        <p><?php echo $description; ?></p>
        <a href="<?php echo $link; ?>" class="btn btn-primary">
            <?php echo $buttonText; ?>
        </a>
    </div>
</div>

<style>
<?php echo $customCSS; ?>
</style>
