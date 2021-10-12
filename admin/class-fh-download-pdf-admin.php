<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.nicolasmahler.fr
 * @since      1.0.0
 *
 * @package    Fh_Download_Pdf
 * @subpackage Fh_Download_Pdf/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two hooks to
 * enqueue the admin-facing stylesheet and JavaScript.
 * As you add hooks and methods, update this description.
 *
 * @package    Fh_Download_Pdf
 * @subpackage Fh_Download_Pdf/admin
 * @author     Your Name <contact@nicolasmahler.fr>
 */
class Fh_Download_Pdf_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The unique prefix of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_prefix    The string used to uniquely prefix technical functions of this plugin.
	 */
	private $plugin_prefix;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $plugin_prefix    The unique prefix of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $plugin_prefix, $version)
	{

		$this->plugin_name   = $plugin_name;
		$this->plugin_prefix = $plugin_prefix;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 * @param string $hook_suffix The current admin page.
	 */
	public function enqueue_styles($hook_suffix)
	{

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/fh-download-pdf-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 * @param string $hook_suffix The current admin page.
	 */
	public function enqueue_scripts($hook_suffix)
	{

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/fh-download-pdf-admin.js', array('jquery'), $this->version, false);
	}


	/**
	 * Register admin menu
	 *
	 * @return void
	 */
	public function setup_menu()
	{
		add_menu_page(
			__('Carte du restaurant', 'fh-downwload-pdf'),
			__('Carte PDF du restaurant', 'fh-downwload-pdf'), // item name
			'manage_options', // droits
			'fh-downwload-pdf', // slug 
			array(__CLASS__, 'admin_page_contents'), // function
			'dashicons-pdf', // icone
			3	// menu positions
		);
	}

	/**
	 * Fields
	 *
	 * @return void
	 */
	public function settings_init()
	{

		/**
		 * type file
		 */
		register_setting(
			'fhDownloadPdf',
			'fh_download_pdf_file_url',
			array(__CLASS__, 'handle_file_upload'), //Callback function to store value and file
		);

		/**
		 * Name and published fields
		 */
		register_setting(
			'fhDownloadPdf',
			'fh_download_pdf_settings'
		);

		add_settings_section(
			'settings_section',
			__('Our section title', 'wordpress'),
			array(__CLASS__, 'settings_section_callback'),
			'fhDownloadPdf'
		);

		/**
		 * textfield : name
		 */
		add_settings_field(
			'name_textfield',
			__('Nom du fichier', 'wordpress'),
			array(__CLASS__, 'name_textfield_callback'),
			'fhDownloadPdf',
			'settings_section'
		);

		/**
		 * selectfield : published
		 */
		add_settings_field(
			'select_field',
			__('Statut', 'wordpress'),
			array(__CLASS__, 'select_field_callback'),
			'fhDownloadPdf',
			'settings_section'
		);

		/**
		 * uploadfield : pdf fiel
		 */
		add_settings_field(
			'fh_download_pdf_file_url',
			__('Sélectionner un fichier PDF', 'wordpress'),
			array(__CLASS__, 'file_field_callback'),
			'fhDownloadPdf',
			'settings_section'
		);
	}

	/**
	 * Callback function to store file on sever + url in DB
	 *
	 * @param [type] $option
	 * @return void
	 */
	public static function handle_file_upload($option)
	{

		if (!empty($_FILES["fh_download_pdf_file_url"]["tmp_name"])) {

			$urls = wp_handle_upload($_FILES["fh_download_pdf_file_url"], array('test_form' => FALSE));
			$temp = $urls["url"];
			return $temp;
		}

		return get_option('fh_download_pdf_file_url');
	}

	/**
	 * Create text field
	 *
	 * @return void
	 */
	public static function name_textfield_callback()
	{
		$options = get_option('fh_download_pdf_settings');
		$name = ($options) ? $options['name_textfield'] : '';

		echo "<input 
		type='text' 
		name='fh_download_pdf_settings[name_textfield]' 
		id='fh_download_pdf_settings[name_textfield]' 
		value='" . $name . "'
		>";
	}

	/**
	 * Create select field
	 *
	 * @return void
	 */
	public static function select_field_callback()
	{
		$options = get_option('fh_download_pdf_settings');
		$select = ($options) ? $options['select_field'] : '';

		echo "<select name='fh_download_pdf_settings[select_field]'>
            <option value='1'";
		selected($select, 1);
		echo "'>Activé</option>
            <option value='0'";
		selected($select, 0);
		echo "'>Désactivé</option>
        </select>";
	}


	/**
	 * Create file field
	 *
	 * @return void
	 */
	public static function file_field_callback()
	{
		//Instancier l'option si elle n'existe pas (creer une entrée dans la base de données)
		//Si ce n'est pas le cas, lors d'une première validation du formulaire : la valeur n'est pas stockée
		//A la place : l'option est créée avec une valeur vide.
		if (!get_option('fh_download_pdf_file_url')) {
			add_option("fh_download_pdf_file_url", "");
		}

		$file_url = get_option('fh_download_pdf_file_url');
		echo "<input 
		type='file' 
		name='fh_download_pdf_file_url' 
        id='fh_download_pdf_settings_file_field' 
		accept='application/pdf'
		><br>";

		if ($file_url) {
			echo "<em>Fichier actuel : " . $file_url . "</em><br>
			<a href='" . $file_url . "' target='_blank'>Voir le fichier</a>";
		}
	}


	public static function settings_section_callback()
	{
		echo __('Entrez un nom et téléversez le fichier PDF.', 'wordpress');
	}

	/**
	 * Admin template location
	 *
	 * @return void
	 */
	public static function admin_page_contents()
	{
		include(__DIR__ . '/partials/fh-download-pdf-admin-display.php');
	}
}
