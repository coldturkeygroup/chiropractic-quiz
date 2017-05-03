<?php

namespace ColdTurkey\ChiroQuiz;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly.

class ChiroQuiz_Admin
{
    private $dir;
    private $file;
    private $assets_dir;
    private $assets_url;
    private $home_url;
    private $token;

    /**
     * Basic constructor for the Chiro Quiz Admin class
     *
     * @param string $file
     */
    public function __construct($file)
    {
        $this->dir = dirname($file);
        $this->file = $file;
        $this->assets_dir = trailingslashit($this->dir) . 'assets';
        $this->assets_url = esc_url(trailingslashit(plugins_url('/assets/', $file)));
        $this->home_url = trailingslashit(home_url());
        $this->token = 'pf_chiro_quiz';

        // Register Chiro Quiz settings
        add_action('admin_init', [$this, 'register_settings']);

        // Add settings page to menu
        add_action('admin_menu', [$this, 'add_menu_item']);

        // Add settings link to plugins page
        add_filter('plugin_action_links_' . plugin_basename($this->file), [$this, 'add_settings_link']);

        add_action('admin_print_scripts-post-new.php', [$this, 'enqueue_admin_styles'], 10);
        add_action('admin_print_scripts-post.php', [$this, 'enqueue_admin_styles'], 10);
        add_action('admin_print_scripts-post-new.php', [$this, 'enqueue_admin_scripts'], 10);
        add_action('admin_print_scripts-post.php', [$this, 'enqueue_admin_scripts'], 10);

        // Display notices in the WP admin
        add_action('admin_notices', [$this, 'admin_notices'], 10);
    }

    /**
     * Add the menu links for the plugin
     *
     */
    public function add_menu_item()
    {
        add_submenu_page('edit.php?post_type=' . $this->token, 'Chiro Quiz Settings', 'Settings', 'manage_options', $this->token . '_settings', [
            $this,
            'settings_page'
        ]);
    }

    /**
     * Add the link to our Settings page
     * from the plugins page
     *
     * @param array $links
     *
     * @return array
     */
    public function add_settings_link($links)
    {
        $settings_link = '<a href="edit.php?post_type=' . $this->token . '&page=' . $this->token . '_settings">Settings</a>';
        array_push($links, $settings_link);

        return $links;
    }

    /**
     * Register the stylesheets that will be
     * used for our scripts in the dashboard.
     *
     */
    public function enqueue_admin_styles()
    {
        global $post_type;
        if ($post_type == $this->token) {
            wp_enqueue_style('wp-color-picker');
        }
    }

    /**
     * Register the Javascript files used by
     * the plugin in the WordPress dashboard
     *
     */
    public function enqueue_admin_scripts()
    {
        global $post_type;
        if ($post_type == $this->token) {
            wp_register_script($this->token . '-admin', esc_url($this->assets_url . 'js/admin.js'), [
                'jquery',
                'wp-color-picker'
            ]);
            wp_enqueue_script($this->token . '-admin');
        }
    }

    /**
     * Define different notices that can be
     * displayed to the user in the dashboard
     *
     */
    public function admin_notices()
    {
        global $wp_version;

        // Version notice
        if ($wp_version < 4.0) {
            ?>
          <div class="error">
            <p><?php printf(__('%1$sChiro Quiz%2$s requires WordPress 4.0 or above in order to function correctly. You are running v%3$s - please update now.', $this->token), '<strong>', '</strong>', $wp_version); ?></p>
          </div>
            <?php
        }
    }

    /**
     * Register the different settings available
     * to customize the plugin.
     *
     */
    public function register_settings()
    {

        // Add settings section
        add_settings_section('customize', __('Basic Settings', $this->token), [
            $this,
            'main_settings'
        ], $this->token);

        // Add settings fields
        add_settings_field($this->token . '_slug', __('URL slug for Chiro Quiz pages:', $this->token), [
            $this,
            'slug_field'
        ], $this->token, 'customize');
        add_settings_field($this->token . '_crm_source', __('Platform CRM API key:', $this->token), [
            $this,
            'crm_source_field',
        ], $this->token, 'customize');
        add_settings_field($this->token . '_frontdesk_key', __('CRM API key:', $this->token), [
            $this,
            'frontdesk_key_field',
        ], $this->token, 'customize');

        // Register settings fields
        register_setting($this->token, $this->token . '_slug', [$this, 'validate_slug']);
        register_setting($this->token, $this->token . '_crm_source');
        register_setting($this->token, $this->token . '_frontdesk_key');

        // Allow plugins to add more settings fields
        do_action($this->token . '_settings_fields');

    }

