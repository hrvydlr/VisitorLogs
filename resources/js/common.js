// resources/js/common.js
class Common {
    constructor() {
        this.editFormParam = 'editFormParam' + location.pathname.split("/")[1]
    }

    createTable(table, config, other_param = false) {
        const self = this;
    
        // Destroy existing DataTable instance if it exists
        if ($.fn.dataTable.isDataTable($(table))) {
            $(table).DataTable().clear().destroy();
        }
    
        // Initialize new DataTable
        $(table).DataTable({
            autoWidth   : false,
            processing  : true,
            serverSide  : true,
            stateSave   : false,
            searching   : true,
            search      : { return: true },
            ajax        : {
                headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url     : window.location.origin + config.url + 'list',
                type    : "POST",
                data    : function(d) {
                    // Properly set search object so Laravel gets `search.value`
                    d.search.value = $("input[type='search']").val();
                    d.search.regex = false;
    
                    // Optional custom parameter
                    if (other_param) {
                        d.show_timed_out = other_param;
                    }
                },
                beforeSend: function() {},
                complete  : function(data) {},
                error     : function(error) {}
            },
            columns     : config.columns,
            columnDefs  : config.targets,
            drawCallback: function() {
                self.initializeButtons(table, config);
            }
        });
    }
    
    initializeButtons(table, config, useModal = false) {

        const self = this

        // Delete
        $(table).on('click', '.btn-delete', function () {
            const message = "Are you sure you want to delete " + $(this).attr("data-details") + "'s record?"
            self.showNotification("#notificationContainer", "Delete Notification", message, $(this).attr("data-id"))
            self.processButtonOk(config.url + "delete", { id: $("#record_id").val() })
        })

        // Edit
        $(table).on('click', '.btn-edit', function () {

            self.onLoadForm($(this).attr('data-id'))

            // if (useModal) self.onLoadForm($(this).attr('data-id'))
            // else window.location.href = url + 'form/' + $(this).attr('data-id');
        });
        
        $(table).on('click', '.btn-view', function() {
            let data = $.ajax({
                url     : window.location.origin  + config.view_url + $(this).data('id'),
                type    : 'POST',
                async   : false,
                headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            
            }).responseJSON;

            window.location.href = window.location.origin  + config.view_url + $(this).data('id')
            $(table).DataTable().ajax.reload()
        })

        $(table).on('click', '.btn-timeout', function() {
            // let data = $.ajax({
            //     url     : window.location.origin  + config.time_out_url + $(this).data('id'),
            //     type    : 'POST',
            //     async   : false,
            //     headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            
            // }).responseJSON;

            self.processData(window.location.origin  + config.time_out_url + $(this).data('id'), 'POST', [])

            $(table).DataTable().ajax.reload()
        })
    }
    
    //Get Fields
    setupFormFields(form, container, container_id, url, fields = "") {
        const self = this

        self.removeItem(self.editFormParam)

        fields = fields ? fields : self.getFields(form);

        self.setItem(self.editFormParam, JSON.stringify({
            'defaultFields': fields,
            'layout': container,
            'container_id': container_id,
            'form': form,
            'url': url
        }))
    }

    onLoadForm(record_id = 0) {

        const self = this

        const storage = JSON.parse(self.getItem(self.editFormParam));

        // Clearform
        self.clearForm(storage.form);

        // Record ID
        $("#record_id").val(0);

        if (record_id > 0) {

            const methods = {
                select: (selector, value) => selector.val(value).trigger("change"),
                default: (selector, value) => selector.val(value).prop("checked", !!value)
            };

            let data = self.processData(storage.url + "search", "POST", { id: record_id })

            $.each(storage.defaultFields, function (index, value) { 
                let field = index == 'id' ? 'record_id' : index
                let selector = $(storage.form + " [name='" + field + "'], " + storage.form + " #" + field + ", " + storage.form + " ." + field);
                let fieldValue = selector.prop("multiple") ? JSON.parse(data[index]) : data[index];

                if (value.in_form > 0) {

                    const nodeName = selector.prop('nodeName') != undefined ? selector.prop('nodeName').toLowerCase() : '';

                    const methodKey = nodeName == 'select' ? 'select' : 'default';

                    methods[methodKey](selector, nodeName == 'select' ? fieldValue : data[index]);
                }
            })
        }

        if (typeof self[storage.layout] === "function") self[storage.layout](storage.container_id)
    }

