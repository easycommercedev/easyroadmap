<?php
namespace EasyRoadmap\Model;

defined( 'ABSPATH' ) || exit;

use EasyRoadmap\Helper\Utility;

class Roadmap {

    public static function get_roadmap( $product = null ) {
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

			if ( ! is_null( $product ) ) {
				$tax_query[] = array(
					'taxonomy' => 'task_product',
					'field'    => 'term_id',
					'terms'    => $product,
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

		$show_links = apply_filters( 'easyroadmap_show_stage_links', false );

		return Utility::get_template( 'shortcodes/roadmap.php', array( 
			'tasks' => $tasks,
			'show_stage_links' => $show_links,
		) );
    }
}