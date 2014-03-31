$( document ).ready(function() {
    
    $('.matches').click(function () {
      allMatches2()
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

function allMatches2(){
    $.ajax({
        type: 'POST',
        url: apiURL+'/user',
        dataType: "json", // data type of response
        success: function(data, textStatus, jqXHR){
            console.log( data );
            console.log( textStatus );
            console.log( jqXHR );
            window.location.reload();
        }
    });
}
