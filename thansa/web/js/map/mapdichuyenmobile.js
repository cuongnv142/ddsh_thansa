
function init_map() {
    new google.maps.places.SearchBox(document.getElementById('txtSource'));
    new google.maps.places.SearchBox(document.getElementById('txtDestination'));
    directionsDisplay = new google.maps.DirectionsRenderer({'draggable': true});
    GetRoute(false);
}
function GetRoute(vcheck) {
    var directionsService = new google.maps.DirectionsService();
    var hanoi = new google.maps.LatLng(lat, long);
    var mapOptions = {
        zoom: 16,
        center: hanoi,
//        gestureHandling: 'greedy',
        mapTypeControl: false
    };
    map = new google.maps.Map(document.getElementById('dvMap'), mapOptions);
    directionsDisplay.setMap(map);
    directionsDisplay.setPanel(document.getElementById('dvPanel'));

    //*********DIRECTIONS AND ROUTE**********************//
    source = document.getElementById("txtSource").value;
    destination = document.getElementById("txtDestination").value;
    destination = new google.maps.LatLng(lat, long);
    if (!source) {
        var infowindow = new google.maps.InfoWindow({
            content: address,
            position: hanoi
        });
        infowindow.open(map);
    }
    var request = {
        origin: source,
        destination: destination,
        travelMode: google.maps.TravelMode.DRIVING
    };
    directionsService.route(request, function (response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
        }
    });

    //*********DISTANCE AND DURATION**********************//
    var service = new google.maps.DistanceMatrixService();
    service.getDistanceMatrix({
        origins: [source],
        destinations: [destination],
        travelMode: google.maps.TravelMode.DRIVING, //WALKING,TRANSIT,DRIVING
        unitSystem: google.maps.UnitSystem.METRIC,
        avoidHighways: false,
        avoidTolls: false
    }, function (response, status) {
        if (status == google.maps.DistanceMatrixStatus.OK && response.rows[0].elements[0].status != "ZERO_RESULTS") {
//                if (response.rows[0].elements[0].status == "OK") {
////                    var distance = response.rows[0].elements[0].distance.text;
////                    var duration = response.rows[0].elements[0].duration.text;
////                    var dvDistance = document.getElementById("dvDistance");
////                    dvDistance.innerHTML = "";
////                    dvDistance.innerHTML += "Khoảng cách: " + distance + "<br />";
////                    dvDistance.innerHTML += "Thời gian:" + duration;
//                }
        } else {
            if (vcheck) {
                alert("Không thể tìm thấy những khoảng cách qua đường.");
            } else {
                document.getElementById("txtSource").value = '';
                var infowindow = new google.maps.InfoWindow({
                    content: address,
                    position: hanoi
                });
                infowindow.open(map);
            }
        }
    });
}
var load_map = 0;
var source, destination;
var directionsDisplay;
var lat = $('#hdLat').val();
var long = $('#hdLong').val();
var address = $('#hdAddress').val();
$(document).ready(function () {
    widthdichuyen();
    $(window).resize(function () {
        widthdichuyen();
    });
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var target = $(e.target).attr("href") // activated tab
        if (target == '#dichuyen') {
            if (lat != '' && long != '' && load_map == 0) {
                init_map();
                load_map++;
            }
        }
    });
});
function widthdichuyen() {
    var v_width = $(window).width();
    $('#dvMap').css('width', v_width - 30);
    $('#dvMap').css('height', v_width - 30);
}