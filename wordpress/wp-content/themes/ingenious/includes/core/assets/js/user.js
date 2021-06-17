"use strict";
jQuery(document).ready(function () {
	
	// INSERT IMAGE LINK
	
	jQuery(document).on('click', '.insert-avatar, .avatar-container img', function(event) {
		var frame,
		metaBox = jQuery(this).closest('.img-wrapper.avatar'),
		addAvatar = jQuery(this),
		delAvatar = metaBox.find( '.delete-avatar'),
		AvatarContainer = metaBox.find( '.avatar-container'),
		AvatarSrc = metaBox.find( 'input[data-key="img"]' ),
		AvatarId = metaBox.find( 'input[data-key="img-id"]' );

		event.preventDefault();

		if ( frame ) {
		  frame.open();
		  return;
		}

	    frame = wp.media({
			title: 'Select or Upload Avatar from Media',
			button: {
			text: 'Select user Avatar'
			},
			multiple: false,
			library: { type: 'image' },
	    });

	    // When an image is selected in the media frame...
    	frame.on( 'select', function() { // or insert
			// Get media attachment details from the frame state
			var attachment = frame.state().get('selection').first().toJSON();

			// Send the attachment URL to our custom image input field.
			AvatarContainer.html( '<img src="'+attachment.url+'" alt=""/>' );

			// Send the attachment id to our hidden input
			AvatarSrc.val( attachment.url );
			AvatarId.val( attachment.id );

			// Hide the add image link
			addAvatar.addClass( 'hidden' );

			// Unhide the remove image link
			delAvatar.removeClass( 'hidden' );
	    });

	    // Finally, open the modal on click
	    frame.open();
	});


  	// DELETE IMAGE LINK
	jQuery( '.delete-avatar').on( 'click', function( event ){
		var frame,
		metaBox = jQuery(this).closest('.img-wrapper.avatar'),
		addAvatar = metaBox.find('.insert-avatar'),
		delAvatar = jQuery(this),
		AvatarContainer = metaBox.find( '.avatar-container'),
		AvatarSrc = metaBox.find( 'input[data-key="img"]' ),
		AvatarId = metaBox.find( 'input[data-key="img-id"]' );
				
		event.preventDefault();

		// Clear out the preview image
		AvatarContainer.html( '' );

		// Un-hide the add image link
		addAvatar.removeClass( 'hidden' );

		// Hide the delete image link
		delAvatar.addClass( 'hidden' );

		// Delete the image id from the hidden input
		AvatarSrc.val('');
		AvatarId.val('');
	});

});