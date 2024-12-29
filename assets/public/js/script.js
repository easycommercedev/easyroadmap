jQuery(function ($) {
    // Enable sortable functionality
    $(".kanban-column").sortable({
        connectWith: ".kanban-column", // Allow movement between columns
        placeholder: "ui-state-highlight", // Highlight the drop area
        delay: 150, // Add a delay to prevent click-drag conflicts
        start: function (event, ui) {
            ui.placeholder.height(ui.item.height());
            ui.item.addClass("dragging"); // Add tilt effect
        },
        stop: function (event, ui) {
            const taskId = ui.item.attr("id").replace("task-", ""); // Extract task ID
            const columnId = ui.item.parent().attr("id").split("-")[1]; // Extract column ID
            ui.item.removeClass("dragging"); // Remove tilt effect
            console.log(`Task ID: ${taskId} moved to Column ID: ${columnId}`);

            // AJAX call to update the task's new column
            $.ajax({
                url: `/path-to-update-api`, // Replace with your API endpoint
                method: "POST",
                data: {
                    task_id: taskId,
                    column_id: columnId,
                },
                success: function (response) {
                    console.log("Task updated successfully:", response);
                },
                error: function (error) {
                    console.error("Error updating task:", error);
                }
            });
        }
    }).disableSelection();

    // Open modal and fetch task data
    $(".kanban-item").on("click", function () {
        const taskId = $(this).attr("id").replace("task-", ""); // Extract task ID
        $("#modal-overlay").fadeIn();
        $("#modal").fadeIn();

        // Fetch task details via AJAX
        $.ajax({
            url: `/path-to-fetch-task/${taskId}`, // Replace with your API endpoint
            method: "GET",
            success: function (response) {
                $("#modal-title").text(response.title || `Task ${taskId}`);
                $("#modal-description").text(response.description || "No description available.");
                $("#upvote-count").text(response.upvotes || 0);
                $("#downvote-count").text(response.downvotes || 0);

                // Populate comments
                $("#comments-list").empty();
                if (response.comments && response.comments.length > 0) {
                    response.comments.forEach(comment => {
                        $("#comments-list").append(`<li>${comment}</li>`);
                    });
                }
            },
            error: function () {
                console.error("Error fetching task data.");
            }
        });
    });

    // Handle upvote
    $("#upvote").on("click", function () {
        const taskId = $("#modal-title").data("task-id"); // Retrieve task ID from modal
        $.ajax({
            url: `/path-to-upvote/${taskId}`, // Replace with your API endpoint
            method: "POST",
            success: function () {
                const currentCount = parseInt($("#upvote-count").text());
                $("#upvote-count").text(currentCount + 1);
            },
            error: function () {
                console.error("Error processing upvote.");
            }
        });
    });

    // Handle downvote
    $("#downvote").on("click", function () {
        const taskId = $("#modal-title").data("task-id"); // Retrieve task ID from modal
        $.ajax({
            url: `/path-to-downvote/${taskId}`, // Replace with your API endpoint
            method: "POST",
            success: function () {
                const currentCount = parseInt($("#downvote-count").text());
                $("#downvote-count").text(currentCount + 1);
            },
            error: function () {
                console.error("Error processing downvote.");
            }
        });
    });

    // Close modal when clicking outside the modal content
    $("#modal-overlay").on("click", function (e) {
        if (e.target.id === "modal-overlay") { // Check if the clicked area is the overlay
            $("#modal, #modal-overlay").fadeOut();
        }
    });

    // Close modal when clicking the "×" button
    $("#close-modal").on("click", function () {
        $("#modal, #modal-overlay").fadeOut();
    });

    // Add comment
    $("#add-comment").on("click", function () {
        const comment = $("#comment-input").val();
        const taskId = $("#modal-title").data("task-id"); // Retrieve task ID from modal
        if (comment.trim()) {
            $.ajax({
                url: `/path-to-add-comment/${taskId}`, // Replace with your API endpoint
                method: "POST",
                data: { comment },
                success: function () {
                    $("#comments-list").append(`<li>${comment}</li>`);
                    $("#comment-input").val(""); // Clear the input field
                },
                error: function () {
                    console.error("Error adding comment.");
                }
            });
        }
    });
});