    /**
     * Define the main description string
     * for the Settings page.
     *
     */
    public function main_settings()
    {
        echo '<p>' . __('These are a few simple settings for setting up your chiro quiz pages.', $this->token) . '</p>';
    }

    /**
     * Create the slug field for the Settings page.
     * The slug field allows users to choose which
     * subdirectory their Chiro Quiz pages are nested in.
     *
     */
    public function slug_field()
    {
        $option = get_option($this->token . '_slug');

        $data = 'chiro-quiz';
        if ($option && strlen($option) > 0 && $option != '') {
            $data = $option;
        }

        echo '<input id="slug" type="text" name="' . $this->token . '_slug" value="' . $data . '"/>
				<label for="slug"><span class="description">' . sprintf(__('Provide a custom URL slug for the chiro quiz pages.', $this->token)) . '</span></label>';
    }

    /**
     * Validates that a slug has been defined,
     * and formats it properly as a URL
     *
     * @param string $slug
     *
     * @return string
     */
    public function validate_slug($slug)
    {
        if ($slug && strlen($slug) > 0 && $slug != '') {
            $slug = urlencode(strtolower(str_replace(' ', '-', $slug)));
        }

        return $slug;
    }

    public function crm_source_field()
    {
        $data = get_option($this->token . '_crm_source');
        $data == 'chirocrm' ? $chiro_selected = 'selected' : $chiro_selected = '';
        $data == 'platformcrm' ? $platform_selected = 'selected' : $platform_selected = '';

        echo '<select id="crm_source" name="' . $this->token . '_crm_source">
                <option ' . $chiro_selected . ' value="chirocrm">Chiro CRM</option>
                <option ' . $platform_selected . ' value="platformcrm">Platform CRM</option>
              </select>
        			<label for="crm_source"><span class="description">' . __('Choose which CRM to sync your leads with.', $this->token) . '</span></label>';
    }

    /**
     * Create the FrontDesk key field for the Settings page.
     * The FrontDesk key field allows users to define their
     * API key to be used in all FrontDesk requests.
     */
    public function frontdesk_key_field()
    {

        $option = get_option($this->token . '_frontdesk_key');

        $data = get_option('pf_frontdesk_key', '');
        if ($option && strlen($option) > 0 && $option != '') {
            $data = $option;
        }

        echo '<input id="frontdesk_key" type="text" name="' . $this->token . '_frontdesk_key" value="' . $data . '"/>
					<label for="frontdesk_key"><span class="description">' . __('Enter your API key generated by your CRM.', $this->token) . '</span></label>';

    }

    /**
     * Define the basic Chiro Quiz URL
     *
     */
    public function pf_chiro_quiz_url()
    {
        $pf_chiro_quiz_url = $this->home_url;

        $slug = get_option($this->token . '_slug');
        if ($slug && strlen($slug) > 0 && $slug != '') {
            $pf_chiro_quiz_url .= $slug;
        } else {
            $pf_chiro_quiz_url .= '?post_type=' . $this->token;
        }

        echo '<a href="' . esc_url($pf_chiro_quiz_url) . '" target="_blank">' . $pf_chiro_quiz_url . '</a>';
    }

    /**
     * Create the actual HTML structure
     * for the Settings page for the plugin
     *
     */
    public function settings_page()
    {
        if (isset($_GET['settings-updated']) && $_GET['settings-updated'] == true) {
            flush_rewrite_rules();
            echo '<div class="updated">
	      			<p>Your settings were successfully updated.</p>
						</div>';
        }

        echo '<div class="wrap" id="' . $this->token . '_settings">
					<h1>' . __('Chiro Quiz Settings', $this->token) . '</h1>
					<form method="post" action="options.php" enctype="multipart/form-data">
						<div class="clear"></div>';

        settings_fields($this->token);
        do_settings_sections($this->token);

        echo '<p class="submit">
							<input name="Submit" type="submit" class="button-primary" value="' . esc_attr(__('Save Settings', $this->token)) . '" />
						</p>
					</form>
			  </div>';
    }
}
