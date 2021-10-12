<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://www.nicolasmahler.fr
 * @since      1.0.0
 *
 * @package    Fh_Download_Pdf
 * @subpackage Fh_Download_Pdf/public/partials
 */

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php

/**
 * Swith tpl location
 */
switch ($atts['tpl']) {
    case 'button':
        include(__DIR__ . '/button-tpl.php');
        break;
    case 'link':
        include(__DIR__ . '/link-tpl.php');
        break;
    default:
        include(__DIR__ . '/button-tpl.php');
        break;
}
