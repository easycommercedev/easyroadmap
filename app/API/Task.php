<?php
namespace EasyRoadmap\API;

defined( 'ABSPATH' ) || exit;

use EasyRoadmap\Trait\Rest;

class Task {

	use Rest;
	
	/**
	 * Move a task to a stage
	 *
	 * @param WP_REST_Request $request
	 * @return WP_REST_Response
	 */
	public function move( $request ) {
	    $task	= $request->get_param( 'task' );
	    $stage	= $request->get_param( 'stage' );

	    wp_set_post_terms( $task, [ $stage ], 'task_stage' );

	    $this->response_success( [ 'message' => __( 'Task moved', 'easyroadmap' ) ] );
	}

	/**
	 * Get a task details
	 */
	public function get( $request ) {
	    $id	= $request->get_param( 'id' );
	    $task = get_post( $id );

	    $this->response_success( [
	    	'message'	=> __( 'Task found', 'easyroadmap' ),
	    	'task'		=> [
	    		'title'			=> $task->post_title,
	    		'description'	=> wpautop( $task->post_content ),
	    		'upvotes'		=> get_post_meta( $task->ID, 'upvotes', true ),
	    		'downvotes'		=> get_post_meta( $task->ID, 'downvotes', true ),
	    	]
	    ] );
	}
}