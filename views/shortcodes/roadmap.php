<?php
use EasyRoadmap\Helper\Utility;

$tasks = $args['tasks'] ?? [];

?>
<div class="flex justify-center space-x-4 mt-10 kanban-columns">
    <?php foreach ( $tasks as $slug => $column ) : ?>
        <div class="kanban-column" id="<?php echo 'stage-' . $column['id']; ?>">
            <h3 class="text-xl font-bold mb-4"><?php echo $column['name']; ?></h3>
            <?php if ( ! empty( $column['tasks'] ) ) : ?>
                <?php foreach ( $column['tasks'] as $task_id => $task_name): ?>
                    <div class="kanban-item" id="task-<?php echo $task_id; ?>"><?php echo $task_name; ?></div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Placeholder for empty column -->
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

<!-- Modal Overlay -->
<div class="modal-overlay hidden" id="modal-overlay">
    <!-- Modal -->
    <div class="modal hidden" id="modal">
        <!-- Close Button -->
        <span class="close-modal" id="close-modal">&times;</span>

        <!-- Modal Content -->
        <div id="modal-content" class="text-gray-700">
            <!-- Task Title -->
            <input type="hidden" id="modal-id">
            <h2 id="modal-title" class="text-2xl font-bold mb-4">Task Title</h2>

            <!-- Task Description -->
            <p id="modal-description" class="mb-4">Task description goes here.</p>

            <!-- Upvote/Downvote Section -->
            <div class="flex items-center space-x-4 mb-4">
                <button id="upvote" class="vote-btn flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="green">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                    </svg>
                    <span class="vote-count" id="upvote-count">0</span>
                </button>
                <button id="downvote" class="vote-btn flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="red">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    <span class="vote-count" id="downvote-count">0</span>
                </button>
            </div>

            <!-- Comments Section -->
            <!-- 
            <div id="comments-section" class="border-t pt-4">
                <h3 class="text-lg font-bold mb-2">Comments</h3>
                <ul id="comments-list" class="mb-4">
                    Comments will be appended here dynamically
                </ul>
                <textarea id="comment-input" class="w-full border rounded p-2 mb-2" rows="3" placeholder="Add a comment..."></textarea>
                <button id="add-comment" class="bg-blue-500 text-white px-4 py-2 rounded">Add Comment</button>
            </div>
             -->

        </div>
    </div>
</div>