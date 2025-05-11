<?php
namespace EasyRoadmap\Helper;

defined( 'ABSPATH' ) || exit;

/**
 * Utility class with static helper functions for general use throughout the plugin.
 */
class Utility {

	/**
	 * Formats a date string according to WordPress settings.
	 *
	 * @param string $date The date string (e.g., 'Y-m-d H:i:s').
	 * @param string $format Optional. PHP date format. Defaults to WordPress date format setting.
	 * @return string Formatted date string.
	 */
	public static function format_date( $date, $format = '' ) {
		if ( empty( $format ) ) {
			$format = get_option( 'date_format' );
		}
		return date_i18n( $format, strtotime( $date ) );
	}

	/**
	 * Prints information about a variable in a more readable format.
	 *
	 * @param mixed $data The variable you want to display.
	 * @param bool  $admin_only Should it display in wp-admin area only
	 * @param bool  $hide_adminbar Should it hide the admin bar
	 */
	public static function pri( $data, $admin_only = true ) {

		if ( $admin_only && ! current_user_can( 'manage_options' ) ) {
			return;
		}

		echo '<pre>';
		if ( is_object( $data ) || is_array( $data ) ) {
			print_r( $data );
		} else {
			var_dump( $data );
		}
		echo '</pre>';
	}

	/**
	 * Includes a template file from the 'view' directory.
	 *
	 * @param string $template The template file name.
	 * @param array  $args Optional. An associative array of variables to pass to the template file.
	 */
	public static function get_template( $template, $args = array() ) {

		$extension = pathinfo( $template, PATHINFO_EXTENSION );
		if ( $extension !== 'php' ) {
			$template .= '.php';
		}

		$path = EASYROADMAP_PLUGIN_DIR . 'views/' . $template;

		if ( file_exists( $path ) ) {
			if ( ! empty( $args ) && is_array( $args ) ) {
				foreach ( $args as $key => $value ) {
					${$key} = $value;
				}
			}

			ob_start();

			include $path;

			return ob_get_clean();
		} else {
			error_log( 'Template file not found: ' . $path );
		}
	}

	/**
	 * @param bool $show_cached either to use a cached list of posts or not. If enabled, make sure to wp_cache_delete() with the `save_post` hook
	 */
	public static function get_posts( $args = array(), $show_heading = false, $show_cached = false ) {

		$defaults = array(
			'post_type'      => 'post',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
		);

		$_args = wp_parse_args( $args, $defaults );

		// use cache
		if ( true === $show_cached && ( $cached_posts = wp_cache_get( "easyroadmap_{$_args['post_type']}", 'easyroadmap' ) ) ) {
			$posts = $cached_posts;
		}

		// don't use cache
		else {
			$queried = new \WP_Query( $_args );

			$posts = array();
			foreach ( $queried->posts as $post ) :
				$posts[ $post->ID ] = $post->post_title;
			endforeach;

			wp_cache_add( "easyroadmap_{$_args['post_type']}", $posts, 'easyroadmap', 3600 );
		}

		$posts = $show_heading ? array( '' => sprintf( __( '- Choose a %s -', 'easyroadmap' ), $_args['post_type'] ) ) + $posts : $posts;

		return apply_filters( 'easyroadmap_get_posts', $posts, $_args );
	}

	public static function get_option( $option, $section, $field, $default = '' ) {

		$key     = "easyroadmap-{$option}-{$section}";
		$options = get_option( $key );

		if ( isset( $options[ $field ] ) ) {
			return $options[ $field ];
		}

		return $default;
	}
}
