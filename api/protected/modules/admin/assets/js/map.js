$(document).ready(function () {
    $('.form').find('.show-map').click(function() {
        var closest = $(this).closest('.form');
        var address = closest.find('#address').val();
        var not_found = closest.find('#not_found');
        var inputLat = closest.find("#lat");
        var inputLon = closest.find("#long");
        if(address == ""){
            not_found.show();
            inputLat.val('');
            inputLon.val('');
        }else{
            var map = closest.find('#map_canvas');
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode( { 'address': address}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                  var dat = results[0].geometry.location ;
                  not_found.hide();
                  map.show(); 
                  var lat = results[0].geometry.location.lat();
                  var lon = results[0].geometry.location.lng();
                  inputLat.val(lat);
                  inputLon.val(lon);
                  initialize(lat, lon) ;
                }else {
                    not_found.show();
                    map.hide();
                    inputLat.val('');
                    inputLon.val('');
                }
            });
        }
    })
    
});
