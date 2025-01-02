const easyroadmap_modal = ( show = true ) => {
	const modal         = document.getElementById( 'easyroadmap-modal' );
	if ( show ) {
		modal.style.display = '';
	} else {
		modal.style.display = 'none';
	}
}