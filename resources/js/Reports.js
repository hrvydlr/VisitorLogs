let defaultFields = default_fields
let url           = "/reports/";
let table         = "#reportsTable";

$(document).ready(function() {

    let columns = []
    $.each(defaultFields, function(index, value){
        columns.push({data: index, width: 'auto', title: value.title})
    })
     
    let config = {
        url     : url,
        table   : table,
        columns : columns,
        targets : [
            {targets: [columns.length - 1], className: "text-right"},
            {targets: [0,5], className: "text-center"}
        ]
    }

    // Create Table
    let datatable = common.createTable(table, config, true)

    // View Visitor Details
    $(document).on('click', '.btn-view', function() {
        let visitorId = $(this).data('id');
        $.ajax({
            url: url + 'show/' + visitorId,
            method: 'GET',
            success: function(response) {
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
            error: function() {
                alert('Error fetching visitor details.');
            }
        });
    });

    // Apply Filter
    $('#applyFilterBtn').on('click', function() {
        let visitorType = $('#visitorTypeFilter').val();
        let visitDate   = $('#visitDateFilter').val();

        // Reload table with filters
        $(table).DataTable().ajax.url(url + "list?visitor_type=" + visitorType + "&visit_date=" + visitDate).load();

        // Close modal
        $('#filterModal').modal('hide');
    });

});
