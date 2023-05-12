class ProductAjaxForm {
    constructor(productVariantModal) {
        this._productVariantModal = productVariantModal;

        this._errorBox =
            this._productVariantModal.querySelector(".modal-body #error");
        this._variantInputNode = this._productVariantModal.querySelector(
            ".modal-body #variantInput"
        );
        this._saveBtnNode = this._productVariantModal.querySelector(
            ".modal-body #btnSave"
        );

        // Binding methods
        this.handleSaveProductVariantValue =
            this.handleSaveProductVariantValue.bind(this);
        this.handleCloseModal = this.handleOnCloseModal.bind(this);

        // Event Listeners
        this._saveBtnNode?.addEventListener(
            "click",
            this.handleSaveProductVariantValue
        );

        this._productVariantModal.addEventListener(
            "hide.bs.modal",
            this.handleCloseModal
        );
    }
    // validate product variant input
    checkProductVariantValue(value) {
        if (value.trim().length < 4) {
            const errMsg = "يجب ان يكون عدد الحروف اكبر من 4";
            this._errorBox.innerHTML = `
            <div class='alert alert-danger alert-dismissible fade show' role="alert">
                ${errMsg}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
            return false;
        }
        return true;
    }

    handleOnCloseModal() {
        this._variantInputNode.value = "";
        this._errorBox.innerHTML = "";
    }

    // Accept the value we want to send via ajax
    async sendProductVariantAjax(valueData) {
        // show loading indicator on ajax request
        this._saveBtnNode.querySelector(".icon").style.display = "none";
        this._saveBtnNode.querySelector(".spinner").style.display = "block";
    }

    handleSaveProductVariantValue(event) {}
}

export default ProductAjaxForm;
