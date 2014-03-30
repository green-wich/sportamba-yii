$( document ).ready(function() {
    
    $('.matches').click(function () {
      allMatches()
    });
    
});

function allMatches(){
    $.ajax({
        type: 'GET',
        url: apiURL+'/match',
        dataType: "json", // data type of response
        success: function(data){
            console.log( data );
        }
    });
}
