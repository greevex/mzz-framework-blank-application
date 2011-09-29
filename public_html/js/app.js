function changeHash(hash)
{
    if(hash.substr(0, 2) == '/#') return false;
    var uri = "http://" + SITE_DOMAIN + hash + "&withoutMain=1";
    $('#content').load(uri);
}

$(document).ready(function() {
    $("#footer_info").click(function() {
        if($("#footer").css('bottom') == '0px') {
            var height = $("#footer_info").height() - $("#footer").height();
            $("#footer").animate({
                bottom:height+"px"
                });
        } else {
            $("#footer").animate({
                bottom:'0px'
            });
        }
    });
    $(".adminMenuClicker").click(function() {
        $(".adminMenu").slideToggle("slow");
        return false;
    });
    $(".chatClicker").click(function() {
        if($(".chatClicker").css('color') == 'rgb(255, 255, 255)') {
            $(".sideSlide").animate({
                right:'-130px'
            }, 500);
            $(".chatClicker").css('color', 'rgb(254, 254, 254)');
        } else {
            $(".sideSlide").animate({
                right:'-787px'
            }, 500);
            $(".chatClicker").css('color', 'rgb(255, 255, 255)');
        }
    });
    $(".photoClicker").click(function() {
        if($(".photoClicker").css('color') == 'rgb(255, 255, 255)') {
            $(".photoSlide").animate({
                top:'80px'
            }, 500);
            $(".photoClicker").css('color', 'rgb(254, 254, 254)');
        } else {
            $(".photoSlide").animate({
                top:'-354px'
            }, 500);
            $(".photoClicker").css('color', 'rgb(255, 255, 255)');
        }
    });
/*$('a').live('click', function() {
        var i = (this+'').indexOf('/', 9);
        i = (i === -1) ? 0 : i;
        var url = this.toString().substr(i);
        document.location.hash=url;
        return false;
    });
    $(window).bind('hashchange', function() {
        changeHash(document.location.hash.substr(1));
    });*/
});

$('#content').ready(function() {
    changeHash(document.location.hash.substr(1));
});

function storeUserSettings(form)
{
    $.get($(form).attr('action'), $(form).serialize(), function () {
        if (confirm('Настройки сохранены! Обновить страницу?')) {
            window.location.reload();
        }
    });
    return false;
}

function setGroupPropertiesOrder(form, xhr) {
    var order = {};
    var orders = {};
    var current_group = null;
    var group_count = 1;
    $('.group_sorting td, .group_sorting div').each(function () {
        // find property related row
        if ($(this).attr('id').indexOf('property') === 0) {
            // process it as group
            if ($(this).attr('id').indexOf('propertyGroup') === 0) {
                var matches = $(this).attr('id').match(/propertyGroup-([^-]+)/);
                if (matches) {
                    current_group = matches[1];
                    if (typeof orders[current_group] == 'undefined') {
                        orders[current_group] = {
                            __order: group_count++
                        };
                    }
                }
            } else {
                // process it as property
                var matches = $(this).attr('id').match(/property-([^-]+)/);
                if (matches) {

                    if (typeof order[current_group] == 'undefined') {
                        order[current_group] = 1;
                    }

                    orders[current_group][matches[1]] = order[current_group]++;
                }
            }
        }
    });

    $('#properties_order').val($.param(orders));

    if (!xhr) {
        return $(form).submit();
    } else {
        $.post($(form).attr('action'), $(form).serialize(), function() {
            alert('Сортировка групп и свойств сохранена!');
        });
    }

    return false;
}

function moveItem(from, dest, val, prepend, name) {
    var run = function(value) {
        if (prepend) {
            $(from).parents('form').first().append('<input type="hidden" name="' + name + '[]" value="' + value +  '">');
        } else {
            $('input[type="hidden"][name="' + name + '[]"][value="' + value + '"]').remove();
        }

        var opt = $(from + " option[value='" + value + "']");
        var selected_opt = opt.clone(true);
        opt.remove();
        $(dest).append(selected_opt);
    }
    if (typeof val == 'string' || typeof val == 'integer') {
        run(val);
    } else {
        val.each(function(key, item) { run($(item).val());  });
    }
}

function initButton(name, type)
{
    var id = 'formElm_' + name;
    $('button.add-' + type).click(function (e) {
        e.preventDefault();
        moveItem('#' + id,'#' + id + '_selected', $("#" + id +  " option:selected"), true, name);
    });
    $('button.remove-' + type).click(function (e) {
        e.preventDefault();
        moveItem('#' + id + '_selected','#' + id, $("#" + id + "_selected option:selected"), false, name);
    });
    var values = $('#' + id).val();
    $('#' + id + " option:selected").removeAttr("selected");

    values = values ? values : [];
    $.each(values, function(e, s) {
        moveItem("#" + id, "#" + id + "_selected", s, true, name);
    });
}

function setTimepicker(id)
{
    $('#' + id).timepicker({
        timeOnlyTitle: 'Выберите время',
        timeText: 'Время',
        hourText: 'Часы',
        minuteText: 'Минуты',
        secondText: 'Секунды',
        currentText: 'Сейчас',
        closeText: 'Закрыть'
    });
}