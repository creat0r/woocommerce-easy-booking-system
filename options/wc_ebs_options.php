<?php

class WC_EBS_settings {

	public function __construct() {

		// get plugin options values
		$this->options = get_option('wc_ebs_options');
		
		// initialize options the first time
		if(!$this->options) {
		
		    $this->options = array( 'wc_ebs_info_text_display' => '',
		    						'wc_ebs_info_text' => '',
		    						'wc_ebs_start_date_text' => 'Début', 
		                            'wc_ebs_end_date_text' => 'Fin'
		                        );
		    add_option('wc_ebs_options', $this->options);

		}

		if(is_admin()) {

			add_action('admin_menu', array($this, 'wc_ebs_add_option_page'));
			add_action('admin_init', array($this, 'wc_ebs_admin_init'));

		}

	}

	public function wc_ebs_add_option_page() {
		add_options_page('Easy Booking Options', 'Easy Booking Options', 'manage_options', 'wc_ebs_options', array( $this, 'wc_ebs_option_page' ));
	}

	

	public function wc_ebs_admin_init() {

		register_setting(
			'wc_ebs_options',
			'wc_ebs_options', 
			array( $this, 'sanitize_values' )
		);

		add_settings_section(
			'wc_ebs_main',
			'Text settings',
			array( $this, 'wc_ebs_section_text' ),
			'wc_ebs_options'
		);

		add_settings_field(
			'wc_ebs_info_text_display',
			__('Display information text', 'wc_ebs'),
			array( $this, 'wc_ebs_info_text_display' ),
			'wc_ebs_options',
			'wc_ebs_main'
		);

		add_settings_field(
			'wc_ebs_info_text',
			__('Information text', 'wc_ebs'),
			array( $this, 'wc_ebs_info_text' ),
			'wc_ebs_options',
			'wc_ebs_main'
		);

		add_settings_field(
			'wc_ebs_start_date_text',
			__('First date title', 'wc_ebs'),
			array( $this, 'wc_ebs_start_date' ),
			'wc_ebs_options',
			'wc_ebs_main'
		);

		add_settings_field(
			'wc_ebs_end_date_text',
			__('Second date title', 'wc_ebs'),
			array( $this, 'wc_ebs_end_date' ),
			'wc_ebs_options',
			'wc_ebs_main'
		);

	}

	public function wc_ebs_option_page() {

		?><div class="wrap">
	
			<?php screen_icon('generic'); ?>

			<h2><?php _e('WooCommerce Easy Booking System options', 'wc_ebs'); ?></h2>

			<form method="post" action="options.php">

			<?php settings_fields('wc_ebs_options'); ?>
			<?php do_settings_sections('wc_ebs_options'); ?>
			 
			<?php submit_button(); ?>

			</form>

		</div>
		<?php

	}

	public function wc_ebs_section_text() {
		echo '<p>' . __('Make this plugin yours by choosing the different texts you want to display !', 'wc_ebs') . '</p>';
	}

	public function wc_ebs_info_text_display() {
		echo '<input id="plugin_text_string" name="wc_ebs_options[wc_ebs_info_text_display]" type="checkbox" value="1"' . checked( 1, $this->options['wc_ebs_info_text_display'], false ) .  '/>
		<p class="description">' . __('Choose to display or not an information text before date inputs', 'wc_ebs') . '</p>';
	}

	public function wc_ebs_info_text() {
		echo '<textarea id="plugin_text_string" name="wc_ebs_options[wc_ebs_info_text]" rows="4" cols="50" />' . $this->options['wc_ebs_info_text'] . '</textarea>';
	}

	public function wc_ebs_start_date() {
		echo '<input id="plugin_text_string" name="wc_ebs_options[wc_ebs_start_date_text]" size="40" type="text" value="' . $this->options['wc_ebs_start_date_text'] . '" />
		<p class="description">' . __('Text displayed before the first date', 'wc_ebs') . '</p>';
	}

	public function wc_ebs_end_date() {
		echo '<input id="plugin_text_string" name="wc_ebs_options[wc_ebs_end_date_text]" size="40" type="text" value="' . $this->options['wc_ebs_end_date_text'] . '" />
		<p class="description">' . __('Text displayed before the second date', 'wc_ebs') . '</p>';
	}

	public function sanitize_values( $settings ) {
		
		foreach($settings as $key => $value) {
			$settings[$key] = esc_html($value);
		}

		return $settings;
	}

}

new WC_EBS_settings();