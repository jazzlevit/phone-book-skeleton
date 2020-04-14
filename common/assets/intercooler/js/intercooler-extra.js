/**
 * Created by PhpStorm.
 * User: Irina Sklyarenko
 * Date: 11/9/16
 * Time: 13:10
 */

$(function () {

    $(document).on('beforeSend.ic', function (evt, elt, data, settings, xhr) {
        var target = getOverlayArea(elt);
        $(target).LoadingOverlay("show", {
            zIndex: 10,
            maxSize: "70px",
            size: "30%"
        });
    }).on('complete.ic', function (evt, elt) {
        var target = getOverlayArea(elt);
        $(target).LoadingOverlay("hide");
    });


    function getOverlayArea(elt) {
        var selector = $(elt).attr('ic-overlay-area');

        if (typeof selector == 'undefined') {
            return Intercooler.getTarget(elt);
        } else {
            return $(elt).closest(selector);
        }
    }
});



