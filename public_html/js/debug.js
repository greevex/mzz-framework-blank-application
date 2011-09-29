function runDebug() {
    $('#loadingPleaseWait')
        .hide();
    $('#debug_tooltip').slideDown();
    $('#selectedArea')
        .css('width', '0px')
        .css('height', '0px')
        .css('top', '0px')
        .css('left', '0px');
    showDebugInformation();
    $('#selectedArea')
        .css('z-index', 9999)
        .css('opacity', '0.4')
        .css('pointer-events', 'none')
        .css('background-color', 'blue')
        .css('position', 'absolute')
        .css('border', '2px solid red')
        .css('-webkit-box-shadow', '0px 0px 2px 2px #444')
        .css('-moz-box-shadow', '0px 0px 2px 2px #444')
        .css('box-shadow', '0px 0px 2px 2px #444');
    var start_coordinates = {'x':0, 'y':0};
    var end_coordinates = {'x':0, 'y':0};
    var click = false;
    var startCoordinates = false;
    var reverse = {'x':false, 'y':false};
    var writeMessage = true;
    $('#debugInformation')
        .mousemove(function(e) {
            if(e.pageX <= start_coordinates['x']) {
                reverse['x'] = true;
            } else {
                reverse['x'] = false
            }
            if(e.pageY <= start_coordinates['y']) {
                reverse['y'] = true;
            } else {
                reverse['y'] = false;
            }
            if(click) {
                if(!startCoordinates) {
                    start_coordinates = {'x':e.pageX, 'y':e.pageY};
                    //$('#debugInformation').append('<div id="selectedArea">&nbsp;</div>');

                    $('#selectedArea')
                        .css('left', start_coordinates['x'])
                        .css('top', start_coordinates['y'])
                        .css('width', '1px')
                        .css('height', '1px');
                    startCoordinates = true;
                } else {
                    if(reverse['x']) {
                        $('#selectedArea')
                            .css('left', e.pageX)
                            .css('width', start_coordinates['x'] - e.pageX);
                    } else {
                        $('#selectedArea')
                            .css('width', e.pageX - start_coordinates['x']);
                    }
                    if(reverse['y']) {
                        $('#selectedArea')
                            .css('top', e.pageY)
                            .css('height', start_coordinates['y'] - e.pageY);
                    } else {
                        $('#selectedArea')
                            .css('height', e.pageY - start_coordinates['y']);
                    }
                }
            } else {
                startCoordinates = false;
            }
            $('body').disableSelection();
        })
        .mousedown(function(e) {
            click = true;
            $('#error_description_brb, #sendDebug, #sendCancel')
                .hide();
            $('#debugInformation,#selectedArea')
                .css('cursor', 'crosshair');
            $('#loadingPleaseWait').hide();
            $('#debug_tooltip').slideUp();

            writeMessage = false;
        })
        .mouseup(function(e) {
            click = false;
            $('#debugInformation,#selectedArea')
                .css('cursor', 'default');
            $('#error_description_brb')
                .css('position', 'absolute')
                .css('left', $('#selectedArea').css('left'))
                .css('top', ($('#selectedArea').css('top').replace('px', '') - 1 + 2 + $('#selectedArea').height()) + 'px');
            if($('#error_description_brb').css('top').replace('px', '') - 1 + 1 + $('#error_description_brb').height() > $(document).height()) {
                $('#error_description_brb').css('top', $(document).height() - ($('#error_description_brb').height()+$('#sendDebug').height()+$('#sendCancel').height()) + "px");
            }
            if($('#error_description_brb').css('left').replace('px', '') - 1 + 1 + $('#error_description_brb').width() > $(document).width()) {
                $('#error_description_brb').css('left', $(document).width() - $('#error_description_brb').width() + "px");
            }
            $('#error_description_brb')
                .show();
            $('#sendDebug,#sendCancel')
                .css('position', 'absolute')
                .css('top', ($('#error_description_brb').css('top').replace('px', '') - 1 + 2 + $('#error_description_brb').height()) + "px")
                .css('left', $('#error_description_brb').css('left'))
                .show();
            $('#sendCancel')
                .css('position', 'absolute')
                .css('top', ($('#error_description_brb').css('top').replace('px', '') - 1 + 2 + $('#error_description_brb').height() + $('#sendDebug').height()) + "px")
                .css('left', $('#error_description_brb').css('left'))
                .show();
            writeMessage = true;
        });
}

function showDebugInformation()
{
    $('#debugInformation')
        .css('top', '0px')
        .css('left', '0px')
        .css('padding', '0')
        .css('margin', '0')
        .css('position', 'absolute')
        .css('width', '100%')
        .css('height', $('body').height() + "px")
        .css('background-color', 'black')
        .css('opacity', '0.1').show();
}