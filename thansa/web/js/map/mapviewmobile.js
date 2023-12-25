
var pmdc = function () {
    $this = this;
    this.infoWindow = null;
    this.map = null;
    this.marker = null;
    this.markerUtilities = new Array();
    this.circle = null;
    this.searchVar = {};
    this.dataUtilities = new Array();
    this.tooltip = null;
    var urlImageRoot_full = '';
    var mapHostUrl = '';
};
var markers = [];
pmdc.prototype.InitMap = function (lat, lon, address) {

    if (this.map == null) {
        lat = parseFloat(lat);
        lon = parseFloat(lon);
        var mapOptions = {
            center: new google.maps.LatLng(lat, lon),
//            gestureHandling: 'greedy',
            zoom: 14,
            overviewMapControl: true,
            overviewMapControlOptions: {
                opened: false
            },
            panControl: false,
            rotateControl: false,
            scaleControl: false,
            streetViewControl: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
                position: google.maps.ControlPosition.TOP_RIGHT
            },
            zoomControl: true,
            zoomControlOptions: {
                position: google.maps.ControlPosition.TOP_RIGHT
            }
        };
        this.map = new google.maps.Map(document.getElementById('maputility'), mapOptions);
        this.tooltip = new Tooltip({
            map: this.map
        });
        this.marker = new google.maps.Marker({
            position: new google.maps.LatLng(lat, lon),
            map: this.map,
            icon: {
                url: urlImageRoot_full + "vitri.png",
                size: new google.maps.Size(24, 24)
            },
            zIndex: 10
        });
        address = '<div style="width:300px; min-height:50px;">' + address + '</div>';

        if (this.infoWindow == null) {
            this.infoWindow = new InfoBox({map: this.map});
        }

        google.maps.event.clearListeners(this.infoWindow, 'closeclick');
        google.maps.event.addListener(this.marker, 'click', function (evt) {
            if ($this.infoWindow == null) {
                this.infoWindow = new InfoBox({map: this.map});
            }
            $this.infoWindow.setContent(address);
            $this.infoWindow.open($this.map, $this.marker, 45);
            google.maps.event.clearListeners($this.infoWindow, 'closeclick');
        });
        $('.utilityradius input[type=radio], .detail_kpdt_slide_new_mb input[type=radio]').bind('change', this, function (evt) {
            evt.data.SearchAction();
        });
    }
};
pmdc.prototype.SearchAction = function () {
    this.ClearPoint();
    this.searchVar.radius = 1000;//parseFloat($('.utilityradius input[type=radio]:checked').val()) * 1000;
    this.searchVar.radius_fix = 1000;//parseFloat($('.utilityradius input[type=radio]:checked').val()) * 1000;//5000;
    var types = '';
    $('.detail_kpdt_slide_new_mb input[type=radio]:checked').each(function () {
        if (types.length > 0)
            types += ',';
        types += $(this).val();
    });
    if (types.length == 0) {
        $this.ShowPoint();
        return;
    }
    this.searchVar.types = types;
    this.searchVar.lat = this.marker.position.lat();
    this.searchVar.lon = this.marker.position.lng();
    this.searchVar.m = 'pjdetail';
    this.searchVar.v = new Date().getTime();
//    $('.googleMap').block({
//        message: '<img width="40" src="' + urlImageRoot_full + 'map-loading.gif">', //'<h1>Đang xử lý</h1>',
//        css: {
//            border: '1px solid #009e06',
//            padding: 'none',
//            width: '40px',
//            height: '40px'
//        }
//    });

    $.ajax({
        url: mapHostUrl,
        data: this.searchVar, dataType: 'json', type: "POST",
        success: function (data) {
            if (data.err == 0) {
                $this.ShowPoint(eval(data.data));
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
        },
        complete: function () {
        }
    });
};
pmdc.prototype.ClearPoint = function () {
    if (this.circle !== null)
        this.circle.setMap(null);
    for (var i = 0; i < this.markerUtilities.length; i++) {
        this.markerUtilities[i].setMap(null);
    }
    this.markerUtilities = new Array();
};
pmdc.prototype.ShowPoint = function (data) {

    this.infoWindow.close();
    this.dataUtilities = new Array();
    var radius = parseInt(this.searchVar.radius);
    if (this.circle === null)
        this.circle = new google.maps.Circle({
            center: this.marker.position,
            radius: radius,
            fillOpacity: 0.4,
            fillColor: 'transparent',
            strokeColor: '#D20023'
        });
    else
        this.circle.setOptions({
            center: this.marker.position,
            radius: radius
        });
    this.circle.setMap(this.map);
    if (data != undefined && data != null && data.length > 0) {
        this.dataUtilities = $this.formatUtilities(data, this.marker.position, radius);
        for (var i = 0; i < this.dataUtilities.length; i++) {
            var util = this.dataUtilities[i];
            if (util.distance > 10) {
                var htmlTip = '';
                htmlTip += '<div class="infowindow-util-preview">';
                htmlTip += '<b class="infowindow-util-preview-title">' + util.name + '</b>';
                if (util.address != null && util.address.length > 0)
                    htmlTip += '<span>' + util.address + '</span><br/>';
                htmlTip += '<b>Khoảng cách: </b>' + util.distance + 'm';
                htmlTip += '</div>';

                markers[i] = new google.maps.Marker({
                    position: new google.maps.LatLng(util.lat, util.lon),
                    map: this.map,
                    tooltip: htmlTip,
                    icon: {
                        url: urlImageRoot_full + '/iconmap/tienich_' + this.dataUtilities[i].typeid + '.png',
                         size: new google.maps.Size(18, 25)
                    },
                    zIndex: 9
                });
                this.markerUtilities.push(markers[i]);
                this.markerUtilities[this.markerUtilities.length - 1].id = this.dataUtilities[i].id;
                this.markerUtilities[this.markerUtilities.length - 1].addListener('click', function () {
                    $this.ShowUtilityWindow(this.id);
                });
                this.markerUtilities[this.markerUtilities.length - 1].addListener('mouseover', function (evt) {
                    var point = evt.latLng;
                    if (point == null) {
                        point = this.getPosition();
                    }
                    $this.tooltip.addTip(this);
                    $this.tooltip.getPos2(point);
                });
                this.markerUtilities[this.markerUtilities.length - 1].addListener('mouseout', function (evt) {
                    $this.tooltip.removeTip();
                });
            }
        }
    }

    this.ShowListResult();
};
// ThanhDT add for count utilities
pmdc.prototype.getTotalUtility = function (data, utitilityType) {
    var total = 0;
    for (var i = 0; i < data.length; i++) {
        if (data[i].typeid == utitilityType) {
            total++;
        }
    }
    return total;
};
pmdc.prototype.formatUtilities = function (data, curPosition, maxDistance) {
    if (data == null || data.length == 0)
        return [];
    var validUtilities = [];
    for (var i = 0; i < data.length; i++) {
        var distance = parseInt(google.maps.geometry.spherical.computeDistanceBetween(new google.maps.LatLng(data[i].lat, data[i].lon), curPosition));
        if (distance <= maxDistance) {
            data[i].distance = distance;
            validUtilities.push(data[i]);
        }
    }
    return validUtilities;
};
pmdc.prototype.ShowListResult = function () {
    if (this.dataUtilities != undefined && this.dataUtilities != null && this.dataUtilities.length > 0) {
        $('.detail_kpdt_slide_new_mb input[type=radio]:checked').each(function () {

            var typeid = parseInt($(this).val());
            var html = '';
            for (var i = 0; i < $this.dataUtilities.length; i++) {
                var util = $this.dataUtilities[i];
                if (util.typeid == typeid) {
                    var distance = parseInt(google.maps.geometry.spherical.computeDistanceBetween(new google.maps.LatLng(util.lat, util.lon), $this.marker.position));
                    html += '<div class="swiper-slide">' +
                            '<div class="item-city-new">' +
                            '<a onclick="showClick(' + i + ')" class="img-item-city">' +
                            '<img src="'+'/images/tienich/avataricon/tienich_' + typeid + '.png'+'" alt="'+util.name+'">' +
                            ' </a>' +
                            '<div class="info-item-city">' +
                            '<a onclick="showClick(' + i + ')" class="name-item-city">' +
                            util.name +
//                                                             util.address+
                            ' </a>' +
                            '<span class="total-pj-item-city">' +
                            distance + ' m' +
                            '</span>' +
                            '</div>' +
                            '<div class="clearfix"></div>' +
                            '</div>' +
                            '</div>';
                }
            }

            if (html.length > 0) {
                html = '<div class="swiper-wrapper">' + html + '</div>';
                $('.detail_kpdt_slide_mb').html(html);
                var detail_kpdt_slide_mb = new Swiper('.detail_kpdt_slide_mb', {
                    slidesPerView: 2.5,
                    spaceBetween: 12,
                    pagination: {
                        clickable: true,
                    },
                });
            }
        });
    } else {
        $('.detail_kpdt_slide').html('');
    }
};
pmdc.prototype.ShowUtilityWindow = function (id) {
    this.infoWindow.close();
    for (var i = 0; i < this.dataUtilities.length; i++) {
        if (this.dataUtilities[i].id == id) {

            for (var j = 0; j < this.markerUtilities.length; j++) {
                if (this.markerUtilities[j].id == id) {
                    var util = this.dataUtilities[i];
                    var contentUtil = '';
                    contentUtil += '<div class="infowindow-util">';
                    contentUtil += '<b class="infowindow-util-title">' + util.name + '</b>';
                    if (util.address != null && util.address.length > 0)
                        contentUtil += '<span>' + util.address + '</span><br/>';
                    if (util.website != null && util.website.length > 0)
                        contentUtil += '<span>' + util.website + '</span><br/>';
                    if (util.email != null && util.email.length > 0)
                        contentUtil += '<span>' + util.email + '</span><br/>';
                    if (util.phone != null && util.phone.length > 0)
                        contentUtil += '<span>' + util.phone + '</span><br/>';
                    contentUtil += '<b>Khoảng cách:</b> ' + parseInt(google.maps.geometry.spherical.computeDistanceBetween(this.markerUtilities[j].position, this.marker.position)) + 'm';
                    contentUtil += '</div>';
                    this.infoWindow.setContent(contentUtil);
                    this.infoWindow.open(this.map, this.markerUtilities[j], 37);
                    google.maps.event.clearListeners(this.infoWindow, 'closeclick');
                }
            }
        }
    }

};

$(document).ready(function () {
    var loadMap = 0;
    var lat = $('#hdLat').val();
    var long = $('#hdLong').val();
    var address = $('#hdAddress').val();
    if (lat != '' && long != '' && loadMap == 0) {
        var pmd = new pmdc();
        pmd.InitMap(lat, long, '<div style="width:300px; height:auto;">' + address + '</div>');
        pmd.SearchAction();
        loadMap++;
    }
});

function getAjaxMethod() {
    var m;
    if ($.browser != undefined && $.browser.msie) {
        if (parseInt($.browser.version) < 10) {
            m = "GET";
        } else {
            m = "POST";
        }
    } else {
        m = "POST";
    }

    return m;
}

function showClick(id) {
    google.maps.event.trigger(markers[id], 'click');
}