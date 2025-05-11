<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$tasks = $args['tasks'] ?? array();

?>
<div class="er-flex er-justify-center er-space-x-4 er-mt-10 er-kanban-columns">
	<?php foreach ( $tasks as $slug => $column ) : ?>
		<div class="er-kanban-column" id="er-stage-<?php esc_attr_e( $column['id'] ); ?>" style="background: <?php esc_attr_e( get_term_meta( $column['id'], 'color', true ) ); ?>;">
			<h3 class="er-text-xl er-font-bold er-mb-4"><?php esc_attr_e( $column['name'] ); ?></h3>
			<?php if ( ! empty( $column['tasks'] ) ) : ?>
				<?php foreach ( $column['tasks'] as $task_id => $task_name ) : ?>
					<div class="er-kanban-item" id="er-task-<?php esc_attr_e( $task_id ); ?>"><?php esc_html_e( $task_name ); ?></div>
				<?php endforeach; ?>
			<?php else : ?>
			<?php endif; ?>
		</div>
	<?php endforeach; ?>
</div>

<div class="er-modal-overlay er-hidden" id="er-modal-overlay">
	<div class="er-modal er-hidden" id="er-modal">
		<span class="er-close-modal" id="er-close-modal">&times;</span>

		<div id="er-modal-content" class="er-text-gray-700">
			<input type="hidden" id="er-modal-id">
			<h2 id="er-modal-title" class="er-text-2xl er-font-bold er-mb-4">Task Title</h2>

			<div class="er-flex er-items-center er-space-x-2 er-mb-4">
				<span id="er-upvote" data-type="upvote" class="er-vote-btn er-flex er-items-center er-space-x-2">
					👍 <?php esc_html_e( 'Upvote', 'easyroadmap' ); ?>
					(<span class="er-vote-count" id="er-upvote-count">0</span>)
				</span>
				<span id="er-downvote" data-type="downvote" class="er-vote-btn er-flex er-items-center er-space-x-2">
					👎 <?php esc_html_e( 'Downvote', 'easyroadmap' ); ?>
					(<span class="er-vote-count" id="er-downvote-count">0</span>)
				</span>
			</div>

			<div id="er-modal-description" class="er-mb-4">Loading...</div>
		</div>
	</div>
</div>