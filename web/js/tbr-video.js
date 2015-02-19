
 $( "#clickme" ).click(function() {
  $( "#book" ).hide( "slow", function() {
    alert( "Animation complete." );
  });
});                      
$( "#hider" ).click(function() {
  $( "span:last-child" ).hide( "fast", function() {
    // Use arguments.callee so we don't need a named function
    $( this ).prev().hide( "fast", arguments.callee );
  });
});
$( "#shower" ).click(function() {
  $( "span" ).show( 2000 );
});
 