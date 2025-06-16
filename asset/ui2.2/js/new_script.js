function isNumberKeyx(e) {
    var a = e.which ? e.which : event.keyCode;
    return a > 47 && 58 > a || 44 == a || 46 == a || 8 == a ? !0 : !1
}! function(e) {
    e(document).ready(function() {
			alert ('aa'); return false;

    })
}(jQuery),
function(e) {
    e(document).ready(function() {
			alert ('bb'); return false;
		
    })
}

(jQuery), $(function() {

    }),
    function(e) {
        e(document).ready(function() {
			alert ('cc'); return false;
        })
    }(jQuery);



