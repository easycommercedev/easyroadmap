<?php
use EasyRoadmap\Helper\Utility;

$tasks = $args['tasks'] ?? [];

?>
<div class="er-flex er-justify-center er-space-x-4 er-mt-10 er-kanban-columns">
    <?php foreach ( $tasks as $slug => $column ) : ?>
        <div class="er-kanban-column" id="er-stage-<?php echo $column['id']; ?>" style="background: <?php echo get_term_meta( $column['id'], 'color', true ); ?>;">
            <h3 class="er-text-xl er-font-bold er-mb-4"><?php echo $column['name']; ?></h3>
            <?php if ( ! empty( $column['tasks'] ) ) : ?>
                <?php foreach ( $column['tasks'] as $task_id => $task_name): ?>
                    <div class="er-kanban-item" id="er-task-<?php echo $task_id; ?>"><?php echo $task_name; ?></div>
                <?php endforeach; ?>
            <?php else: ?>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

<!-- Modal Overlay -->
<div class="er-modal-overlay er-hidden" id="er-modal-overlay">
    <!-- Modal -->
    <div class="er-modal er-hidden" id="er-modal">
        <!-- Close Button -->
        <span class="er-close-modal" id="er-close-modal">&times;</span>

        <!-- Modal Content -->
        <div id="er-modal-content" class="er-text-gray-700">
            <!-- Task Title -->
            <input type="hidden" id="er-modal-id">
            <h2 id="er-modal-title" class="er-text-2xl er-font-bold er-mb-4">Task Title</h2>

            <!-- Upvote/Downvote Section -->
            <div class="er-flex er-items-center er-space-x-4 er-mb-4">
                <span id="er-upvote" data-type="upvote" class="er-vote-btn er-flex er-items-center er-space-x-2">
                    👍
                    <span class="er-vote-count" id="er-upvote-count">0</span>
                </span>
                <span id="er-downvote" data-type="downvote" class="er-vote-btn er-flex er-items-center er-space-x-2">
                     👎
                    <span class="er-vote-count" id="er-downvote-count">0</span>
                </span>
            </div>

            <!-- Task Description -->
            <div id="er-modal-description" class="er-mb-4">Task description goes here.</div>

            <!-- Comments Section -->
            <!-- 
            <div id="er-comments-section" class="er-border-t er-pt-4">
                <h3 class="er-text-lg er-font-bold er-mb-2">Comments</h3>
                <ul id="er-comments-list" class="er-mb-4">
                    Comments will be appended here dynamically
                </ul>
                <textarea id="er-comment-input" class="er-w-full er-border er-rounded er-p-2 er-mb-2" rows="3" placeholder="Add a comment..."></textarea>
                <button id="er-add-comment" class="er-bg-blue-500 er-text-white er-px-4 er-py-2 er-rounded">Add Comment</button>
            </div>
             -->
        </div>
    </div>
</div>