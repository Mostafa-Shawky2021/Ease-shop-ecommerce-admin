<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="font-size:0.85rem;">
                    {{ $title }}
                </h5>
                <a class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <div id="error"></div>
                <div>
                    <label class="label-control" style="font-size:0.8rem; color:#555">{{ $labelName }}</label>
                    <input class="form-control mt-2" id="variantInput" />

                    <button id="btnSave" class="btn-add mt-3 d-flex align-items-center"
                        style="font-size:0.9rem;border-radius:8px">
                        حفظ
                        <i class="fa fa-plus icon" style="margin-top:2px; margin-right:3px;"></i>
                        <div class="spinner">
                            <i class="fa fa-spinner fa-spin icon"></i>
                        </div>
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>