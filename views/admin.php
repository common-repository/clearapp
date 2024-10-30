<div id="clearapp-settings" class="wrap">

  <div id="icon-options-general" class="icon32"><br></div>
  <h2>Clearapp</h2>

  <?php if (isset($updated) and $updated == true) { ?>
    <br/>
    <div id="message" class="updated below-h2"><p>Installed successfully.</p></div>


    <script type="text/javascript">
      jQuery.ajax({
        type: "GET",
        url: window.clearappDomain + "/api/wordpress_installed?installed=true&jsonp=true&callback=?",
        async: false,
        jsonpCallback: "jsonCallback",
        contentType: "application/json",
        dataType: "jsonp"
      });
    </script>
  <?php } ?>

    <?php if (!$installed) { ?>

      <p style="font-size:15px; line-height: 140%">Just one more click to get Clearapp set up on your site:</p>
      <form method="post">
        <?php settings_fields( 'clearapp-settings-group' ); ?>
        <input type="hidden" name="clearapp_container_id"  class="regular-text"  value="<?php echo get_option('clearapp_container_id'); ?>" />
        <input type="submit" class="button-primary button-hero" value="<?php _e('Install Clearapp') ?>" />      
      </form>


    <?php } else { ?>

      <p style="font-size:15px; line-height: 140%">Want to reinstall?</p>
      <form method="post">
        <?php settings_fields( 'clearapp-settings-group' ); ?>
        <input type="hidden" name="clearapp_container_id"  class="regular-text"  value="" />
        <input type="submit" class="button-primary button-hero" value="<?php _e('Reinstall Clearapp') ?>" /> 
      </form>

    <?php } ?>

</div>