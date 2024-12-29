<?php
namespace EasyRoadmap\API;

defined( 'ABSPATH' ) || exit;

use EasyRoadmap\Trait\Rest;
use EasyRoadmap\Trait\Cleaner;

class Stage {

	use Rest;
	use Cleaner;
	
	/**
	 * Sort stage orders
	 *
	 * @param WP_REST_Request $request
	 * @return WP_REST_Response
	 */
	public function order( $request ) {
	    $task	= $request->get_param( 'id' );
	    $stage	= $request->get_param( 'stage' );

	    foreach ( $this->sanitize( $_POST['order'], 'array' ) as $position => $term_id ) {
	        $term_id = (int) str_replace( 'tag-', '', $term_id );
	        
	        update_term_meta( $term_id, 'menu_order', $position );
	    }

	    $this->response_success( [ 'message' => __( 'Stage order changed', 'easyroadmap' ) ] );
	}
}