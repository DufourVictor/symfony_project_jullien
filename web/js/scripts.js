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
    $('.select').material_select();

    // Add class when hover item in header
    $('.company').click(function () {
        $('.company > .arrow').toggleClass("down");
    });
    $('.follow-school').click(function () {
        $('.follow-school > .arrow').toggleClass("down");
    });
    $('.dropdown-company').hover(function () {
        $('.dropdown-company > .arrow').toggleClass("down");
    });
    $('.dropdown-suivi').hover(function () {
        $('.dropdown-suivi > .arrow').toggleClass("down");
    });
    $('.dropdown-logout').hover(function () {
        $('.dropdown-logout > .arrow').toggleClass("down");
    });

    $('.datepicker').pickadate({
        selectMonths: true,
        selectYears: 15,
        today: 'Aujourd\'hui',
        clear: 'Effacer',
        close: 'Ok',
        closeOnSelect: false,
        format: 'dd/mm/yyyy',
        monthsFull: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
        weekdaysShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
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

    // Bind select2
    $('.select2').select2({
        tags: true,
    });

    // Event select2 when add option
    $('.select2').on('select2:selecting', function (e) {
        if (e.params.args.data._resultId === undefined) {
            if (confirm(e.currentTarget.dataset.confirm)) {
                $.ajax({
                    url: e.currentTarget.dataset.url,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        data: e.params.args.data.text,
                    },
                })
            } else {
                e.preventDefault();
            }
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
