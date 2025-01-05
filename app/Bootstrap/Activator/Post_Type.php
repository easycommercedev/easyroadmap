<?php
namespace EasyRoadmap\Bootstrap\Activator;

defined( 'ABSPATH' ) || exit;

class Post_Type {

	public function register() {
		$labels = array(
			'name'               => _x( 'Tasks', 'post type general name', 'easyroadmap' ),
			'singular_name'      => _x( 'Task', 'post type singular name', 'easyroadmap' ),
			'menu_name'          => _x( 'EasyRoadmap', 'admin menu', 'easyroadmap' ),
			'name_admin_bar'     => _x( 'Task', 'add new on admin bar', 'easyroadmap' ),
			'add_new'            => _x( 'Add New', 'task', 'easyroadmap' ),
			'add_new_item'       => __( 'Add New', 'easyroadmap' ),
			'new_item'           => __( 'New Task', 'easyroadmap' ),
			'edit_item'          => __( 'Edit Task', 'easyroadmap' ),
			'view_item'          => __( 'View Task', 'easyroadmap' ),
			'all_items'          => __( 'Tasks', 'easyroadmap' ),
			'search_items'       => __( 'Search Tasks', 'easyroadmap' ),
			'parent_item_colon'  => __( 'Parent Tasks:', 'easyroadmap' ),
			'not_found'          => __( 'No tasks found.', 'easyroadmap' ),
			'not_found_in_trash' => __( 'No tasks found in Trash.', 'easyroadmap' ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			// 'show_in_menu'       => 'store',
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'tasks' ),
			'capability_type'    => 'page',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 2,
			'menu_icon'          => 'dashicons-calendar-alt',
			'supports'           => array( 'title', 'editor', 'author', 'comments' ),
			'show_in_rest'       => false,
		);

		register_post_type( 'task', $args );
	}
}
