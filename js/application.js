$( document ).ready(function() {
    
    $('.matches').click(function () {
      allMatches()
    });
    
});

function allMatches(){
    $.ajax({
        type: 'GET',
        url: apiURL+'/user/status',
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
        success: function(data){
            console.log( data );
            window.location.reload();
        }
    });
}
