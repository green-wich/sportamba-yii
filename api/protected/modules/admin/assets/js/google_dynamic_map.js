// google_dynamic_map.js file

// Map Initialize function
function initialize(lat, lon) 
{
    var lat, lon; 
	// Make an instance of Geocoder
	geocoder = new google.maps.Geocoder();
	// Set static latitude, longitude value
       
	var latlng = new google.maps.LatLng( lat,lon );
	// Set map options
	var myOptions = {
		zoom: 16,
		center: latlng,
		panControl: false,
		zoomControl: false,
		scaleControl: false,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	}
	// Create map object with options
	map = new google.maps.Map(document.getElementById("map_canvas_post"), myOptions);
	// Create and set the marker
	marker = new google.maps.Marker({
		map: map,
		draggable:true,	
		position: latlng
	});
	
	// Register Custom "dragend" Event
	google.maps.event.addListener(marker, 'dragend', function() {
		
		// Get the Current position, where the pointer was dropped
		var point = marker.getPosition();
		// Center the map at given point
		map.panTo(point);
		// Update the textbox
		document.getElementById('lat').value=point.lat();
		document.getElementById('lng').value=point.lng();
	});
}
