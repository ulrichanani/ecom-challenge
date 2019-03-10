$(document).ready(function () {

    /*
    Adds function "exists()" to jQuery
     */
    $.fn.exists = function () {
        return this.length !== 0;
    }

});
