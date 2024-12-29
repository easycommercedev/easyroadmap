<?php
use EasyRoadmap\Helper\Utility;

$tasks = $args['tasks'];

?>
<div class="flex justify-center space-x-4 mt-10 kanban-columns">
    <?php foreach ( $tasks as $slug => $column ) : ?>
        <div class="kanban-column" id="<?php echo $slug . '-' . $column['id']; ?>">
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