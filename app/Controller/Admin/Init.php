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
		$this->action( 'task_stage_add_form_fields', [ $this, 'show_add_taxo_fields' ] );
		$this->action( 'created_term', [ $this, 'save_add_taxo_fields' ], 10, 3 );
		$this->action( 'task_stage_edit_form', [ $this, 'show_edit_taxo_fields' ] );
		$this->action( 'edited_task_stage', [ $this, 'save_edit_taxo_fields' ], 10, 2 );
	}

	public function show_add_taxo_fields() {

		$color = easyroadmap_get_random_color();

		?>
		<div class="form-field term-color-wrap">
			<label for="tag-color"><?php _e( 'Color', 'easyroadmap' ); ?></label>
			<input name="color" id="tag-color" type="color" value="<?php echo esc_attr( $color ); ?>" size="40" aria-describedby="color-description">
			<p id="color-description"><?php _e( 'The Kanban column color', 'easyroadmap' ); ?></p>
		</div>
		<?php
	}

	public function save_add_taxo_fields( $term_id, $tt_id, $taxonomy ) {
		if ( $taxonomy === 'task_stage' ) {
		    update_term_meta( $term_id, 'color', $this->sanitize( $_POST['color'] ) );
		}
	}

	public function show_edit_taxo_fields( $term ) {
		
		if( empty( $color = get_term_meta( $term->term_id, 'color', true ) ) ) {
			$color = easyroadmap_get_random_color();
		}

		?>
		<table class="form-table" role="presentation">
			<tbody>
				<tr class="form-field form-required term-name-wrap">
					<th scope="row">
						<label for="color"><?php _e( 'Color', 'easyroadmap' ); ?></label>
					</th>
					<td>
						<input name="color" id="color" type="color" value="<?php echo esc_attr( $color ); ?>" size="40" aria-required="true" aria-describedby="color-description">
						<p class="description" id="color-description"><?php _e( 'The Kanban column color', 'easyroadmap' ); ?></p>
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}

	public function save_taxo_fields( $term_id, $tt_id ) {
	    if ( isset( $_POST['color'] ) ) {
	        update_term_meta( $term_id, 'color', $this->sanitize( $_POST['color'] ) );
	    }
	}

}