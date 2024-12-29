<?php
namespace EasyRoadmap\Bootstrap\Activator;

defined( 'ABSPATH' ) || exit;

class Taxonomy {

	public function register() {
		$category_labels = [
			'name'              => _x( 'Stages', 'taxonomy general name', 'easyroadmap' ),
			'singular_name'     => _x( 'Stage', 'taxonomy singular name', 'easyroadmap' ),
			'search_items'      => __( 'Search Stages', 'easyroadmap' ),
			'all_items'         => __( 'All Stages', 'easyroadmap' ),
			'parent_item'       => __( 'Parent Stage', 'easyroadmap' ),
			'parent_item_colon' => __( 'Parent Stage:', 'easyroadmap' ),
			'edit_item'         => __( 'Edit Stage', 'easyroadmap' ),
			'update_item'       => __( 'Update Stage', 'easyroadmap' ),
			'add_new_item'      => __( 'Add New Stage', 'easyroadmap' ),
			'new_item_name'     => __( 'New Stage Name', 'easyroadmap' ),
			'menu_name'         => __( 'Stages', 'easyroadmap' ),
		];

		$category_args = [
			'hierarchical'      => true,
			'labels'            => $category_labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => [ 'slug' => 'product-cat' ],
			'show_in_rest'      => true,
		];

		register_taxonomy( 'task_stage', [ 'task' ], $category_args );
		
		$brand_labels = [
			'name'              => _x( 'Products', 'taxonomy general name', 'easyroadmap' ),
			'singular_name'     => _x( 'Product', 'taxonomy singular name', 'easyroadmap' ),
			'search_items'      => __( 'Search Products', 'easyroadmap' ),
			'all_items'         => __( 'All Products', 'easyroadmap' ),
			'parent_item'       => __( 'Parent Product', 'easyroadmap' ),
			'parent_item_colon' => __( 'Parent Product:', 'easyroadmap' ),
			'edit_item'         => __( 'Edit Product', 'easyroadmap' ),
			'update_item'       => __( 'Update Product', 'easyroadmap' ),
			'add_new_item'      => __( 'Add New Product', 'easyroadmap' ),
			'new_item_name'     => __( 'New Product Name', 'easyroadmap' ),
			'menu_name'         => __( 'Products', 'easyroadmap' ),
		];

		$brand_args = [
			'hierarchical'      => true,
			'labels'            => $brand_labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => [ 'slug' => 'product-brand' ],
			'show_in_rest'      => true,
		];

		register_taxonomy( 'task_product', [ 'task' ], $brand_args );
	}
}