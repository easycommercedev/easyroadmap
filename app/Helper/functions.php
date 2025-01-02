<?php
use EasyRoadmap\Helper\Utility;

/**
 * Returns the home URL of the WordPress site.
 *
 * @param string $path    Optional. Path relative to the home URL.
 * @param int    $blog_id Optional. ID of the blog in a multisite installation.
 *
 * @return string Home URL with optional path appended.
 */
function easyroadmap_home_url( $path = '', $blog_id = null ) {
	return get_home_url( $blog_id, $path );
}

function easyroadmap_settings_menus() {

	$pages = Utility::get_posts( array( 'post_type' => 'page' ) );

	return apply_filters(
		'easyroadmap_settings_menus',
		array(
			'general' => array(
				'label'    => __( 'General', 'easyroadmap' ),
				'desc'     => __( 'General settings', 'easyroadmap' ),
				'icon'     => '',
				'submenus' => array(
					'pages' => array(
						'label'    => __( 'Pages', 'easyroadmap' ),
						'desc'     => __( 'Page Settings', 'easyroadmap' ),
						'sections' => array(
							'main_pages' => array(
								'label'  => __( 'Main Pages', 'easyroadmap' ),
								'desc'   => __( 'Main Pages Settings', 'easyroadmap' ),
								'fields' => array(
									array(
										'id'      => 'homepage',
										'type'    => 'select',
										'label'   => __( 'Homepage', 'easyroadmap' ),
										'options' => $pages,
									),
									array(
										'id'      => 'landing_page',
										'type'    => 'select',
										'label'   => __( 'Landing Page', 'easyroadmap' ),
										'options' => $pages,
									),
								),
							),
						),
					),
				),
			),
			'email'   => array(
				'label'    => __( 'Email', 'easyroadmap' ),
				'desc'     => __( 'Email settings', 'easyroadmap' ),
				'icon'     => '',
				'submenus' => array(
					'new_ticket'    => array(
						'label'    => __( 'New Ticket', 'easyroadmap' ),
						'desc'     => __( 'New Ticket Notification', 'easyroadmap' ),
						'sections' => array(
							'agent_email'  => array(
								'label'  => __( 'Agent Email', 'easyroadmap' ),
								'desc'   => __( 'Email to an Agent', 'easyroadmap' ),
								'fields' => array(
									array(
										'id'    => 'agent_header',
										'type'  => 'text',
										'label' => __( 'Header', 'easyroadmap' ),
									),
									array(
										'id'    => 'agent_subject',
										'type'  => 'text',
										'label' => __( 'Subject', 'easyroadmap' ),
									),
									array(
										'id'    => 'agent_body',
										'type'  => 'wysiwyg',
										'label' => __( 'Body', 'easyroadmap' ),
									),
								),
							),
							'client_email' => array(
								'label'  => __( 'Client Email', 'easyroadmap' ),
								'desc'   => __( 'Email to a Client', 'easyroadmap' ),
								'fields' => array(
									array(
										'id'    => 'client_header',
										'type'  => 'text',
										'label' => __( 'Header', 'easyroadmap' ),
									),
									array(
										'id'    => 'client_subject',
										'type'  => 'text',
										'label' => __( 'Subject', 'easyroadmap' ),
									),
									array(
										'id'    => 'client_body',
										'type'  => 'wysiwyg',
										'label' => __( 'Body', 'easyroadmap' ),
									),
								),
							),
						),
					),
					'agent_replied' => array(
						'label'    => __( 'Agent Reply', 'easyroadmap' ),
						'desc'     => __( 'Agent Reply Notification', 'easyroadmap' ),
						'sections' => array(
							'agent_email_reply' => array(
								'label'  => __( 'Agent Reply Email', 'easyroadmap' ),
								'desc'   => __( 'Email to a Client', 'easyroadmap' ),
								'fields' => array(
									array(
										'id'    => 'client_header',
										'type'  => 'text',
										'label' => __( 'Header', 'easyroadmap' ),
									),
									array(
										'id'    => 'client_subject',
										'type'  => 'text',
										'label' => __( 'Subject', 'easyroadmap' ),
									),
									array(
										'id'    => 'client_body',
										'type'  => 'wysiwyg',
										'label' => __( 'Body', 'easyroadmap' ),
									),
								),
							),
						),
					),
				),
			),
		)
	);
}

function easyroadmap_get_field_factory( $type ) {

	if ( $type == 'switch' ) {
		$type = 'switcher';
	} elseif ( $type == 'wysiwyg' ) {
		$type = 'WYSIWYG';
	}

	return '\\EasyRoadmap\\Helper\\Field\\' . ucfirst( $type );
}

function easyroadmap_product_post_type() {
	return 'task';
}

function easyroadmap_get_random_color() {
	$colors = array( '#FF9999', '#FFCC99', '#FFCC66', '#FFD700', '#FF9966', '#FF6666', '#FF9966', '#FFB266', '#FFDAB9', '#FF8C66', '#FFC1A1', '#FFE5B4', '#B3E5FC', '#81D4FA', '#4FC3F7', '#4DB6AC', '#81C784', '#AED581', '#DCE775', '#FFE082', '#FF8A65', '#F48FB1', '#E57373', '#BA68C8', '#9575CD', '#7986CB' );

	return $colors[ array_rand( $colors ) ];
}
