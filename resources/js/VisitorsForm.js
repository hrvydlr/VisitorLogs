
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
    //         Webcam.set({ width: 320, height: 240, image_format: 'jpeg', jpeg_quality: 90 });
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


        // Save form
        $(FORM_SEL).on('submit', function (e) {
            e.preventDefault();
          
            common.saveForm(URL_BASE + 'save',TABLE_SEL,FORM_SEL,new FormData(this));
        });

        
    
});

