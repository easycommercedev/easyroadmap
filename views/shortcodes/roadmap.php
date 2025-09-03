<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$tasks = $args['tasks'] ?? array();
$show_stage_links = $args['show_stage_links'] ?? false;

?>
<div class="er-flex er-justify-center er-space-x-4 er-mt-10 er-kanban-columns">
	<?php foreach ( $tasks as $slug => $column ) : ?>
		<div class="er-kanban-column" id="er-stage-<?php echo esc_attr( $column['id'] ); ?>" style="background: <?php echo esc_attr( get_term_meta( $column['id'], 'color', true ) ); ?>;">
			
			<h3 class="er-text-xl er-font-bold er-mb-4">
				<?php if( $show_stage_links ): ?>
					<a href="<?php echo get_term_link( (int) $column['id'], 'task_stage' ); ?>"><?php echo esc_attr( $column['name'] ); ?></a>
				<?php else: ?>
					<?php echo esc_attr( $column['name'] ); ?>
				<?php endif; ?>

				<span><?php printf( '(%d)', count( $column['tasks'] ) ); ?></span>
			</h3>
		
			<?php if ( ! empty( $column['tasks'] ) ) : ?>
				<?php foreach ( $column['tasks'] as $task_id => $task_name ) : ?>
					<div class="er-kanban-item" id="er-task-<?php echo esc_attr( $task_id ); ?>"><?php echo esc_html( $task_name ); ?></div>
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
			<div class="er-flex er-space-x-2 er-items-center">
				<h2 id="er-modal-title" class="er-text-2xl er-font-bold er-mb-4">Task Title</h2>
				<a href="#" id="er-modal-link">
					<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path fill="currentColor" d="M9 3h8v8l-2-1V6.92l-5.6 5.59l-1.41-1.41L14.08 5H10zm3 12v-3l2-2v7H3V6h8L9 8H5v7z"/></svg>
				</a>
			</div>
			
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

			<div class="er-flex er-items-center er-space-x-2 er-mb-4">
				Stage:<span id="er-modal-stage"></span>
				| Products:<span id="er-modal-products"></span>
				| Tags:<span id="er-modal-tags"></span>
			</div>

			<div id="er-modal-description" class="er-mb-4">Loading...</div>
		</div>
	</div>
</div>