<?php
namespace EasyRoadmap\Controller\Admin;

defined( 'ABSPATH' ) || exit;

use EasyRoadmap\Trait\Hook;
use EasyRoadmap\Trait\Asset;
use EasyRoadmap\Trait\Cleaner;
use EasyRoadmap\Helper\Utility;

class Init {

	use Hook;
	use Asset;
	use Cleaner;

	/**
	 * Constructor to add all hooks.
	 */
	public function __construct() {
		$this->action( 'task_stage_add_form_fields', array( $this, 'show_add_taxo_fields' ) );
		$this->action( 'created_term', array( $this, 'save_add_taxo_fields' ), 10, 3 );
		$this->action( 'task_stage_edit_form', array( $this, 'show_edit_taxo_fields' ) );
		$this->action( 'edited_task_stage', array( $this, 'save_edit_taxo_fields' ), 10, 2 );
		$this->filter( 'manage_edit-task_stage_columns', array( $this, 'add_color_column' ) );
		$this->filter( 'manage_task_stage_custom_column', array( $this, 'populate_color_column' ), 10, 3 );
	}

	public function show_add_taxo_fields() {
		$color = easyroadmap_get_random_color();
		?>
		<div class="form-field term-color-wrap">
			<label for="tag-color"><?php esc_html_e( 'Color', 'easyroadmap' ); ?></label>
			<input name="color" id="tag-color" type="color" value="<?php echo esc_attr( $color ); ?>" size="40" aria-describedby="color-description">
			<p id="color-description"><?php esc_html_e( 'The Kanban column color', 'easyroadmap' ); ?></p>
		</div>
		<?php
	}

	public function save_add_taxo_fields( $term_id, $tt_id, $taxonomy ) {
		if ( $taxonomy !== 'task_stage' ) {
			return;
		}

		if (
			! isset( $_POST['_wpnonce_add-tag'] ) ||
			! wp_verify_nonce( $this->sanitize( wp_unslash( $_POST['_wpnonce_add-tag'] ) ), 'add-tag' )
		) {
			wp_die( 'Nonce verification failed' );
		}

		if ( isset( $_POST['color'] ) ) {
			update_term_meta( $term_id, 'color', $this->sanitize( $_POST['color'] ) );
		}
	}

	public function show_edit_taxo_fields( $term ) {
		if ( empty( $color = get_term_meta( $term->term_id, 'color', true ) ) ) {
			$color = easyroadmap_get_random_color();
		}
		?>
		<table class="form-table" role="presentation">
			<tbody>
				<tr class="form-field form-required term-name-wrap">
					<th scope="row">
						<label for="color"><?php esc_html_e( 'Color', 'easyroadmap' ); ?></label>
					</th>
					<td>
						<input name="color" id="color" type="color" value="<?php echo esc_attr( $color ); ?>" size="40" aria-required="true" aria-describedby="color-description">
						<p class="description" id="color-description"><?php esc_html_e( 'The Kanban column color', 'easyroadmap' ); ?></p>
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}

	public function save_edit_taxo_fields( $term_id, $tt_id ) {
		if (
			! isset( $_POST['_wpnonce'] ) ||
			! wp_verify_nonce( $this->sanitize( wp_unslash( $_POST['_wpnonce'] ) ), 'update-tag_' . $term_id )
		) {
			wp_die( 'Nonce verification failed' );
		}

		if ( isset( $_POST['color'] ) ) {
			update_term_meta( $term_id, 'color', $this->sanitize( $_POST['color'] ) );
		}
	}

	/**
	 * Add custom column to the taxonomy table.
	 */
	public function add_color_column( $columns ) {

		$start   = array_slice( $columns, 0, 1, true );
		$end     = array_slice( $columns, 1, null, true );
		$columns = $start + array( 'color' => '' ) + $end;

		return $columns;
	}


	/**
	 * Populate the custom column with the term's color meta.
	 */
	public function populate_color_column( $content, $column_name, $term_id ) {

		if ( 'color' === $column_name ) {
			$color   = get_term_meta( $term_id, 'color', true );
			$content = $color ? sprintf( '<div style="width: 30px; height: 30px; background-color: %s; border-radius: 4px;"></div>', esc_attr( $color ) ) : '';
		}

		return $content;
	}
}
