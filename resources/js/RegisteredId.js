let defaultFields = default_fields
let url           = "/registered-id/";
let table         = "#registeredidTable";
let form          = "#registeredIDForm";
let popContainer  = "#addIDModal";

$(document).ready(function(){

    let columns = []
    $.each(defaultFields, function(index, value){
        columns.push({data: index, width: 'auto', title: value.title})
    })

    let config = {
        url     : url,
        table   : table,
        columns : columns,
        targets : [
                    {targets: [columns.length - 1],  className: "text-right"},
                    {targets: [0, 5],                className: "text-center"}
                  ]
    }

    // Create Table
    common.createTable(table, config, true)

    // Set Local Storage for Edit Form
    common.setupFormFields(form, 'showModal', popContainer, url, defaultFields)

    // Show Add Modal
    $("#btn-addID").on('click', () => {
        common.clearForm(form)
        common.showModal(popContainer)
    })

    // Submit Form
    $(form).on('submit', function(e){
        e.preventDefault()
        common.saveForm(url + 'save', table, form, new FormData($(this)[0]), config)
    })
})
