$(document).ready(function () {
    $('.button-collapse').sideNav();

    $('.dropdown-button').dropdown({
            inDuration: 300,
            outDuration: 225,
            hover: true,
            belowOrigin: true,
            alignment: 'right'
        }
    );

    $('select').material_select();

    $('.collapsible-header').click(function () {
        $('.arrow').toggleClass("down");
    });
    $('.dropdown-suivi').hover(function () {
        $('.dropdown-suivi > .arrow').toggleClass("down");
    });
    $('.dropdown-logout').hover(function () {
        $('.dropdown-logout > .arrow').toggleClass("down");
    });
});
jQuery(document).ready(function () {
    var certificateWrapper = document.querySelector('#certificate-fields-list');
    var certificateCount = certificateWrapper.dataset.length;

    document.querySelector('#add-another-certificate').addEventListener('click', function (e) {
        e.preventDefault();
        var newWidget = certificateWrapper.dataset.prototype;
        newWidget = newWidget.replace(/__name__/g, certificateCount);
        certificateCount++;
        var newLi = document.createElement('li');
        newLi.innerHTML = newWidget;
        certificateWrapper.appendChild(newLi);
    });
})
