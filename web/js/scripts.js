$(document).ready(function () {
    // Configuration Materialize
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

    // Add class when hover item in header
    $('.collapsible-header').click(function () {
        $('.arrow').toggleClass("down");
    });
    $('.dropdown-suivi').hover(function () {
        $('.dropdown-suivi > .arrow').toggleClass("down");
    });
    $('.dropdown-logout').hover(function () {
        $('.dropdown-logout > .arrow').toggleClass("down");
    });

    // Load student list
    $('.container-form .classroom .dropdown-content li').click(function (e) {
        var targetElement = e.target.innerHTML;

        // Hide placeholder
        if ('Classes' !== targetElement) {
            e.target.parentNode.parentNode.childNodes[0].style.display = "none";

            $.ajax({
                url: 'students',
                type: 'POST',
                dataType: 'json',
                data: {
                    class: targetElement
                },
                success: function(students) {
                    var select = document.querySelector("#student select"),
                        option = null;

                    select.options.length = 0;

                    // Add options
                    for (var i = 0; i < students.students.length; i++) {
                        option = document.createElement("option");
                        option.text = students.students[i].firstName;
                        option.value = students.students[i].id
                        select.add(option);
                    }

                    // Add "Élèves" to select if he is empty
                    if (select.options.length === 0) {
                        option = document.createElement("option");
                        option.text = "Élèves";
                        select.add(option);
                    }

                    $("#student select").material_select();
                }
            });
        }
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
