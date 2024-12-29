jQuery(function ($) {
    // Enable sortable functionality
    $(".er-kanban-column").sortable({
        connectWith: ".er-kanban-column", // Allow movement between columns
        placeholder: "er-ui-state-highlight", // Highlight the drop area
        delay: 150, // Add a delay to prevent click-drag conflicts
        start: function (event, ui) {
            ui.placeholder.height(ui.item.height());
            ui.item.addClass("er-dragging"); // Add tilt effect
        },
        stop: function (event, ui) {
            const taskId = ui.item.attr("id").replace("er-task-", ""); // Extract task ID
            const columnId = ui.item.parent().attr("id").split("er-stage-")[1]; // Extract column ID
            ui.item.removeClass("er-dragging"); // Remove tilt effect

            // AJAX call to update the task's new column
            $.ajax({
                url: `${EASYROADMAP.api_base}/tasks/${taskId}/move`, // Replace with your API endpoint
                method: "POST",
                data: {
                    stage: columnId,
                },
                success: function (response) {
                    console.log(response);
                },
                error: function (error) {
                    console.error(error);
                }
            });

            $.ajax({
                url: `${EASYROADMAP.api_base}/tasks/order`,
                method: "POST",
                data: {
                    order: $(this).sortable('toArray', {attribute: 'id'})
                },
                success: function (response) {
                    console.log(response);
                },
                error: function (error) {
                    console.error(error);
                }
            });
        }
    }).disableSelection();

    // Open modal and fetch task data
    $(".er-kanban-item").on("click", function () {
        const taskId = $(this).attr("id").replace("er-task-", ""); // Extract task ID
        $("#er-modal-overlay").fadeIn();
        $("#er-modal-id").val(taskId);
        $("#er-modal").fadeIn();

        // Fetch task details via AJAX
        $.ajax({
            url: `${EASYROADMAP.api_base}/tasks/${taskId}`, // Replace with your API endpoint
            method: "GET",
            success: function (response) {
                $("#er-modal-title").text(response.data.task.title);
                $("#er-modal-description").html(response.data.task.description);
                $("#er-upvote-count").text(response.data.task.upvotes || 0);
                $("#er-downvote-count").text(response.data.task.downvotes || 0);

                // Populate comments (if needed in the future)
                // $("#er-comments-list").empty();
                // if (response.comments && response.comments.length > 0) {
                //     response.comments.forEach(comment => {
                //         $("#er-comments-list").append(`<li>${comment}</li>`);
                //     });
                // }
            },
            error: function () {
                console.error("Error fetching task data.");
            }
        });
    });

    // Handle upvote/downvote
    $(".er-vote-btn").on("click", function () {
        const voteBtn = $(this);
        const taskId = $("#er-modal-id").val(); // Retrieve task ID from modal
        const type = voteBtn.data("type"); // Extract button type (upvote/downvote)
        $.ajax({
            url: `${EASYROADMAP.api_base}/tasks/${taskId}/vote`, // Replace with your API endpoint
            method: "POST",
            data: {
                type: type,
            },
            success: function (response) {
                $(".er-vote-count", voteBtn).text(response.data.votes);
            },
            error: function () {
                console.error("Error processing vote.");
            }
        });
    });

    // Close modal when clicking outside the modal content
    $("#er-modal-overlay").on("click", function (e) {
        if (e.target.id === "er-modal-overlay") { // Check if the clicked area is the overlay
            $("#er-modal, #er-modal-overlay").fadeOut();
        }
    });

    // Close modal when clicking the "×" button
    $("#er-close-modal").on("click", function () {
        $("#er-modal, #er-modal-overlay").fadeOut();
    });

    // Add comment (if enabled in the future)
    $("#er-add-comment").on("click", function () {
        const comment = $("#er-comment-input").val();
        const taskId = $("#er-modal-id").val(); // Retrieve task ID from modal
        if (comment.trim()) {
            $.ajax({
                url: `${EASYROADMAP.api_base}/tasks/${taskId}/comments`, // Replace with your API endpoint
                method: "POST",
                data: { comment },
                success: function () {
                    $("#er-comments-list").append(`<li>${comment}</li>`);
                    $("#er-comment-input").val(""); // Clear the input field
                },
                error: function () {
                    console.error("Error adding comment.");
                }
            });
        }
    });
});
