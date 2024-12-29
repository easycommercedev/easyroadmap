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
		$this->shortcode( 'roadmap', [ $this, 'callback_roadmap' ] );
	}

	public function callback_roadmap( $atts ) {
		$atts	= shortcode_atts( [ 'product' => null ], $atts, 'roadmap' );

		$tasks	= [];
		$stages	= get_terms( [ 'taxonomy' => 'task_stage', 'hide_empty' => false, 'orderby'  => 'id', 'order' => 'ASC' ] );

		foreach ( $stages as $stage ) {
			$tasks[ $stage->slug ]['id']	= $stage->term_id;
			$tasks[ $stage->slug ]['name']	= $stage->name;

			$tax_query = [];

			$tax_query[] = [
				'taxonomy'	=> 'task_stage',
				'field'		=> 'slug',
				'terms'		=> $stage->slug,
		    ];

			if( ! is_null( $atts['product'] )  ) {
				$tax_query[] = [
					'taxonomy'	=> 'task_product',
					'field'		=> 'term_id',
					'terms'		=> $atts['product'],
			    ];
			}

			$tasks[ $stage->slug ]['tasks']	= Utility::get_posts( [
				'post_type'			=> 'task',
				'tax_query' 		=> $tax_query,
				'posts_per_page'	=> -1
			] );
		}
		
		return Utility::get_template( 'shortcodes/roadmap.php', [ 'tasks' => $tasks ] );
	}

}