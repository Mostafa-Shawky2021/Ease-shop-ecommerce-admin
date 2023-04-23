<div class="modal fade" id="{{ $id }}" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    {{ $title }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="error"></div>
                <div>
                    <label class="label-control">{{ $labelName }}</label>
                    <input class="form-control mt-2" id="variantInput" />
                    <button type="button" id="btnSave"
                        class="btn-add mt-3 d-flex">
                        حفظ
                        <i class="fa fa-plus icon"></i>
                        <div class="spinner">
                            <i class="fa fa-spinner fa-spin icon"></i>
                        </div>
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
