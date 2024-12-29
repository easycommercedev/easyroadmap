<?php
namespace EasyRoadmap\Model;

defined( 'ABSPATH' ) || exit;

/**
 * Generic Database class for handling database operations across different tables.
 */
class Database {

    /**
     * The WordPress database access abstraction object.
     * @var wpdb
     */
    protected $db;

    /**
     * The common prefix for the tables.
     * @var string
     */
    protected $prefix = 'easyroadmap_';

    /**
     * The full database table name including the prefix.
     * @var string
     */
    protected $table_name;

    /**
     * The primary key for the specific table.
     * @var string
     */
    protected $primary_key;

    /**
     * Constructor to set up database operations.
     *
     * @param string $table_name Table name for the specific entity (without prefix).
     * @param string $primary_key The primary key for the specific table.
     */
    public function __construct( $table_name = null, $primary_key = 'id' ) {
        global $wpdb;

        $this->db           = $wpdb;
        $this->table_name   = $this->db->prefix . $this->prefix . $table_name;
        $this->primary_key  = $primary_key;
    }

    /**
     * Sets the table name and updates the table name property.
     *
     * @param string $table_name Table name for the specific entity (without prefix).
     * @return void
     */
    public function set_table( $table_name ) {
        $this->table_name = $this->db->prefix . $this->prefix . $table_name;
    }

    /**
     * Creates a new table in the database based on the table name provided during the object's instantiation.
     *
     * @param array $columns Associative array of column definitions.
     * @param array $options Additional options for table creation like primary key.
     * @return void
     */
    public function create_table( $columns, $options = [] ) {
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        $charset_collate = $this->db->get_charset_collate();

        $sql = "CREATE TABLE {$this->table_name} (\n";

        foreach ( $columns as $column => $definition ) {
            $sql .= "$column $definition,\n";
        }

        if ( ! empty( $options['primary_key'] ) ) {
            $sql .= "PRIMARY KEY ({$options['primary_key']}),\n";
        } else {
            $sql .= "PRIMARY KEY ({$this->primary_key}),\n";
        }

        if ( ! empty( $options['unique_keys'] ) ) {
            foreach ( $options['unique_keys'] as $key => $columns ) {
                $sql .= "UNIQUE KEY $key ($columns),\n";
            }
        }

        if ( ! empty( $options['indexes'] ) ) {
            foreach ( $options['indexes'] as $index => $columns ) {
                $sql .= "INDEX $index ($columns),\n";
            }
        }

        if ( ! empty( $options['foreign_keys'] ) ) {
            foreach ( $options['foreign_keys'] as $key => $fk_options ) {
                $sql .= "FOREIGN KEY $key ({$fk_options['column']}) REFERENCES {$fk_options['ref_table']} ({$fk_options['ref_column']}) ON DELETE {$fk_options['on_delete']} ON UPDATE {$fk_options['on_update']} ,\n";
            }
        }

        $sql = rtrim( $sql, ",\n" ) . "\n) $charset_collate;";

        dbDelta( $sql );
    }

    /**
     * Drops the table from the database.
     *
     * @return void
     */
    public function drop_table() {
        $sql = "DROP TABLE IF EXISTS {$this->table_name}";
        $this->db->query( $sql );
    }

    /**
     * Retrieves an entry by its primary key ID.
     *
     * @param int $id The ID of the entry to retrieve.
     * @return object|null The object if found, otherwise null.
     */
    public function get_by_id( $id ) {
        $query = $this->db->prepare( "SELECT * FROM {$this->table_name} WHERE {$this->primary_key} = %d", $id );

        return $this->db->get_row( $query );
    }

    /**
     * Inserts a new entry into the database.
     *
     * @param array $data Associative array of data to insert.
     * @return int|null The last inserted ID or null on failure.
     */
    public function insert_row( $data ) {
        if ( $this->db->insert( $this->table_name, $data ) ) {
            return $this->db->insert_id;
        }

        return null;
    }

    /**
     * Updates an existing entry.
     *
     * @param int $id The ID of the entry to update.
     * @param array $data Associative array of data to update.
     * @return bool True if successful, false otherwise.
     */
    public function update_row( $id, array $data ) {
        return $this->db->update( $this->table_name, $data, [ $this->primary_key => $id ] );
    }

    /**
     * Deletes an entry by its primary key ID.
     *
     * @param int $id The ID of the entry to delete.
     * @return bool True if successful, false otherwise.
     */
    public function delete_row( $id ) {
        return $this->db->delete( $this->table_name, [ $this->primary_key => $id ] );
    }

    /**
     * Inserts multiple entries into the database.
     *
     * @param array $rows Array of associative arrays of data to insert.
     * @return array Array of inserted IDs or null on failure.
     */
    public function insert_rows( $rows ) {
        $inserted_ids = [];
        foreach ( $rows as $data ) {
            $id = $this->insert_row( $data );

            if ( $id === null ) {
                return null;
            }

            $inserted_ids[] = $id;
        }

        return $inserted_ids;
    }

    /**
     * Updates multiple entries in the database.
     *
     * @param array $rows Array of associative arrays containing 'id' and 'data' keys.
     * @return bool True if all updates are successful, false otherwise.
     */
    public function update_rows( $rows ) {
        foreach ( $rows as $row ) {
            if ( ! $this->update_row( $row['id'], $row['data'] ) ) {
                return false;
            }
        }

        return true;
    }

    /**
     * Deletes multiple entries from the database.
     *
     * @param array $ids Array of IDs of the entries to delete.
     * @return bool True if all deletions are successful, false otherwise.
     */
    public function delete_rows( $ids ) {
        foreach ( $ids as $id ) {
            if ( ! $this->delete_row( $id ) ) {
                return false;
            }
        }

        return true;
    }

    /**
     * Retrieves an entry based on associative array of conditions.
     *
     * @param array $conditions Associative array of conditions.
     * @return object|null The object if found, otherwise null.
     */
    public function get_row( $conditions ) {
        $where_clause = [];
        $values = [];

        foreach ( $conditions as $key => $value ) {
            $where_clause[] = "$key = %s";
            $values[] = $value;
        }

        $where_clause = implode( ' AND ', $where_clause );

        $query = $this->db->prepare( "SELECT * FROM {$this->table_name} WHERE $where_clause", ...$values );

        return $this->db->get_row( $query );
    }

    /**
     * Retrieves multiple entries based on associative array of conditions.
     *
     * @param array $conditions Associative array of conditions.
     * @return array Array of objects if found, otherwise empty array.
     */
    public function get_rows( $conditions ) {
        $where_clause = [];
        $values = [];

        foreach ( $conditions as $key => $value ) {
            $where_clause[] = "$key = %s";
            $values[] = $value;
        }

        $where_clause = implode( ' AND ', $where_clause );

        $query = $this->db->prepare( "SELECT * FROM {$this->table_name} WHERE $where_clause", ...$values );
        
        return $this->db->get_results( $query );
    }

    /**
     * Get the default WordPress table prefix.
     *
     * @return string
     */
    public function get_wp_prefix() {
        return $this->db->prefix;
    }

    /**
     * Get the table prefix.
     *
     * @return string
     */
    public function get_prefix() {
        return $this->get_wp_prefix() . $this->prefix;
    }
}