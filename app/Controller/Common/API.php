<?php
namespace EasyRoadmap\Controller\Common;

defined( 'ABSPATH' ) || exit;

use WP_REST_Server;
use EasyRoadmap\API\Option;
use EasyRoadmap\API\Task;
use EasyRoadmap\API\Stage;
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
		register_rest_route( $this->namespace, '/tasks/(?P<id>\d+)/move', [
		    'methods'   => WP_REST_Server::CREATABLE,
		    'callback'  => [ new Task, 'move' ],
		    'args'      => [
		        'id' => [
		            'description'   => __( 'The `task` ID', 'easysupport' ),
		            'required'      => true,
		        ],
		        'stage' => [
		            'description'   => __( 'The `stage` ID', 'easysupport' ),
		            'required'      => true,
		        ],
		    ],
		    'permission_callback' => [ $this, 'is_admin' ],
		] );

		register_rest_route( $this->namespace, '/tasks/(?P<id>\d+)', [
		    'methods'   => WP_REST_Server::READABLE,
		    'callback'  => [ new Task, 'get' ],
		    'args'      => [
		        'id' => [
		            'description'   => __( 'The `task` ID', 'easysupport' ),
		            'required'      => true,
		        ]
		    ],
		    'permission_callback' => [ $this, 'is_user' ],
		] );

		register_rest_route( $this->namespace, '/tasks/(?P<id>\d+)/vote', [
		    'methods'   => WP_REST_Server::CREATABLE,
		    'callback'  => [ new Task, 'vote' ],
		    'args'      => [
		        'id' => [
		            'description'   => __( 'The `task` ID', 'easysupport' ),
		            'required'      => true,
		        ],
		        'type' => [
		            'description'   => __( 'The vote type- upvote or downvote', 'easysupport' ),
		            'required'      => true,
		        ],
		    ],
		    'permission_callback' => [ $this, 'is_member' ],
		] );
		
		register_rest_route( $this->namespace, '/tasks/order', [
		    'methods'   => WP_REST_Server::CREATABLE,
		    'callback'  => [ new Task, 'order' ],
		    'args'      => [
		        'order' => [
		            'description'   => __( 'The order', 'easysupport' ),
		            'required'      => true,
		        ],
		    ],
		    'permission_callback' => [ $this, 'is_admin' ],
		] );

		/**
		 * Stage related APIs
		 */
		register_rest_route( $this->namespace, '/stages/order', [
		    'methods'   => WP_REST_Server::CREATABLE,
		    'callback'  => [ new Stage, 'order' ],
		    'args'      => [
		        'order' => [
		            'description'   => __( 'The order', 'easysupport' ),
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