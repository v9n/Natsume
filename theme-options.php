<?php

add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

function theme_options_init(){
	register_setting( 'sample_options', 'natsume_options' );
}

function theme_options_add_page() {
	add_theme_page( __( 'Natsume Options', 'wordpress-natsume' ), __( 'Natsume Options', 'wordpress-natsume' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
}

function theme_options_do_page() {
	global $select_options, $radio_options;

	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;

	?>

	<div class="wrap">
		<?php screen_icon(); echo "<h2>" . wp_get_theme() . __( ' Options', 'wordpress-natsume' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Options saved', 'wordpress-natsume' ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
			<?php settings_fields( 'sample_options' ); ?>
			<?php $options = get_option( 'natsume_options' ); 
			?>

			<table class="form-table">

			<tr>
						<th><?php _e( 'Your name', 'wordpress-natsume' ); ?></th>
						<td><input class="regular-text" type="text" name="natsume_options[theme_username]" value="<?php esc_attr_e( $options['theme_username'] ); ?>" /></td>
					</tr>

					<tr>
						<th><?php _e( 'Exclude category from front page', 'wordpress-natsume' ); ?></th>
						<td>
            <input type="text" name="natsume_options[exclude_cat]" value="<?php echo $options['exclude_cat'];?>" />
						</td>
					</tr>


					<tr>
						<th><?php _e( 'Show RSS Link', 'wordpress-natsume' ); ?></th>
						<td>
							<input type="checkbox" name="natsume_options[rss-link]" value="1"

							<?php if ($options['rss-link'] == 1): ?>
								checked="checked"
							<?php endif ?>
							>
						</td>
					</tr>
					<tr>
						<th><?php _e( 'Google Analytics // Typekit', 'wordpress-natsume' ); ?></th>
						<td>
							<textarea id="natsume_options[google_analytics]" class="regular-text" cols="50" rows="10" name="natsume_options[google_analytics]"><?php echo esc_textarea( $options['google_analytics'] ); ?></textarea>
						</td>
					</tr>

			</table>
				
			<p class="submit"><input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'wordpress-natsume' ); ?>" /></p>			
			
		</form>
	</div>
	<?php
}

function theme_options_validate( $input ) {
	global $select_options, $radio_options;

	// if ( ! isset( $input['anchor'] ) )
	// 	$input['anchor'] = null;
	// $input['anchor'] = ( $input['anchor'] == 1 ? 1 : 0 );
	// 
	// if ( ! isset( $input['pulse'] ) )
	// 	$input['pulse'] = null;
	// $input['pulse'] = ( $input['pulse'] == 1 ? 1 : 0 );

	$input['color'] = wp_filter_nohtml_kses( $input['color'] );

	/*if ( ! @array_key_exists( $input['selectinput'], $select_options ) )
		$input['selectinput'] = null; */

	$input['google_analytics'] = $input['google_analytics'] ;

	return $input;
}

?>
