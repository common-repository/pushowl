<?php
/*
Plugin Name: Pushowl
Plugin URI: https://pushowl.com/
Description: Pushowl enables you to re-engage your customers through browser push notifications. Send unlimited notifications to unlimited subscribers for free. Visit https://pushowl.com for more details.
Author: Shashank Kumar
Version: 1.1
pushowl.php
Author URI: https://pushowl.com

This relies on the actions being present in the themes header.php and footer.php
* header.php code before the closing </head> tag
*   wp_head();
*
*/

//------------------------------------------------------------------------//
//---Config---------------------------------------------------------------//
//------------------------------------------------------------------------//

$po_header_pushowl_script = '
<!-- Start Pushowl Code -->
<script
  data-name=\'pushowl\'
  data-subdomain=\'PUSHOWL_SUBDOMAIN\'
  src="https://cdn.pushowl.com/static/cdn/widget.js">
</script>
<!-- End Pushowl Code -->
';

//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//
add_action ( 'wp_head', 'clhf_headercode',1 );
add_action( 'admin_menu', 'clhf_plugin_menu' );
add_action( 'admin_init', 'clhf_register_mysettings' );
add_action( 'admin_notices','clhf_warn_nosettings');


//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//
// options page link
function clhf_plugin_menu() {
  add_options_page('Pushowl', 'Pushowl', 'create_users', 'po_pushowl_options', 'clhf_plugin_options');
}

// whitelist settings
function clhf_register_mysettings(){
  register_setting('po_pushowl_options','pushowl_subdomain');
}

//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//
function clhf_headercode(){
  // runs in the header
  global $po_header_pushowl_script;
  $pushowl_subdomain = get_option('pushowl_subdomain');

  if($pushowl_subdomain){
      echo str_replace('PUSHOWL_SUBDOMAIN', $pushowl_subdomain, $po_header_pushowl_script); // only output if options were saved
  }
}
//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//
// options page
function clhf_plugin_options() {
  echo '<div class="wrap">';?>
  <h2>Pushowl</h2>
  <p>You need to have a <a target="_blank" href="https://pushowl.com/">Pushowl</a> account to use this plugin. This plugin inserts the neccessary code into your Wordpress site automatically without you having to touch anything. In order to use the plugin, you need to enter your Pushowl Subdomain Id (Your Subdomain ID can be found in the <i>Settings</i> section after you <a target="_blank" href="https://dashboard.pushowl.com/settings/">login</a> into your Pushowl account.)</p>
  <form method="post" action="options.php">
  <?php settings_fields( 'po_pushowl_options' ); ?>
  <table class="form-table">
        <tr valign="top">
            <th scope="row">Your Pushowl Subdomain</th>
            <td><input type="text" name="pushowl_subdomain" value="<?php echo get_option('pushowl_subdomain'); ?>" /></td>
        </tr>
  </table>
  
  <p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></p>
<br /><br />
<h2 style="margin-bottom: 40px;">Installation Guide</h2>
<iframe width="560" height="315" src="https://www.youtube.com/embed/nKvfc2_BStw" frameborder="0" allowfullscreen></iframe>

<h2 style="margin-top: 40px;">Make sure subdomain matches the value in settings page.</h2>
<img src="<?php echo plugins_url( 'screenshot-2.png', __FILE__ ); ?>" width="560px" height="auto" />


<p style="margin-top:10px">Just copy the subdomain value ex: demo from pushowl dashboard and enter it above.</p>
<p style="margin-top:20px">Pushowl is a service that enables businesses re-engage their customers through browser push notifications. Browser Push Notifications are actionable messages sent directly to your customers' browsers (even when they are not on your site). Push Notifications are know to have 20X more engagement than traditional emails.
<br /><br />
To enable it for your WordPress site, signup for Free at <a target="_blank" href="https://pushowl.com/">https://pushowl.com/</a>. Or get in touch with us at <a href="mailto:contact@pushowl.com">contact@pushowl.com</a>
</p>
<?php
  echo '</div>';
}

function clhf_warn_nosettings(){
    if (!is_admin())
        return;

  $clhf_option = get_option("pushowl_subdomain");
  if (!$clhf_option){
    echo "<div class='updated fade'><p><strong>Pushowl is almost ready.</strong> Just enter your <a target=\"_blank\" href=\"https://dashboard.pushowl.com/settings\">Subdomain</a> for it to work.</p></div>";
  }
}
?>