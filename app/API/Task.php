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
}