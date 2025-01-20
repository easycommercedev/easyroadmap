jQuery(
	function ($) {

		$( ".task-editor .er-kanban-column" ).sortable(
			{
				items: ".er-kanban-item", // Restrict sorting to the kanban items only
				connectWith: ".er-kanban-column",
				placeholder: "er-ui-state-highlight",
				delay: 150,
				start: function (event, ui) {
					ui.placeholder.height( ui.item.height() );
					ui.item.addClass( "er-dragging" );
				},
				stop: function (event, ui) {
					const taskId   = ui.item.attr( "id" ).replace( "er-task-", "" );
					const columnId = ui.item.parent().attr( "id" ).split( "er-stage-" )[1];
					ui.item.removeClass( "er-dragging" );

					// AJAX call to update the task's new column
					$.ajax(
						{
							url: `${EASYROADMAP.api_base}/tasks/${taskId}/move`,
							method: "POST",
							data: {
								stage: columnId,
							},
							success: function (response) {
								console.log( response );
							},
							error: function (error) {
								console.error( error );
							}
						}
					);

					$.ajax(
						{
							url: `${EASYROADMAP.api_base}/tasks/order`,
							method: "POST",
							data: {
								order: $( this ).sortable( 'toArray', {attribute: 'id'} )
							},
							success: function (response) {
								console.log( response );
							},
							error: function (error) {
								console.error( error );
							}
						}
					);
				}
			}
		).disableSelection();

		// Open modal and fetch task data
		$( ".er-kanban-item" ).on(
			"click",
			function () {
				const taskId = $( this ).attr( "id" ).replace( "er-task-", "" );
				$( "#er-modal-overlay" ).fadeIn();
				$( "#er-modal-id" ).val( taskId );
				$( "#er-modal" ).fadeIn();

				// Fetch task details via AJAX
				$.ajax(
					{
						url: `${EASYROADMAP.api_base}/tasks/${taskId}`,
						method: "GET",
						success: function (response) {
							$( "#er-modal-title" ).text( response.data.task.title );
							$( "#er-modal-description" ).html( response.data.task.description );
							$( "#er-upvote-count" ).text( response.data.task.upvotes || 0 );
							$( "#er-downvote-count" ).text( response.data.task.downvotes || 0 );
						},
						error: function () {
							console.error( "Error fetching task data." );
						}
					}
				);
			}
		);

		// Handle upvote/downvote
		$( ".er-vote-btn" ).on(
			"click",
			function () {
				const voteBtn = $( this );
				const taskId  = $( "#er-modal-id" ).val();
				const type    = voteBtn.data( "type" );
				$.ajax(
					{
						url: `${EASYROADMAP.api_base}/tasks/${taskId}/vote`,
						method: "POST",
						data: {
							type: type,
						},
						success: function (response) {
							$( ".er-vote-count", voteBtn ).text( response.data.votes );
						},
						error: function () {
							console.error( "Error processing vote." );
						}
					}
				);
			}
		);

		// Close modal when clicking outside the modal content
		$( "#er-modal-overlay" ).on(
			"click",
			function (e) {
				if (e.target.id === "er-modal-overlay") {
					$( "#er-modal, #er-modal-overlay" ).fadeOut();
				}
			}
		);

		// Close modal when clicking the "×" button
		$( "#er-close-modal" ).on(
			"click",
			function () {
				$( "#er-modal, #er-modal-overlay" ).fadeOut();
			}
		);

	}
);
