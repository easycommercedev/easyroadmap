<?php
namespace EasyRoadmap\Trait;

defined( 'ABSPATH' ) || exit;

/**
 * Trait Auth
 *
 * This trait provides methods to check the current user's roles and statuses in the WordPress plugin.
 *
 * @package EasyRoadmap
 */
trait Auth {

    /**
     * Check if the current user is a logged-in member.
     *
     * @param WP_REST_Request $request The current request.
     * @return bool True if the user is logged in, false otherwise.
     */
    public function is_member( $request ) {
        return is_user_logged_in();
    }

    /**
     * Check if the current user has administrator capabilities.
     *
     * @param WP_REST_Request $request The current request.
     * @return bool True if the user has administrator capabilities, false otherwise.
     */
    public function is_admin( $request ) {
        return current_user_can( 'administrator' );
    }

    /**
     * Check if the current user has editor capabilities.
     *
     * @param WP_REST_Request $request The current request.
     * @return bool True if the user has editor capabilities, false otherwise.
     */
    public function is_editor( $request ) {
        return current_user_can( 'editor' );
    }

    /**
     * Check if the current user is a guest (not logged in).
     *
     * @param WP_REST_Request $request The current request.
     * @return bool True if the user is not logged in, false otherwise.
     */
    public function is_guest( $request ) {
        return ! $this->is_member( $request );
    }

}