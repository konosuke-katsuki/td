const checkboxes$ = jQuery( ".daily-task-status-checkbox" );
const cover$      = jQuery( ".cover" );

checkboxes$.on( "click", function() {

  cover$.css( { display : "flex" } );

  const settings = {
    url    : configs.url,
    data   : { test : 100 },
    action : configs.action,
    nonce  : configs.nonce
  };

  // jQuery.post( "http://localhost/td2/wp-admin/admin-ajax.php", settings )
  // .done( ( data ) => { console.log( "成功" ) } )
  // .fail( ( data ) => { console.log( "失敗" ) } )
  // .always( ( data ) => { console.log( "test" ) } );

  jQuery.post( configs.url, settings )
  .done( function( response ) { console.log( response ); } )
  .fail( function( response ) { console.log( response ) } )
  .always( function( response ) { console.log( response ) } );
} );
