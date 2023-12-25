(function () {
    // global vars
    var hotSpotWidth = 30;
    var spotId = 0;
    var form = $('#toolTipGenerator form');
    var image = $('#toolTipGenerator .image');

    var imageOffsetTop = $(image).offset().top;
    var imageOffsetLeft = $(image).offset().left;

    var hotSpots = [];

    var selectedSpot;
    var moving = false;

    init();

    function init() {
        disableForm();
        formActions();
        $(image).on('mousedown', function (e) {
            if ($(e.target).hasClass('t_hotSpot')) {
                hotSpots[$(e.target).attr('id').replace('t_hotspot_', '')].select();
            } else {
                if (selectedSpot) {
                    selectedSpot.deselect();
                } else {
                    drawHotSpot(e);
                }
            }
        });
        const config = {attributes: true, childList: true, subtree: true};
        const callback = function (mutationsList, observer) {
            // Use traditional 'for loops' for IE 11
            for (const mutation of mutationsList) {
                if (mutation.type === 'childList') {
                    setData();
                } else if (mutation.type === 'attributes' && mutation.attributeName == 'src') {
                    setData();
                }
            }
        };
        // Create an observer instance linked to the callback function
        const observer = new MutationObserver(callback);

// Start observing the target node for configured mutations
        observer.observe($(image)[0], config);
    }


    function drawHotSpot(e) {
        var x = e.pageX;
        var y = e.pageY;
        var relativeToImageTop = y - $(image).offset().top;
        var relativeToImageLeft = x - $(image).offset().left;
        buildHotpot(relativeToImageLeft, relativeToImageTop)
    }

    window.buildHotpot = function (left, top, setting = {}) {
        var hotSpot = new HotSpot(left, top, $(image), setting);
        hotSpot.init();
        hotSpots.push(hotSpot);
        setData();
    }

    function disableForm() {
        $('#toolTipGenerator .setting').find('input, select, textarea').attr('disabled', 'disabled');
        $('#toolTipGenerator .setting .chosen-select').val('').trigger("chosen:updated");
    }

    function enableForm() {
        $('#toolTipGenerator .setting').find('input, select, textarea').removeAttr('disabled');
        $('#toolTipGenerator .setting .chosen-select').trigger("chosen:updated");
    }

    function applySettingToSpot(id) {
        $('#' + id).on('change', function () {
            if (selectedSpot) {
                selectedSpot.settings[id] = $(this).val();
                selectedSpot.applySettings();
            }
        });
    }

    function formActions() {
        applySettingToSpot('t_spotType');
        // applySettingToSpot('t_spotSize');
        applySettingToSpot('t_spotColor');
        $('#t_toolTipWidth').on('change', function () {
            if (selectedSpot) {
                if ($('#t_toolTipWidthAuto')[0].checked) {
                    $('#t_toolTipWidthAuto').click();
                }
                selectedSpot.settings['t_toolTipWidth'] = parseInt($(this).val());
                selectedSpot.applySettings();
            }
        });
        $('#t_toolTipWidthAuto').on('change', function () {
            if (selectedSpot) {
                if ($(this)[0].checked) {
                    selectedSpot.settings['t_toolTipWidthAuto'] = true;
                } else {
                    selectedSpot.settings['t_toolTipWidthAuto'] = false;
                }
                selectedSpot.applySettings();
            }
        });
        $('#t_toolTipVisible').on('change', function () {
            if (selectedSpot) {
                if ($(this)[0].checked) {
                    selectedSpot.settings['t_toolTipVisible'] = true;
                } else {
                    selectedSpot.settings['t_toolTipVisible'] = false;
                }
                selectedSpot.applySettings();
            }
        });
        applySettingToSpot('t_productId');

        applySettingToSpot('t_popupPosition');
        applySettingToSpot('t_content');
        $('#t_content').on('keyup', function () {
            if (selectedSpot) {
                selectedSpot.settings['t_content'] = $(this).val();
                selectedSpot.applySettings();
            }
        });
        $('#t_deleteSpot').on('click', function () {
            if (selectedSpot) {
                selectedSpot.delete();
            }
        });
    }

    function applySpotSettingsToForm() {
        var settings = selectedSpot.settings;
        for (var i in settings) {
            $('#' + i).val(settings[i]);
        }
        if (selectedSpot.settings['t_toolTipWidthAuto']) {
            $('#t_toolTipWidthAuto').attr('checked', 'checked');
        } else {
            $('#t_toolTipWidthAuto').removeAttr('checked');
        }
    }

    function setData() {
        var dataSetting = [];
        if (hotSpots.length) {
            setTimeout(function () {
                for (var hotpot in hotSpots) {
                    if (hotSpots[hotpot] && $(image).width() > 0 && $(image).height() > 0) {
                        hotSpots[hotpot].settings['t_w'] = $(image).width();
                        hotSpots[hotpot].settings['t_h'] = $(image).height();
                    }
                    if (hotSpots[hotpot]) {
                        dataSetting.push(hotSpots[hotpot].settings);
                    }
                }
                $('#adminproductcat-hotpost_config').val(JSON.stringify(dataSetting));
            }, 1000);

        } else {
            $('#adminproductcat-hotpost_config').val(JSON.stringify(dataSetting));
        }
    }


    function HotSpot(x, y, parent, setting = {}) {
        this.parent = parent;
        this.id = spotId;
        this.x = x;
        this.y = y;
        this.html = '<div class="t_hotSpot" id="t_hotspot_' + this.id + '"><div class="t_tooltip_content_wrap"><div class="t_tooltip_content"></div></div></div>';
        this.root = '';

        this.settings = Object.assign({}, {
            "t_spotType": "circle"
            , "t_spotSize": "small"
            , "t_spotColor": "red"
            , "t_popupPosition": "left"
            , "t_toolTipVisible": false
            , "t_content": ""
            , "t_toolTipWidth": 200
            , "t_toolTipWidthAuto": true
            , "t_productId": ''
            , "t_x": x
            , "t_y": y
            , "t_w": $(image).width()
            , "t_h": $(image).height()
        }, setting);

        spotId++;

    }


    HotSpot.prototype.init = function () {
        this.parent.append(this.html);
        this.root = $('#t_hotspot_' + this.id).draggable({
            containment: "parent",

        }).on("dragstop", function (event, ui) {
            if (selectedSpot) {
                selectedSpot.settings['t_x'] = $(this).position().left;
                selectedSpot.settings['t_y'] = $(this).position().top;
            }
            setData();
        });

        this.root.css({"left": this.x, "top": this.y});

        this.applySettings();

    };

    HotSpot.prototype.select = function () {
        $('.t_hotSpot.selected').removeClass('selected');
        this.root.addClass('selected');

        this.root.find('.t_tooltip_content_wrap').css({opacity: 1});
        selectedSpot = this;
        applySpotSettingsToForm();
        enableForm();
    };
    HotSpot.prototype.deselect = function () {
        $('.t_hotSpot.selected').removeClass('selected');

        this.root.find('.t_tooltip_content_wrap').css("opacity", "");

        selectedSpot = null;
        disableForm();
    };
    HotSpot.prototype.delete = function () {
        this.deselect();
        this.root.remove();

        hotSpots[this.id] = null;
        setData();
    };

    HotSpot.prototype.applySettings = function () {
        this.root.removeClass('circle').removeClass('square').removeClass('circleOutline').removeClass('squareOutline').removeClass('small').removeClass('medium').removeClass('large').removeClass('red').removeClass('green').removeClass('blue').removeClass('purple').removeClass('pink').removeClass('orange')
                ;

        var wrap = this.root.find('.t_tooltip_content_wrap');
        wrap.removeClass('top').removeClass('left').removeClass('bottom').removeClass('right');


        this.root.addClass(this.settings['t_spotType']);
        this.root.addClass(this.settings['t_spotSize']);
        this.root.addClass(this.settings['t_spotColor']);
        wrap.addClass(this.settings['t_popupPosition']);
        wrap.find('.t_tooltip_content').html(this.settings['t_content']);

        wrap.removeClass('alwaysVisible');
        if (this.settings['t_toolTipVisible']) {
            wrap.addClass('alwaysVisible')
        }

        if (!this.settings['t_toolTipWidthAuto']) {
            wrap.css({'width': this.settings['t_toolTipWidth']}).addClass('specificWidth');
        } else {
            wrap.css({'width': 'auto'}).removeClass('specificWidth');
        }
        setData();
    };
})();