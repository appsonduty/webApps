$(document).ready(function() {
    // console.log("hi");

    $(".navShowHide").on("click", function() {
        // console.log("hi")
        var main = $("#mainSectionContainer");
        var nav = $("#sideNavContainer");

        if(main.hasClass("leftPadding")) {
            nav.hide();

        }
        else {
            nav.show();
            

        }
        main.toggleClass("leftPadding");
    });

});