function initMap() {

    var map = new google.maps.Map(document.getElementById('map'), {
        mapTypeControl: false,
        zoomControl: true,
        center: {lat: current_latitude, lng: current_longitude},
        zoom: 12,
        styles : [{"elementType":"geometry","stylers":[{"color":"#f5f5f5"}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#f5f5f5"}]},{"featureType":"administrative.land_parcel","elementType":"labels.text.fill","stylers":[{"color":"#bdbdbd"}]},{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"color":"#e4e8e9"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#eeeeee"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#e5e5e5"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#7de843"}]},{"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#ffffff"}]},{"featureType":"road.arterial","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#dadada"}]},{"featureType":"road.highway","elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"color":"#e5e5e5"}]},{"featureType":"transit.station","elementType":"geometry","stylers":[{"color":"#eeeeee"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#c9c9c9"}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"color":"#9bd0e8"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]}]
    });

    new AutocompleteDirectionsHandler(map); 
}

/**
 * @constructor
 */

function AutocompleteDirectionsHandler(map) {
    this.map = map;
    this.originPlaceId = null;
    this.destinationPlaceId = null;
    this.travelMode = 'DRIVING';
    var originInput = document.getElementById('origin-input');

    var destinationInput = document.getElementById('destination-input');
    var modeSelector = document.getElementById('mode-selector');
    var originLatitude = document.getElementById('origin_latitude');
    var originLongitude = document.getElementById('origin_longitude');
    var destinationLatitude = document.getElementById('destination_latitude');
    var destinationLongitude = document.getElementById('destination_longitude');
    var mapkey = document.getElementById('mapkey').value;

    var polylineOptionsActual = new google.maps.Polyline({
            strokeColor: '#111',
            strokeOpacity: 0.8,
            strokeWeight: 4
    });

    this.directionsService = new google.maps.DirectionsService;
    this.directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: false, polylineOptions: polylineOptionsActual});
    this.directionsDisplay.setMap(map);

    var originAutocomplete = new google.maps.places.Autocomplete(
            originInput);
    var destinationAutocomplete = new google.maps.places.Autocomplete(
            destinationInput);

    var modeSelectorAutocomplete = new google.maps.places.Autocomplete(
            modeSelector);

    modeSelectorAutocomplete.addListener('place_changed', function(event) {
        var place = modeSelectorAutocomplete.getPlace();        
    });

    originAutocomplete.addListener('place_changed', function(event) {
        var place = originAutocomplete.getPlace();

        if (place.hasOwnProperty('place_id')) {
            if (!place.geometry) {
                    // window.alert("Autocomplete's returned place contains no geometry");
                    return;
            }
            originLatitude.value = place.geometry.location.lat();
            
            originLongitude.value = place.geometry.location.lng();
            
            if(originLatitude.value!='' && originLongitude.value!='')
            {
                
                var GEOCODING = 'https://maps.googleapis.com/maps/api/geocode/json?key='+mapkey+'&latlng=' + originLatitude.value + '%2C' + originLongitude.value + '&language=en';

                $.getJSON(GEOCODING).done(function(location) {

                        var storableLocation = {};
                        for (var ac = 0; ac < location.results[0].address_components.length; ac++) 
                        {
                            var component = location.results[0].address_components[ac];
                            switch(component.types[0]) 
                            {
                                case 'locality':
                                storableLocation.city = component.long_name;
                                
                                console.log(storableLocation.city);
                     
                                break;
                                case 'administrative_area_level_1':
                                storableLocation.stateS = component.short_name;
                                storableLocation.stateL= component.long_name;
                               console.log(storableLocation.stateS);
                                console.log(storableLocation.stateL);
                                break;
                                case 'country':
                                    storableLocation.country = component.long_name;
                                    storableLocation.registered_country_iso_code = component.short_name;                               
                                    console.log(storableLocation.country);
                                    console.log(storableLocation.registered_country_iso_code);
                                break;

                                
                            }



                        }

                         $.ajax({

                                    url: '/cityvalidate',
                                    dataType: "JSON",
                                    data: {city:storableLocation.city,country:storableLocation.registered_country_iso_code,state:storableLocation.stateS,statelong:storableLocation.stateL},
                                    type: "GET",
                                    success: function(data)
                                    {
                                        if(data.message!='success')
                                        {
                                             toastr.error(data.message);                                            
                                            document.getElementById('origin-input').value='';
                                            document.getElementById('origin_latitude').value='';
                                            document.getElementById('origin_longitude').value='';
                                        }
                                        else
                                        {
                                            document.getElementById('city_id').value=data.city_id;
                                            document.getElementById('country_code').value=data.country_code;
                                        }
                                        
                                    }

                                });

                })
            }

        } else {
            service.textSearch({
                    query: place.name
            }, function(results, status) {
                if (status == google.maps.places.PlacesServiceStatus.OK) {
                    originLatitude.value = results[0].geometry.location.lat();
                    originLongitude.value = results[0].geometry.location.lng();
                    if(originLatitude.value!='' && originLongitude.value!='')
                    {
                        
                    }
                }
            });
        }
    });


    destinationAutocomplete.addListener('place_changed', function(event) {
        var place = destinationAutocomplete.getPlace();

        if (place.hasOwnProperty('place_id')) {
            if (!place.geometry) {
                // window.alert("Autocomplete's returned place contains no geometry");
                return;
            }
            destinationLatitude.value = place.geometry.location.lat();
            destinationLongitude.value = place.geometry.location.lng();
        } else {
            service.textSearch({
                query: place.name
            }, function(results, status) {
                if (status == google.maps.places.PlacesServiceStatus.OK) {
                    destinationLatitude.value = results[0].geometry.location.lat();
                    destinationLongitude.value = results[0].geometry.location.lng();
                }
            });
        }
    });

    this.setupPlaceChangedListener(originAutocomplete, 'ORIG');
    this.setupPlaceChangedListener(destinationAutocomplete, 'DEST');

}

// Sets a listener on a radio button to change the filter type on Places
// Autocomplete.

AutocompleteDirectionsHandler.prototype.setupPlaceChangedListener = function(autocomplete, mode) {
    var me = this;
    autocomplete.bindTo('bounds', this.map);
    autocomplete.addListener('place_changed', function() {
        var place = autocomplete.getPlace();
        if (!place.place_id) {
            // window.alert("Please select an option from the dropdown list.");
            return;
        }
        if (mode === 'ORIG') {
            me.originPlaceId = place.place_id;
        } else {
            me.destinationPlaceId = place.place_id;
        }
        me.route();
    });

};

AutocompleteDirectionsHandler.prototype.route = function() {
    if (!this.originPlaceId || !this.destinationPlaceId) {
        return;
    }
    
    var me = this;

    this.directionsService.route({
        origin: {'placeId': this.originPlaceId},
        destination: {'placeId': this.destinationPlaceId},
        travelMode: this.travelMode
    }, function(response, status) {
        if (status === 'OK') {
            me.directionsDisplay.setDirections(response);
        } else {
            // window.alert('Directions request failed due to ' + status);
        }
    });
};