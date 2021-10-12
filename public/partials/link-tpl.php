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
 * LINK tpl
 */
$output = "<a href='" . esc_url($atts['file']) . "' alt='" . esc_html($atts['name']) . "' title='" . esc_html($atts['name']) . "' target='_blank'>" . esc_html($atts['name']) . " - LINK</a>";
