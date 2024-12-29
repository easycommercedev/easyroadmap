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
            const itemId = ui.item.attr('id');
            const parentId = ui.item.parent().attr('id');
            ui.item.removeClass("dragging"); // Remove tilt effect
            console.log(`Item ID: ${itemId} moved to Parent ID: ${parentId}`);
        }
    }).disableSelection();


    // Fetch data and open modal
    $(".kanban-item").on("click", function () {
        const itemId = $(this).attr('id');
        $.ajax({
            url: `https://stg.my.easycommerce.dev/wp-json/easysuite/v1/addons/`,
            method: "GET",
            success: function (response) {
                $("#modal-title").text(response.data.message || "Task Title");
                $("#modal-description").text("Task description loaded via API.");
                $("#upvote-count").text(10); // Example count
                $("#downvote-count").text(3); // Example count
                $("#comments-list").empty().append("<li>Sample comment</li>");
                $("#modal-overlay").fadeIn();
                $("#modal").fadeIn();
            },
            error: function () {
                alert("Error loading data.");
            }
        });
    });

    // Upvote button
    $("#upvote").on("click", function () {
        $.ajax({
            url: `https://example.com/api/upvote`, // Replace with your API endpoint
            method: "POST",
            success: function (response) {
                const currentCount = parseInt($("#upvote-count").text());
                $("#upvote-count").text(currentCount + 1);
            }
        });
    });

    // Downvote button
    $("#downvote").on("click", function () {
        $.ajax({
            url: `https://example.com/api/downvote`, // Replace with your API endpoint
            method: "POST",
            success: function (response) {
                const currentCount = parseInt($("#downvote-count").text());
                $("#downvote-count").text(currentCount + 1);
            }
        });
    });

    // Close modal
    $("#close-modal, #modal-overlay").on("click", function () {
        $("#modal, #modal-overlay").fadeOut();
    });

    // Add comment
    $("#add-comment").on("click", function () {
        const comment = $("#comment-input").val();
        if (comment.trim()) {
            $("#comments-list").append(`<li>${comment}</li>`);
            $("#comment-input").val("");
        }
    });
});