    saveForm(url, table, formid, formdata, config = []) {
        const self = this

        $.ajax({
            url: window.location.origin + url,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            type: 'POST',
            data: formdata,
            processData: false,
            contentType: false,
            success: function (data) {
              
                var errors = data.errors;
                $.each(errors, function (index, value) {
                    self.showError(formid, index, value)
                })

                if (!errors) {

                    self.showToast(data);

                    console.log(data)

                    $(table).DataTable().ajax.reload()

                    setTimeout(() => {
                        self.clearForm(formid)
                        $(".btn-close").trigger('click')
                    }, 1000);
                }
            },
            error: function () {}

        });
    }
    
    // Clear Form
    clearForm(form) {

        $(form).find('input, select, textarea').not('input[type="checkbox"]').val("").removeClass('error-input').trigger('change');

        $(form).find('select').val([]).trigger('change');

        $(form).find('input[type="checkbox"]').prop('checked', false);

        // Reset success and error messages
        $(".alert-success").text("").hide();
        $(".alert-danger").hide();

        // Hide error spans
        $(".error-span").addClass('d-none');
    }

    processData(url, method, data) {
        return $.ajax({
            url: window.location.origin + url,
            type: method,
            async: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: data,
            success: function (data) {
                return data;
            },
        }).responseJSON;
    }

    processButtonOk(url, data) {
        const self = this
        $("#notificationContainer #btn_ok").on('click', function () {
            $.ajax({
                url: url,
                type: "POST",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: data,
                success: function (data) {
                    self.showToast(data);
                    setTimeout(() => { location.reload() }, 2000);
                    // $(table).DataTable().ajax.reload();
                },
            })
        })
    }

    showNotification(container_id, title, message, id) {

        $(".notification-message").empty()
        $(".notification-body").show()
        $("#record_id").val(id)
        $("#notification-title").text(title)
        $("#notification-message").text(message)

        this.showModal(container_id)
    }


    showModal(modal_id) {

        var modalElement = document.querySelector(modal_id);
        var modalInstance = bootstrap.Modal.getInstance(modalElement);

        if (!modalInstance) {
            modalInstance = new bootstrap.Modal(modalElement);
        }

        modalInstance.show();
    }

    hideModal(modal_id) {

        var modalElement = document.querySelector(modal_id);
        var modalInstance = bootstrap.Modal.getInstance(modalElement);

        if (!modalInstance) {
            modalInstance = new bootstrap.Modal(modalElement);
        }

        modalInstance.hide();
    }
   
    /**
     *
     * @param msg = notification message
     * @param err = 1=Error, 0/null = Success
     */
    showToast(msg, err = 0) {
        $('.toast-body strong').text(msg);
        $('.toast').css({'z-index':10000,
                        'display': 'block'});
        
        $('.toast').fadeIn('slow');
        $('.toast').addClass(err > 0 ? 'bg-danger' : 'bg-success')
        var toast = new bootstrap.Toast($('.toast')[0]);

        toast.show();

        setTimeout(() => {
            $('.toast').fadeOut('slow');
        }, 3000);
    }


    showError(formid, index, value) {
        var elem_id = '#' + index;
        $(formid + ' ' + elem_id).addClass('error-input');
        $(formid + ' .error-' + index).removeClass('d-none');
        $(formid + ' .error-' + index).html('<i class="bi bi-exclamation-circle-fill"></i> ' + value);
    }

    createDropdown(url, element_id, data = null, popContainer_id = "") {
        var records = $.ajax({
            url: window.location.origin + url,
            type: "POST",
            async: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: data,
            success: function (data) { return data; },
        }).responseJSON;

        console.log('disposition', records)

        $(element_id).empty();

        popContainer_id ? $(element_id).select2({ data: records, dropdownParent: $(popContainer_id), width: '100%' })
            : $(element_id).select2({ data: records });
    }
    
    // Create Storage
    setItem(field_name, field_value) { localStorage.setItem(field_name, field_value) }

    // Get Storage
    getItem(field_name) { return localStorage.getItem(field_name) }

    // Clear Storage
    clearItem() { localStorage.clear() }

    // Remove Specific Storage
    removeItem(field_name) { localStorage.removeItem(field_name) }
}

export default new Common;