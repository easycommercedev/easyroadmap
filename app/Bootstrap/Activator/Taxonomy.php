<?php
namespace EasyRoadmap\Bootstrap\Activator;

defined( 'ABSPATH' ) || exit;

class Taxonomy {

	public function register() {

		/**
		 * STAGES
		 */

		$category_labels = array(
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
		);

		$category_args = array(
			'hierarchical'      => true,
			'labels'            => $category_labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'product-cat' ),
			'show_in_rest'      => true,
		);

		register_taxonomy( 'task_stage', array( 'task' ), $category_args );

		/**
		 * PRODUCTS
		 */

		$brand_labels = array(
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
		);

		$brand_args = array(
			'hierarchical'      => true,
			'labels'            => $brand_labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'product-brand' ),
			'show_in_rest'      => true,
		);

		register_taxonomy( 'task_product', array( 'task' ), $brand_args );

		/**
		 * TAGS
		 * (No textdomain so the translations of the taxonomy tags is used)
		 */

		$tag_labels = array(
			'name' => _x( 'Tags', 'taxonomy general name' ),
			'singular_name' => _x( 'Tag', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search Tags' ),
			'popular_items' => __( 'Popular Tags' ),
			'all_items' => __( 'All Tags' ),
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => __( 'Edit Tag' ), 
			'update_item' => __( 'Update Tag' ),
			'add_new_item' => __( 'Add New Tag' ),
			'new_item_name' => __( 'New Tag Name' ),
			'separate_items_with_commas' => __( 'Separate tags with commas' ),
			'add_or_remove_items' => __( 'Add or remove tags' ),
			'choose_from_most_used' => __( 'Choose from the most used tags' ),
			'menu_name' => __( 'Tags' ),
		);
		
		$tag_args = array(
			'hierarchical'      => false,
			'labels'            => $tag_labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'product-tag' ),
			'show_in_rest'      => true,
		);

		register_taxonomy( 'task_tag', array( 'task' ), $tag_args );
	}
}
