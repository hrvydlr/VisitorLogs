
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
    // Webcam (only if camera container exists on page)
    // ──────────────────────────────────────────────────────────────
    // const $camera = $(CAMERA_SEL);
    // if ($camera.length && window.Webcam) {
    //     try {
    //         Webcam.set({ width: 320, height: 320, image_format: 'jpeg', jpeg_quality: 90 });
    //         Webcam.attach(CAMERA_SEL);
    //     } catch (e) {
    //         console.error('Webcam initialization failed:', e);
    //     }

    //     const takeSnapshot = () => {
    //         Webcam.snap((dataURI) => {
    //             const $input = $('#captured_image');
    //             if ($input.length && $camera.length) {
    //                 $input.val(dataURI);
    //                 $camera.html(`<img src="${dataURI}" class="img-thumbnail">`);
    //             }
    //         });
    //     };

    //     const retakeSnapshot = () => {
    //         const $input = $('#captured_image');
    //         if ($input.length && $camera.length) {
    //             $input.val('');
    //             $camera.empty();
    //             try { Webcam.attach(CAMERA_SEL); } catch (_) {}
    //         }
    //     };

    //     // Capture / Recapture buttons (bind if present)
    //     $('#captureBtn').on('click', takeSnapshot);
    //     $('#recaptureBtn').on('click', retakeSnapshot);
    // }


        // ──────────────────────────────────────────────────────────────
    // Form Submission
    // ──────────────────────────────────────────────────────────────
    $(FORM_SEL).on('submit', function(e) {
        e.preventDefault();

        const form = $(this)[0];
        if (form.checkValidity() === false) {
            e.stopPropagation();
            $(this).addClass('was-validated');
            return;
        }

        let formData = new FormData(form);

        $.ajax({
            url: URL_BASE + 'save',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN
            },
            success: function(response) {
                Swal.fire({
                    toast: true,
                    icon: 'success',
                    title: response.message, 
                    animation: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                }).then(() => {
                    window.location.href = URL_BASE;
                });
            },
            error: function(xhr) {
                let errorMsg = 'An error occurred. Please try again.';
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMsg = xhr.responseJSON.error;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    errorMsg = Object.values(errors).join('<br>');
                }

                // Show an error pop-up
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    html: errorMsg,
                    confirmButtonColor: '#1C2A39'
                });
            }
        });
    });
});


