$(document).ready(function() {

        // ──────────────────────────────────────────────────────────────
    // Constants
    // ──────────────────────────────────────────────────────────────
    const URL_BASE     = "/visitor/";
    const TABLE_SEL    = "#visitorsTable";
    const FORM_SEL     = "#visitorsForm";
    const MODAL_SEL    = "#visitormodal";
    const CAMERA_SEL   = "#my_camera";
    const CSRF_TOKEN   = $('meta[name="csrf-token"]').attr('content');
    
// ──────────────────────────────────────────────────────────────
    // Visitor List page (only if table exists)
    // ──────────────────────────────────────────────────────────────
    const $table = $(TABLE_SEL);
    if ($table.length) {
        // Build columns from default_fields
        const columns = Object.entries(default_fields).map(([key, val]) => ({
            data: key,
            width: 'auto',
            title: val.title
        }));

        const config = {
            url: URL_BASE,
            table: TABLE_SEL,
            columns,
            targets: [
                { targets: [columns.length - 1], className: "text-right" },
                { targets: [0, 5], className: "text-center" }
            ]
        };

        // Init table + form wiring
        common.createTable(TABLE_SEL, config, true);
        common.setupFormFields(FORM_SEL, 'showModal', MODAL_SEL, URL_BASE, default_fields);

        // Add Visitor
        $('#btn-addUsers').on('click', () => {
            common.clearForm(FORM_SEL);
            common.showModal(MODAL_SEL);
        });


        // Timeout visitor (delegated)
        $(document).on('click', '.btn-timeout', function () {
            const id = $(this).data('id');
            if (!id) return;
            if (window.confirm('Are you sure you want to timeout this visitor?')) {
                $.ajax({
                    url: `${URL_BASE}setTimeout/${id}`,
                    type: 'POST',
                    data: { _token: CSRF_TOKEN },
                    success: (res) => {
                        alert(res.message);
                        $table.DataTable().ajax.reload(null, false);
                    },
                    error: () => alert('Something went wrong!')
                });
            }
        });

        // View details (delegated)
        $(document).on('click', '.btn-view', function () {
            const visitorId = $(this).data('id');
            if (!visitorId) return;

            $.ajax({
                url: `${URL_BASE}show/${visitorId}`,
                method: 'GET',
                success: (r) => {
                    const detailsHtml = `
                        <p><strong>Name:</strong> ${r.first_name} ${r.middle_name ?? ''} ${r.last_name}</p>
                        <p><strong>Number:</strong> ${r.number ?? ''}</p>
                        <p><strong>Address:</strong> ${r.address ?? ''}</p>
                        <p><strong>ID Number:</strong> ${r.id_number ?? ''}</p>
                        <p><strong>Visit Date:</strong> ${r.visit_date ?? ''}</p>
                        <p><strong>Time In:</strong> ${r.time_in ?? ''}</p>
                        <p><strong>Status:</strong> ${r.time_out ? 'Timed Out' : 'Active'}</p>
                    `;
                    $(`${MODAL_SEL} .modal-body`).html(detailsHtml);
                    common.showModal(MODAL_SEL);
                },
                error: () => alert('Error fetching visitor details.')
            });
        });
    }

});

    