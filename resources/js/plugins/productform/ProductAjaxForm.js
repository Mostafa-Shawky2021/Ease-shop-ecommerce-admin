class ProductAjaxForm {

    constructor(productVariantModal) {

        this.productVariantModal = productVariantModal;
        this._errorMsg = "";
        this._errorBox = productVariantModal.querySelector('.modal-body #error');
        this._variantInputNode = productVariantModal.querySelector('.modal-body #variantInput');
        this._saveBtnNode = productVariantModal.querySelector('.modal-body #btnSave');

        this.handleSaveProductVariantValue = this.handleSaveProductVariantValue.bind(this);
        this.handleCloseModal = this.handleOnCloseModal.bind(this);

        this._saveBtnNode?.addEventListener('click', this.handleSaveProductVariantValue);
        productVariantModal.addEventListener('hide.bs.modal', this.handleCloseModal);

    }

    handleOnCloseModal(event) {

        this._variantInputNode.value = '';
        this._errorMsg.innerHTML = '';
    }

    async sendProductVariantValue(variantValue) {
        this._saveBtnNode.querySelector('.icon').style.display = "none";
        this._saveBtnNode.querySelector('.spinner').style.display = "block";
    }

    handleSaveProductVariantValue(event) { }



}

export default ProductAjaxForm;