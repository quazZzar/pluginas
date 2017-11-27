
function csvJSON(csv){
	
	var inquotes = getFromBetween.get(csv,'"','"');
	var arrayLength = inquotes.length;
	for (var i = 0; i < arrayLength; i++) {
		
		var fixed = inquotes[i].replace(',','');
		csv = csv.replace(inquotes[i], fixed);
		csv = csv.replace(/['"]+/g, '');
	}
		
	var lines=csv.split("\n");
	var result = [];
	var headers=lines[0].split(",");
	for(var i=0;i<lines.length-1;i++){
	  	var obj = {};
	  	var currentline=lines[i].split(",");
	  	for(var j=0;j<headers.length;j++){
		  	obj[headers[j]] = currentline[j]; 
	  	}
		result.push(obj);
  	}
  	return result;
}

var MapUrl = function(from, to, index, callback) {
	var geocoder = new google.maps.Geocoder();
	//create initial map.
    var cLatLng;
    var toLatLng;
    var mapCanvas = null;
    geocoder.geocode( { 'address': from}, function(results, status) {
	  	if (status == google.maps.GeocoderStatus.OK) {
	    		cLatLng = results[0].geometry.location;
			    geocoder.geocode( { 'address': to}, function(results, status) {
				  	if (status == google.maps.GeocoderStatus.OK) {
				    	toLatLng = results[0].geometry.location;
				    	var mapOpts = {
			        		zoom: 12,
			        		center: {lat: (cLatLng.lat() + toLatLng.lat())/2, lng: (cLatLng.lng() + toLatLng.lng())/2},
			        		mapTypeId: google.maps.MapTypeId.ROADMAP
			    		};
			    		mapCanvas = new google.maps.Map(document.getElementById("map_canvas"), mapOpts);
			    		var snapOpts = {
							map: mapCanvas
						};
						var snapShotControl = new SnapShotControl(snapOpts);
						var directionsService = new google.maps.DirectionsService;
    					var directionsDisplay = new google.maps.DirectionsRenderer;
			     		directionsDisplay.setMap(mapCanvas);
			     		directionsDisplay.setPanel(document.getElementById("map_canvas"));
						 calculateAndDisplayRoute(mapCanvas, from, to, directionsService, directionsDisplay, function(map){
						 	mapCanvas = map;
						 });
						
						 var latlngs = new google.maps.MVCArray();
			               latlngs.push(cLatLng);
			               latlngs.push(toLatLng);
			              
			               var line = new google.maps.Polyline({
			                 path: latlngs,
			                 strokeColor: "#800000",
			                 strokeOpacity: 0.2,
			                 strokeWeight: 4,
			                 dragable: false,
			                 geodesic: true,
			                 map: mapCanvas
			               });
			              google.maps.event.addListenerOnce(mapCanvas, 'idle', function(){
						
								callback(snapShotControl.getUrl());
							});
				  	} else {
						alert('Geocode 1 ' + status);
				    	callback("Geocode was not successful for the following reason: " + status);
				  	}

				});        
	  	} else {
			
			alert('Geocode Error 2 FROM: ' + from + ' TO:' + to + ' ' + status);
	    	callback("Geocode was not successful for the following reason: " + status);
			
	  	}
	}); 
};

var calculateAndDisplayRoute = function(mapCanvas, from, to, directionsService, directionsDisplay, callback) {
    directionsService.route({
      origin: from,
      destination: to,
      travelMode: 'DRIVING',
      avoidTolls: false
    }, function(results, status) {
      if (status === 'OK') {	          	
        directionsDisplay.setDirections(results);
        directionsDisplay.setMap(mapCanvas);
        callback(mapCanvas);
        } else {
		alert('Directions ' + status);	
        callback('Directions request failed due to ' + status);
      }
    });
}
          
function createMarker(opts) {
    var marker = new google.maps.Marker(opts);
    google.maps.event.addListenerOnce(marker, "click", function() {
    marker.setMap(null);
    marker = null;
    });
    return marker;
}


$(document).ready(function(){
	var imgurl;
	var filename;
	var response;
	var homeAddress;
	var workAddress;
	var n = 0;
	$("#GetData").click(function(){
		$.ajax({
		type: "GET",
		url: "csvFile.csv",
		success: function(data){
				response = csvJSON(data);
				alert(data);
				//alert('Finish loading data! Click SaveImg button!');
			},
		error: function(err){
			alert('Hmmmm, no data found!');
					return err;
			}
		});
	})
	
	$("#SaveImg").click(function(){
		SaveImg(0,1);
	});
	
	function SaveImg(n,i){
		if(n < response.length && i < 3){
			
			workAddress = $('#workaddr').val() + ', ' + $('#workcity').val() + ', ' + $('#workstate').val() + ' ' + $('#workzip').val();
			
			if( response[n]['Home Address 1'] == 'Home Address 1' || response[n]['Home Address 1'].length == 0 || response[n]['Home City'].length == 0 || response[n]['Home State'].length == 0 || response[n]['Home Zip'].length == 0 ){
				
				homeAddress = $('#workcity').val() + ', ' + $('#workstate').val();
			}
			else{
				
				var zip = '';
				
				If( response[n]['Home State'] == 'CT' || response[n]['Home State'] == 'MA' || response[n]['Home State'] == 'NH' || response[n]['Home State'] == 'NJ' ){
					
					zip = '0' + response[n]['Home Zip'];
				}
				else{
					
					zip = response[n]['Home Zip'];
				}
				
				homeAddress = response[n]['Home Address 1'] + ', ' + response[n]['Home City'] + ', ' + response[n]['Home State'] + ' ' + zip;
			}

			//alert(homeAddress);
			
			//workAddress = '34950 Little Mack Avenue, Charter Township of Clinton, MI 48035';
			
			filename = response[n]['First Name'].toLowerCase() + '-' + response[n]['Last Name'].toLowerCase();
			
			if( response[n]['Home Address 1'] == 'Home Address 1' ){
				
				filename = 'default';
			} 
			
			MapUrl(homeAddress, workAddress, n, (function(imgurl){
					setTimeout(function(){
					$.ajax({
						type: "POST",
						url: "imgUpload.php",
						data: {url: imgurl,
					   		name: filename},
						success: function(data){
								if(n+1 < response.length){
									SaveImg(n+1,i);
								}
								else{
									
									SaveImg(0,i+1);
								}
							},
						error: function(err){
							return err;
							}
					});
					}, 10000);
				}));
		}
		else{
			
			alert('All Done!');
		}
		return;
	}

	$('#upload').on('click', function() {
    var file_data = $('#sortpicture').prop('files')[0];   
    var form_data = new FormData();                  
    form_data.append('file', file_data);                           
    $.ajax({
                url: 'upload.php', // point to server-side PHP script 
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                success: function(php_script_response){
                    alert('Success Upload!'); // display response from the PHP script, if any
                }
     	});
	});
});


var getFromBetween = {
    results:[],
    string:"",
    getFromBetween:function (sub1,sub2) {
        if(this.string.indexOf(sub1) < 0 || this.string.indexOf(sub2) < 0) return false;
        var SP = this.string.indexOf(sub1)+sub1.length;
        var string1 = this.string.substr(0,SP);
        var string2 = this.string.substr(SP);
        var TP = string1.length + string2.indexOf(sub2);
        return this.string.substring(SP,TP);
    },
    removeFromBetween:function (sub1,sub2) {
        if(this.string.indexOf(sub1) < 0 || this.string.indexOf(sub2) < 0) return false;
        var removal = sub1+this.getFromBetween(sub1,sub2)+sub2;
        this.string = this.string.replace(removal,"");
    },
    getAllResults:function (sub1,sub2) {
        // first check to see if we do have both substrings
        if(this.string.indexOf(sub1) < 0 || this.string.indexOf(sub2) < 0) return;

        // find one result
        var result = this.getFromBetween(sub1,sub2);
        // push it to the results array
        this.results.push(result);
        // remove the most recently found one from the string
        this.removeFromBetween(sub1,sub2);

        // if there's more substrings
        if(this.string.indexOf(sub1) > -1 && this.string.indexOf(sub2) > -1) {
            this.getAllResults(sub1,sub2);
        }
        else return;
    },
    get:function (string,sub1,sub2) {
        this.results = [];
        this.string = string;
        this.getAllResults(sub1,sub2);
        return this.results;
    }
}