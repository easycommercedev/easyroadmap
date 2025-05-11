<?php
namespace EasyRoadmap\Controller\Common;

defined( 'ABSPATH' ) || exit;

use EasyRoadmap\Trait\Hook;
use EasyRoadmap\Trait\Asset;

class Init {

	use Hook;
	use Asset;

	/**
	 * Constructor to add all hooks.
	 */
	public function __construct() {
		$this->action( 'wp_head', array( $this, 'modal' ) );
		$this->action( 'admin_head', array( $this, 'modal' ) );
		$this->action( 'wp_enqueue_scripts', array( $this, 'add_assets' ) );
		$this->action( 'admin_enqueue_scripts', array( $this, 'add_assets' ) );
		$this->filter( 'get_terms', array( $this, 'order_terms' ), 10, 4 );
	}

	public function modal() {
		echo '
		<div id="easyroadmap-modal" style="display: none">
			<img id="easyroadmap-modal-loader" src="' . esc_attr( EASYROADMAP_ASSETS_URL . 'common/img/loader.gif' ) . '" />
		</div>';
	}

	public function add_assets() {

		$this->enqueue_script(
			'easyroadmap',
			EASYROADMAP_ASSETS_URL . 'common/js/init.js'
		);

		$this->enqueue_style(
			'easyroadmap',
			EASYROADMAP_ASSETS_URL . 'common/css/init.css'
		);

		// Localize
		$localized = array(
			'api_base' => rest_url( '/easyroadmap/v1' ),
			'nonce'    => wp_create_nonce( 'wp_rest' ),
		);

		$this->localize_script(
			'easyroadmap',
			'EASYROADMAP',
			apply_filters( 'easyroadmap-localized_vars', $localized )
		);
	}

	public function order_terms( $terms, $taxonomies, $query_vars, $term_query ) {

		if ( isset( $taxonomies[0] ) && 'task_stage' === $taxonomies[0] ) {

			usort(
				$terms,
				function ( $a, $b ) {
					$menu_order_a = (int) get_term_meta( $a->term_id, 'menu_order', true );
					$menu_order_b = (int) get_term_meta( $b->term_id, 'menu_order', true );

					return $menu_order_a <=> $menu_order_b;
				}
			);

			return $terms;
		}

		return $terms;
	}
}
