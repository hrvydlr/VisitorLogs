let defaultFields= default_fields
let url          = "/reports/";
let table        = "#reportsTable";
// let form         = "#visitortypeForm";
// let popContainer = "#visitortypemodal";

$(document).ready(function() {

    let columns = []
    $.each(defaultFields, function(index, value){
        columns.push({data: index, width: 'auto', title: value.title})
    })
     
    // Create config variable
    let config = {
        url     : url,
        table   : table,
        columns : columns,
        targets : [
                    {targets: [columns.length - 1],  className: "text-right"},
                    {targets: [0,5],                 className: "text-center"}
                  ]
    }

    // Create Table
    common.createTable(table, config, true)

     // View Visitor Details and Show Modal
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
                common.showModal(popContainer);  // Show the modal
            },
            error: function() {
                alert('Error fetching visitor details.');
            }
        });
    });

    // // Set Local Storage for Edit Form
    // common.setupFormFields(form, 'showModal', popContainer, url, defaultFields)

    // // Show Add Modal
    // $("#btn-addVT").on('click', () => {
    //     common.clearForm(form)
    //     common.showModal(popContainer)
    // })

    // // Submit Form
    // $(form).on('submit', function(e){
    //     e.preventDefault()
    //     common.saveForm(url + 'save', table, form, new FormData($(this)[0]), config)
    // })

});