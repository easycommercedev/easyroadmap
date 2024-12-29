<?php
namespace EasyRoadmap\Controller\Common;

defined( 'ABSPATH' ) || exit;

use WP_REST_Server;
use EasyRoadmap\API\Option;
use EasyRoadmap\API\Task;
use EasyRoadmap\Trait\Hook;
use EasyRoadmap\Trait\Auth;
use EasyRoadmap\Trait\Rest;

class API {

	use Hook;
	use Auth;
	use Rest;

	/**
	 * Constructor to add all hooks.
	 */
	public function __construct() {
		$this->action( 'rest_api_init', [ $this, 'register_endpoints' ] );
	}

	public function register_endpoints() {

		/**
		 * Tasks related APIs
		 */
		register_rest_route( $this->namespace, '/tasks/(?P<task>[a-zA-Z0-9-_]+)/move', [
		    'methods'   => WP_REST_Server::CREATABLE,
		    'callback'  => [ new Task, 'move' ],
		    'args'      => [
		        'stage' => [
		            'description'   => __( 'The `stage` ID or slug', 'easysupport' ),
		            'required'      => true,
		        ],
		    ],
		    'permission_callback' => [ $this, 'is_admin' ],
		] );
		/**
		 * Options related APIs
		 */
		register_rest_route( $this->namespace, '/option', [
		    'methods'   => WP_REST_Server::READABLE,
		    'callback'  => [ new Option, 'get' ],
		    'args'      => [
		        'key' => [
		            'description'   => __( 'The option `key` name', 'easysupport' ),
		            'required'      => true,
		        ]
		    ],
		    'permission_callback' => [ $this, 'is_admin' ],
		] );

		register_rest_route( $this->namespace, '/option', [
		    'methods'   => WP_REST_Server::CREATABLE,
		    'callback'  => [ new Option, 'update' ],
		    'args'      => [
		        'key' => [
		            'description'   => __( 'The option `key` name', 'easysupport' ),
		            'required'      => true,
		        ],
		        'value' => [
		            'description'   => __( 'The option `value`', 'easysupport' ),
		            'required'      => true,
		        ],
		    ],
		    'permission_callback' => [ $this, 'is_admin' ],
		] );

		register_rest_route( $this->namespace, '/option', [
		    'methods'   => WP_REST_Server::DELETABLE,
		    'callback'  => [ new Option, 'delete' ],
		    'args'      => [
		        'key' => [
		            'description'   => __( 'The option `key` name', 'easysupport' ),
		            'required'      => true,
		        ],
		    ],
		    'permission_callback' => [ $this, 'is_admin' ],
		] );
		
	}
}