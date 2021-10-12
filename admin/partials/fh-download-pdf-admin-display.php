<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.nicolasmahler.fr
 * @since      1.0.0
 *
 * @package    Fh_Download_Pdf
 * @subpackage Fh_Download_Pdf/admin/partials
 */

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <h1>
        <?php esc_html_e('Carte PDF du restaurant', 'fh-download-pdf-textdomain'); ?>
    </h1>

    <form method="post" action="options.php" id="target" enctype="multipart/form-data">

        <?php
        settings_fields('fhDownloadPdf');
        do_settings_sections('fhDownloadPdf');
        submit_button();
        ?>

    </form>


</div>