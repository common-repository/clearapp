<p>Add this Clearapp widget to your sidebar where you'd like to run apps.</p>
  

  <p>
    <label for="<?php echo $this->get_field_name( "app" ); ?>">
      <?php _e( 'App ID:' ); ?>
    </label> 
    <input class="widefat" id="<?php echo $this->get_field_id( "app" ); ?>" name="<?php echo $this->get_field_name( "app" ); ?>" type="text" value="<?php echo esc_attr( $app ); ?>" />
  </p>

