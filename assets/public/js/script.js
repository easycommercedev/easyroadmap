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
            const columnId = ui.item.parent().attr("id").split("stage-")[1]; // Extract column ID
            ui.item.removeClass("dragging"); // Remove tilt effect

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
        }
    }).disableSelection();

    // Open modal and fetch task data
    $(".kanban-item").on("click", function () {
        const taskId = $(this).attr("id").replace("task-", ""); // Extract task ID
        $("#modal-overlay").fadeIn();
        $("#modal-id").val(taskId);
        $("#modal").fadeIn();

        // Fetch task details via AJAX
        $.ajax({
            url: `${EASYROADMAP.api_base}/tasks/${taskId}`, // Replace with your API endpoint
            method: "GET",
            success: function (response) {
                $("#modal-title").text(response.data.task.title);
                $("#modal-description").html(response.data.task.description);
                $("#upvote-count").text(response.data.task.upvotes || 0);
                $("#downvote-count").text(response.data.task.downvotes || 0);

                // Populate comments
                // $("#comments-list").empty();
                // if (response.comments && response.comments.length > 0) {
                //     response.comments.forEach(comment => {
                //         $("#comments-list").append(`<li>${comment}</li>`);
                //     });
                // }
            },
            error: function () {
                console.error("Error fetching task data.");
            }
        });
    });

    // Handle upvote
    $(".vote-btn").on("click", function () {
        const voteBtn = $(this);
        const taskId = $("#modal-id").val(); // Retrieve task ID from modal
        const type = voteBtn.attr('id')
        $.ajax({
            url: `${EASYROADMAP.api_base}/tasks/${taskId}/vote`, // Replace with your API endpoint
            method: "POST",
            data: {
                type: type,
            },
            success: function (response) {
                console.log(response.data.votes);
                $(".vote-count",voteBtn).text(response.data.votes);
            },
            error: function () {
                console.error("Error processing upvote.");
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