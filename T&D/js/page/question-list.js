const answer_button = jQuery( ".question-answer__title" );

answer_button.on( "click", function() {
  jQuery( this )
  .next()
  .fadeIn();
} );
