let defaultFields = default_fields
let url = "/usertype/";
let table = "#userType";
let form = "#usertypeForm";
let popContainer = "#usertypemodal";

$(document).ready(function(){

    let columns = []
    $.each(defaultFields, function(index, value){
        columns.push({data: index, width: 'auto', title: value.title})
    })
     
    // Create config variable
    let config = {
        url: url,
        table: table,
        columns: columns,
        targets: [
            {targets: [columns.length - 1], className: "text-right"},
            {targets: [0,5], className: "text-center"},
            {targets: '_all', orderable: false}
        ],
        // ✅ dito tatawagin every redraw
        drawCallback: function(settings) {
    let api = this.api();
    let pageInfo = api.page.info();

    updateEntriesInfo(
        pageInfo.start + 1,
        pageInfo.end,
        pageInfo.recordsTotal,
        pageInfo.recordsDisplay
    );
    },
        // ✅ alisin default info sa baba
       dom: '<"row mb-2"<"col-md-6"l><"col-md-6 text-end"f>>rt<"row mt-2"<"col-md-6"><"col-md-6"p>>'
    }

    // Create Table
    common.createTable(table, config, true)

    // Update stats after table is loaded
    updateStats()

    // Set Local Storage for Edit Form
    common.setupFormFields(form, 'showModal', popContainer, url, defaultFields)

    // Show Add Modal
    $("#btn-addUT").on('click', () => {
        common.clearForm(form)
        common.showModal(popContainer)
    })

    // Submit Form
    $(form).on('submit', function(e){
        e.preventDefault()
        common.saveForm(url + 'save', table, form, new FormData($(this)[0]), config)
            .then(() => {
                // Update stats after successful save
                setTimeout(() => {
                    updateStats()
                }, 500)
            })
    })

    // Listen for DataTable draw event to update stats
    $(table).on('draw.dt', function() {
        updateStats()
    })

    // Listen for DataTable processing event
    $(table).on('processing.dt', function(e, settings, processing) {
        if (!processing) {
            setTimeout(() => {
                updateStats()
            }, 100)
        }
    })
})

// Function to update stats in real-time
function updateStats() {
    try {
        let dataTable = $(table).DataTable()
        
        if (!dataTable) {
            console.log('DataTable not initialized yet')
            return
        }

        let allData = dataTable.data().toArray()
        let totalCount = allData.length
        let activeCount = totalCount

        animateStatUpdate('.stat-card:first .stat-value', totalCount)
        animateStatUpdate('.stat-card:last .stat-value', activeCount)
        
    } catch (error) {
        console.error('Error updating stats:', error)
        fallbackStatsUpdate()
    }
}

function fallbackStatsUpdate() {
    try {
        let totalRows = $(table + ' tbody tr:not(.dataTables_empty)').length
        let activeRows = totalRows
        animateStatUpdate('.stat-card:first .stat-value', totalRows)
        animateStatUpdate('.stat-card:last .stat-value', activeRows)
    } catch (error) {
        console.error('Error in fallback stats update:', error)
    }
}

function animateStatUpdate(selector, newValue) {
    let $element = $(selector)
    
    if ($element.length === 0) return
    
    let currentValue = parseInt($element.text()) || 0
    
    if (currentValue === newValue) return
    
    $({counter: currentValue}).animate({counter: newValue}, {
        duration: 800,
        easing: 'swing',
        step: function() {
            $element.text(Math.ceil(this.counter))
        },
        complete: function() {
            $element.text(newValue)
        }
    })
    
    $element.parent().addClass('stat-updated')
    setTimeout(() => {
        $element.parent().removeClass('stat-updated')
    }, 1000)
}

// ✅ Function to update entries info in header
function updateEntriesInfo(start, end, total, filtered) {
    let text = '';
    if (filtered < total) {
        text = `Showing ${start} to ${end} of ${filtered} entries (filtered from ${total} total entries)`;
    } else {
        text = `Showing ${start} to ${end} of ${total} entries`;
    }
    $('#entries-info').text(text);
}

// Auto-refresh stats every 30 seconds (optional)
setInterval(() => {
    if ($(table).is(':visible') && $.fn.DataTable.isDataTable(table)) {
        updateStats()
    }
}, 30000)
