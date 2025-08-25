document.addEventListener('DOMContentLoaded', function () {
    // Webcam logic (only run if camera exists = we're on the form page)
    if (document.getElementById('my_camera')) {
        try {
            Webcam.set({
                width: 320,
                height: 240,
                image_format: 'jpeg',
                jpeg_quality: 90
            });
            Webcam.attach('#my_camera');
        } catch (e) {
            console.error('Webcam initialization failed:', e);
        }
    }

    // Event listener for Capture Button
    const captureBtn = document.getElementById('captureBtn');
    if (captureBtn) {
        captureBtn.addEventListener('click', function () {
            takeSnapshot();
        });
    }

    // Event listener for Recapture Button
    const recaptureBtn = document.getElementById('recaptureBtn');
    if (recaptureBtn) {
        recaptureBtn.addEventListener('click', function () {
            retakeSnapshot();
        });
    }

    // Global Functions
    function takeSnapshot() {
        Webcam.snap(function (data_uri) {
            const capturedInput = document.getElementById('captured_image');
            const cameraContainer = document.getElementById('my_camera');

            if (capturedInput && cameraContainer) {
                capturedInput.value = data_uri;
                cameraContainer.innerHTML = '<img src="' + data_uri + '" class="img-thumbnail">';
            }
        });
    }

    function retakeSnapshot() {
        const capturedInput = document.getElementById('captured_image');
        const cameraContainer = document.getElementById('my_camera');

        if (capturedInput && cameraContainer) {
            capturedInput.value = '';
            cameraContainer.innerHTML = '';
            Webcam.attach('#my_camera');
        }
    }
});

let url = "/visitor/";
let table = "#visitorsTable";
let form = "#visitorsForm";
let popContainer = "#visitormodal";

// Check if the table exists on this page (Visitor List page)
if (document.querySelector(table)) {
    let columns = [];
    $.each(default_fields, function (index, value) {
        columns.push({ data: index, width: 'auto', title: value.title });
    });

    let config = {
        url: url,
        table: table,
        columns: columns,
        targets: [
            { targets: [columns.length - 1], className: "text-right" },
            { targets: [0, 5], className: "text-center" }
        ]
    };

    $(document).ready(function () {
        common.createTable(table, config, true);
        common.setupFormFields(form, 'showModal', popContainer, url, default_fields);

        $("#btn-addUsers").on('click', () => {
            common.clearForm(form);
            common.showModal(popContainer);
        });

        $(form).on('submit', function (e) {
            e.preventDefault();
            common.saveForm(url + 'save', table, form, new FormData(this), config);
        });

        $(document).on('click', '.btn-timeout', function () {
            let id = $(this).data('id');
            if (confirm('Are you sure you want to timeout this visitor?')) {
                $.ajax({
                    url: url + `setTimeout/${id}`,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (res) {
                        alert(res.message);
                        $(table).DataTable().ajax.reload(null, false);
                    },
                    error: function () {
                        alert('Something went wrong!');
                    }
                });
            }
        });

        $(document).on('click', '.btn-view', function () {
            let visitorId = $(this).data('id');
            $.ajax({
                url: url + 'show/' + visitorId,
                method: 'GET',
                success: function (response) {
                    let detailsHtml = `
                        <p><strong>Name:</strong> ${response.first_name} ${response.middle_name} ${response.last_name}</p>
                        <p><strong>Number:</strong> ${response.number}</p>
                        <p><strong>Address:</strong> ${response.address}</p>
                        <p><strong>ID Number:</strong> ${response.id_number}</p>
                        <p><strong>Visit Date:</strong> ${response.visit_date}</p>
                        <p><strong>Time In:</strong> ${response.time_in}</p>
                        <p><strong>Status:</strong> ${response.time_out ? 'Timed Out' : 'Active'}</p>
                    `;
                    $('#visitormodal .modal-body').html(detailsHtml);
                    common.showModal(popContainer);
                },
                error: function () {
                    alert('Error fetching visitor details.');
                }
            });
        });
    });
}

// Webcam logic (only run if camera exists = we're on the form page)


