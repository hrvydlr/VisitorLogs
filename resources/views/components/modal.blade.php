<div class="modal fade modal-wrapper" id="{{ $modal_id ?? 'modalContainer' }}"
    tabindex="-1" aria-labelledby="{{ $modal_id ?? 'modalContainer' }}-label" role="dialog" aria-hidden="true" style="display:none">
    <div class="modal-dialog {{ $modal_size ?? 'modal-xl' }}">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formTitle">{{ $form_title ?? '' }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-0">
                <div class="modal-content" id="content-container">{!! $form_content ?? '' !!}</div>
                <div class="button-container"></div>
            </div>
        </div>
    </div>
</div>