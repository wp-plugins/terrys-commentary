( function( window, $, undefined ) {
	'use strict';
	
	// Tooltip object
	var tooltip = $( '<div id="tooltip"></div>' ); /* Construct a universal tooltip */
	tooltip.target = false; /* current target of tooltip, must be jquery object */
	tooltip.open = function() {
		// this is the $(tooltip)
		
		var target = this.data('target');
		if ( !target ) { return; }

		if( $( window ).width() < this.outerWidth() * 1.5 ) {
			this.css( 'max-width', $( window ).width() / 2 );
		} else {
			this.css( 'max-width', 340 );
		}

		var pos_left = target.offset().left + ( target.outerWidth() / 2 ) - ( this.outerWidth() / 2 ),
		    pos_top  = target.offset().top - this.outerHeight() - 20;
		if( pos_left < 0 ) {
			pos_left = target.offset().left + target.outerWidth() / 2 - 20;
			this.addClass( 'left' );
		} else {
			this.removeClass( 'left' );
		}

		if( pos_left + tooltip.outerWidth() > $( window ).width() ) {
			pos_left = target.offset().left - this.outerWidth() + target.outerWidth() / 2 + 20;
			this.addClass( 'right' );
		} else {
			this.removeClass( 'right' );
		}

		if( pos_top < 0 ) {
			pos_top  = target.offset().top + target.outerHeight();
			this.addClass( 'top' );
		} else {
			this.removeClass( 'top' );
		}

		this.css( { left: pos_left, top: pos_top } )
		    .animate( { top: '+=10', opacity: 1 }, 50 );
	};
	tooltip.close = function() {
		// this is the $(tooltip)
		
		var target = this.data( 'target' );
		// animate closing and remove from DOM
		this.animate( { top: '-=10', opacity: 0 }, 50, function() {
			var self = $(this);
			// if during animation we've switched targets, then don't close things out
			if ( target == self.data('target') ) {
				self.detach();
				// clear out target
				self.data('target',false);
			}
		});
	};
	// clicking on tooltip is equivalent to leaving target
	tooltip.on( 'click', function() {
		self = $(this);
		if ( self.target ) {
			self.target.trigger('mouseleave');
		}
	});

	var targetMouseEnter = function() {
		// this is the target (no jquery)
		var self = $(this),
			tip  = self.attr('title');

		if ( !tip || tip === '' ) {
			return false;
		}
		// save title attr because we're going to crush it to prevent default behaviro
		self.data( 'tip', tip )
		    .removeAttr( 'title' );

		tooltip.data( 'target', self ) // store pointer back to self
		       .css( 'opacity', 0 )    // start transparent for animation
		       .html( tip )            // insert content
		       .appendTo( 'body' );    // inssrt into dom (changes context of chaining)
		tooltip.open();                // render
	};
	var targetMouseLeave = function() {
		// this is the target (no jquery)
		var self = $(this),
		    tip = self.data('tip');

		// restore attribute
		if ( tip ) {
			self.attr( 'title', tip );
		}
		tooltip.close();
	};

	/* onReady: Add the tip. */
	$( function() {
		$( window ).resize( function() { tooltip.open(); } );

		$( '[rel~=tooltip]' ).on( 'mouseenter', targetMouseEnter )
		                     .on( 'mouseleave', targetMouseLeave );
		// backward compatiblility on my blog
		$( '[class~=commentary]').on( 'mouseenter', targetMouseEnter )
		                         .on( 'mouseleave', targetMouseLeave );
	});

} )( window, window.jQuery );