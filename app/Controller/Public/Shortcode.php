<?php
namespace EasyRoadmap\Controller\Public;

defined( 'ABSPATH' ) || exit;

use EasyRoadmap\Trait\Hook;
use EasyRoadmap\Helper\Utility;

class Shortcode {

	use Hook;

	/**
	 * Constructor to add all hooks.
	 */
	public function __construct() {
		$this->shortcode( 'roadmap', array( $this, 'callback_roadmap' ) );
	}

	public function callback_roadmap( $atts ) {
		$atts = shortcode_atts( array( 'product' => null ), $atts, 'roadmap' );

		$tasks  = array();
		$stages = get_terms(
			array(
				'taxonomy'   => 'task_stage',
				'hide_empty' => false,
				'orderby'    => 'id',
				'order'      => 'ASC',
			)
		);

		foreach ( $stages as $stage ) {
			$tasks[ $stage->slug ]['id']   = $stage->term_id;
			$tasks[ $stage->slug ]['name'] = $stage->name;

			$tax_query = array();

			$tax_query[] = array(
				'taxonomy' => 'task_stage',
				'field'    => 'slug',
				'terms'    => $stage->slug,
			);

			if ( ! is_null( $atts['product'] ) ) {
				$tax_query[] = array(
					'taxonomy' => 'task_product',
					'field'    => 'term_id',
					'terms'    => $atts['product'],
				);
			}

			$tasks[ $stage->slug ]['tasks'] = Utility::get_posts(
				array(
					'post_type'      => 'task',
					'tax_query'      => $tax_query,
					'posts_per_page' => -1,
					'orderby'        => 'menu_order',
					'order'          => 'ASC',
				)
			);
		}

		return Utility::get_template( 'shortcodes/roadmap.php', array( 'tasks' => $tasks ) );
	}
}
