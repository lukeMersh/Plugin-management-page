<?php
// create the header
/*
 * Plugin Name: Plugin Management Page
 * Description: This is a simple plugin that demonstrates the use of the menu option and plugin option settings.
 * Author : Luke Mersh
 * Version : 1.0
 */

// we are going to create the admin page and our Settings page for this plugin will be located under General Settings tab.
// Add a menu for our option page
add_action('admin_menu', 'pmp_plugin_add_settings_menu');
function pmp_plugin_add_settings_menu() {
    add_options_page('PMP Plugin Settings', 'PMP Settings', 'manage_options', 'pmp_plugin', 'pmp_plugin_option_page');

}

// create the option page
function pmp_plugin_option_page(){
    ?>
<div class="wrap" xmlns="http://www.w3.org/1999/html">
    <h2>Plugin Management Page</h2>
    <form action="options.php" method="post">
        <?php
        settings_fields('pmp_plugin_options');
        do_settings_sections('pmp_plugin');
        submit_button('Save Changes', 'primary');
        ?>
    </form>
</div>
<?php
}
// register and define the settings
    add_action('admin_init', 'pmp_plugin_admin_init');
function pmp_plugin_admin_init(){
    $args = array(
            'type'=>'string',
        'sanitize_callback'=>'pmp_plugin_validate_options',
        'default'=> NULL
    );

    // register our settings
    register_setting('pmp_plugin_options', 'pmp_plugin_options', $args);

	function pmp_plugin_validate_options( $input ) {
		// Sanitize the input
		$input[ 'name' ] = sanitize_text_field( $input[ 'name' ] );
		return $input;
	}

    //Add a settings section
    add_settings_section(
            'pmp_plugin_main',
        'PMP Plugin Settings',
        'pmp_plugin_section_text',
        'pmp_plugin'
    );

    //create our settings field for name
    add_settings_field(
            'pmp_plugin_name',
        'Your Name',
        'pmp_plugin_setting_name',
        'pmp_plugin',
        'pmp_plugin_main'
    );

    //draw section header
    function pmp_plugin_section_text(){
        echo '<p>Enter your settings here.</p>';
    }

    // Display and fill the Name form field
    function pmp_plugin_setting_name() {

//get options 'text string' value from thr database
        $options = get_option( 'pmp_plugin_option' );
        $name = isset($options['name']) ? $options['name']: '';

        //echo the field
        echo "<input id='name' name='pmp_plugin_options[name]' type= 'text' value='" . esc_attr( $name ) . "'/>";

    }
}