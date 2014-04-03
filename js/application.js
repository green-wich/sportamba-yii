$( document ).ready(function() {
    
    $('.matches').click(function () {
      allMatches()
    });
    
});

function allMatches(){
    var jsn= JSON.stringify({
    "id":"1", 
    "name":"wert", 
    });

    var dt='{"team": '+jsn+'}';
    
    console.log( dt );
    
    $.ajax({
        type: 'PUT',
        url: apiURL+'/usermatch/1',
        data: dt,
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
