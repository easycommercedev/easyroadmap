jQuery(
	function ($) {

		$( '.taxonomy-task_stage #the-list' ).sortable(
			{
				cursor: 'grabbing',
				axis: 'y',
				containment: '#the-list',
				update: function (event, ui) {
					$.ajax(
						{
							url: `${EASYROADMAP.api_base} / stages / order`,
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
		);
	}
);
