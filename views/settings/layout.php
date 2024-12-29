<?php
use EasyCommerce\Helper\Utility;

$menus = easyroadmap_settings_menus();

$active_menu_id = isset( $_GET['menu'] ) && array_key_exists( $_GET['menu'], $menus ) ? sanitize_key( $_GET['menu'] ) : array_key_first( $menus );
$active_menu = $menus[ $active_menu_id ];

$submenus = isset( $active_menu['submenus'] ) && is_array( $active_menu['submenus'] ) ? $active_menu['submenus'] : [];
$active_submenu_id = isset( $_GET['submenu'] ) && array_key_exists( $_GET['submenu'], $submenus ) ? sanitize_key( $_GET['submenu'] ) : array_key_first( $submenus );

$admin_menu = admin_url( 'admin.php' );
$option_key = "easyroadmap-{$active_menu_id}-{$active_submenu_id}";
$saved_option = get_option( $option_key );

?>
<div id="easyroadmap-settings-wrap">
	
	<div id="easyroadmap-settings-header">
		<h2><?php esc_html_e( 'EasyRoadmap', 'easyroadmap' ); ?></h2>
	</div>

	<div id="easyroadmap-settings-body">

		<div id="easyroadmap-settings-sidebar">
			<div id="easyroadmap-settings-menus">
				<ul id="easyroadmap-settings-menus-list">
				<?php
				foreach ( $menus as $menu_id => $menu ) {
					printf(
						'<li id="%1$s" class="%2$s"><a href="%3$s">%4$s</a></li>',
						esc_attr( $menu_id ),
						esc_attr( $active_menu_id == $menu_id ? 'active' : '' ),
						esc_url( add_query_arg( [ 'page' => 'easyroadmap-settings', 'menu' => $menu_id ], $admin_menu ) ),
						esc_html( $menu['label'] )
					);
				}
				?>
				</ul>
			</div>
		</div>

		<div id="easyroadmap-settings-content">
			<form class="easyroadmap-settings-form" data-option_key="<?php echo esc_attr( $option_key ); ?>" id="" method="post">

				<div id="easyroadmap-settings-content-header">
					<div id="easyroadmap-settings-content-label">
						<h3><?php echo esc_html( $active_menu['label'] ); ?></h3>
					</div>

					<div id="easyroadmap-settings-content-actions">
						<input type="reset" class="button" value="<?php esc_attr_e( 'Reset Settings', 'easyroadmap' ); ?>">
						<input type="submit" class="button" value="<?php esc_attr_e( 'Save Settings', 'easyroadmap' ); ?>">
					</div>
				</div>

				<?php if( count( $submenus ) > 1 ) : ?>
				<div id="easyroadmap-settings-submenus">
					<ul id="easyroadmap-settings-submenus-list">
					<?php
					foreach ( $submenus as $submenu_id => $submenu ) {
						printf(
							'<li id="%1$s" class="%2$s"><a href="%3$s">%4$s</a></li>',
							esc_attr( $submenu_id ),
							esc_attr( $active_submenu_id == $submenu_id ? 'active' : '' ),
							esc_url( add_query_arg( [ 'page' => 'easyroadmap-settings', 'menu' => $active_menu_id, 'submenu' => $submenu_id ], $admin_menu ) ),
							esc_html( $submenu['label'] )
						);
					}
					?>
					</ul>
				</div>
				<?php endif; ?>

				<div id="easyroadmap-settings-sections">
					<?php
					$sections = $menus[ $active_menu_id ]['submenus'][ $active_submenu_id ]['sections'] ?? [];
					
					foreach( $sections as $section_id => $section ) {
						printf( '<div class="easyroadmap-settings-section" id="easyroadmap-settings-section-%1$s">', esc_attr( $section_id ) );
						
						if( ! empty( $section['label'] ) ) {
							printf( '<h2 class="easyroadmap-settings-section-heading">%1$s</h2>', esc_html( $section['label'] ) );
						}

						if( ! empty( $section['desc'] ) ) {
							printf( '<p class="easyroadmap-settings-section-desc">%1$s</p>', esc_html( $section['desc'] ) );
						}

						foreach( $section['fields'] as $field ) {

							if( class_exists( $field_factory = easyroadmap_get_field_factory( $field['type'] ) ) ) {
							
								if( isset( $saved_option[ $field['id'] ] ) ) {
									$field['value'] = $saved_option[ $field['id'] ];
								}

								$field_obj = new $field_factory( $field );
								echo $field_obj->render();
							}
							
						}

						printf( '<input type="submit" class="button" value="%1$s">', esc_attr( __( 'Save Settings', 'easyroadmap' ) ) );

						printf( '</div><!-- #%1$s -->', esc_attr( $section_id ) );
					}
					?>
				</div>

			</form>
		</div>
	</div>
</div>