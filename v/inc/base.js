// SW
if (navigator.serviceWorker) {
    navigator.serviceWorker.register('/sw.js').then(registration => {
        console.log('SW Registered');
    });
}
// Setup
let fast = 300;
let normal = 500;
let slow = 1200;
// Functions
var service, snackbar, isEmpty, inputError, isNotEmail, empty, postRedirect;
$(() => {
    // Functions
    service = (url = '', data = {}, method = 'POST') => {
        return fetch(url, {
            method: method,
            body: JSON.stringify(data),
            mode: "cors",
            cache: "no-cache",
            credentials: "same-origin",
            headers: {"Content-Type": "application/json"},
            redirect: "follow",
            referrer: "no-referrer"
        }).then(response => response.json());
    };
    snackbar = (type = 'result', message = '') => {
        $.post('/ms/snackbar.php', {type: type, message: message},
            html => {
                $(".snackbar").remove();
                $('body').append(html);
            }
        );
    };
    isEmpty = inputId => {
        return $('#' + inputId).val().trim() === "";
    };
    empty = inputId => {
        return $('#' + inputId).val('');
    };
    isNotEmail = inputId => {
        let emailRegularExpresion = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        let $input = $('#' + inputId).val();
        return !emailRegularExpresion.test($input);
    };
    inputError = inputId => {
        let $input = $('#' + inputId);
        if (!$input.hasClass('error')) {
            $input
                .addClass('error')
                .labels()
                .addClass('error').append(': <i>' + $input.attr('error') + '</i>');
        }
    };
    postRedirect = (controller, action, jsonArray = null) => {
        let jsonData = JSON.parse(jsonArray);
        let inputs = '<input type="hidden" name="action" value="' + action + '"></input>';
        for (let i in jsonData) {
            inputs += '<input type="hidden" name="' + jsonData[i].name + '" value="' + jsonData[i].value + '"></input>';
        }
        let form = $('<form action="/v/' + controller + '/" method="post">' + inputs + '</form>');
        $('body').append(form);
        $(form).submit();
    };
    // Events
    $(document).on('click', '.tab-item:not(.tab-selected)', (e) => {
        $(e.target).parent().find('.tab-item').removeClass('tab-selected');
        $(e.target).addClass('tab-selected');
        $('.' + $(e.target).parent().attr('tabgroup')).hide();
        $('#' + $(e.target).attr('tabid')).show();
    });
    $(document).on('focus', 'input', (e) => {
        if ($(e.target).hasClass('error')) {
            $(e.target)
                .removeClass('error')
                .labels()
                .removeClass('error').html($(e.target).attr('content'));
        }
    });
    $(document).on('click', '.snackbar-close', () => {
        let $snackbar = $(".snackbar");
        $snackbar.animate({opacity: 0, bottom: "-=1rem"}, normal, () => {$snackbar.remove();});
    });
    $(document).on('click', '.nav-disabler', (e) => {
        $(e.target).toggle();
        $(e.target).next().next().toggleClass('collapsed');
    });
    $(document).on('click', '.nav-toggle-s', (e) => {
        $(e.target).next().toggleClass('collapsed');
        $(e.target).prev().toggle();
    });
    $(document).on('click', '.nav-toggle-l', (e) => {
        $(e.target).toggleClass('opened');
        $(e.target).parent().toggleClass('collapsed');
        $(e.target).parent().prev().prev().toggle();
    });
    // On Ready
    $(".snackbar").animate({opacity: 1, bottom: "+=1rem"}, slow, () => {
        setTimeout(() => {$('.snackbar-close').trigger('click');}, slow * 5);
    });
});