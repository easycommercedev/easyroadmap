<?php
namespace EasyRoadmap\Abstract;

defined( 'ABSPATH' ) || exit;

use EasyRoadmap\Model\Database;

/**
 * Class Meta
 * Handles generic meta operations.
 */
abstract class Meta extends Database {

	protected $unique_id_key;

	public function __construct( $table_name, $unique_id_key ) {
		$this->unique_id_key = $unique_id_key;
		parent::__construct( $table_name );
	}

	/**
	 * Add meta data.
	 *
	 * @param int    $unique_id
	 * @param string $key
	 * @param mixed  $value
	 * @return int|null The last inserted ID or null on failure.
	 */
	public function add( $unique_id, $key, $value ) {
		return $this->insert_row(
			array(
				$this->unique_id_key => $unique_id,
				'name'               => $key,
				'value'              => maybe_serialize( $value ),
			)
		);
	}

	/**
	 * Get meta data.
	 *
	 * @param int    $unique_id
	 * @param string $key
	 * @param bool   $single
	 * @return mixed
	 */
	public function get( $unique_id, $key, $single = true ) {
		if ( $single ) {
			$result = $this->get_row(
				array(
					$this->unique_id_key => $unique_id,
					'name'               => $key,
				)
			);

			return $result ? maybe_unserialize( $result->value ) : null;
		} else {
			$results = $this->get_rows(
				array(
					$this->unique_id_key => $unique_id,
					'name'               => $key,
				)
			);

			return $results ? array_map(
				function ( $result ) {
					return maybe_unserialize( $result->value );
				},
				$results
			) : array();
		}
	}

	/**
	 * Update meta data.
	 *
	 * @param int    $unique_id
	 * @param string $key
	 * @param mixed  $value
	 * @return bool|int If updating an existing entry, returns true on success, false on failure.
	 *                  If creating a new entry, returns the last inserted ID or null on failure.
	 */
	public function update( $unique_id, $key, $value ) {
		$entry = $this->get_row(
			array(
				$this->unique_id_key => $unique_id,
				'name'               => $key,
			)
		);

		if ( $entry ) {
			return parent::update_row(
				$entry->id,
				array( 'value' => maybe_serialize( $value ) )
			);
		} else {
			return $this->add( $unique_id, $key, $value );
		}
	}

	/**
	 * Delete meta data.
	 *
	 * @param int    $unique_id
	 * @param string $key
	 * @return bool
	 */
	public function delete( $unique_id, $key ) {
		$entry = $this->get_row(
			array(
				$this->unique_id_key => $unique_id,
				'name'               => $key,
			)
		);

		if ( $entry ) {
			return parent::delete_row( $entry->id );
		} else {
			return false;
		}
	}
}
