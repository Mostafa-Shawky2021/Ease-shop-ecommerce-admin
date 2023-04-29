class ProductAjaxForm {

    constructor(productVariantModal) {

        this._productVariantModal = productVariantModal;
        this._errorMsg = "";
        this._errorBox = this._productVariantModal.querySelector('.modal-body #error');
        this._variantInputNode = this._productVariantModal.querySelector('.modal-body #variantInput');
        this._saveBtnNode = this._productVariantModal.querySelector('.modal-body #btnSave');

        this.handleSaveProductVariantValue = this.handleSaveProductVariantValue.bind(this);
        this.handleCloseModal = this.handleOnCloseModal.bind(this);

        this._saveBtnNode?.addEventListener('click', this.handleSaveProductVariantValue);
        this._productVariantModal.addEventListener('hide.bs.modal', this.handleCloseModal);

    }

    handleOnCloseModal(event) {

        this._variantInputNode.value = '';
        this._errorBox.innerHTML = '';
    }

    async sendProductVariantValue(variantValue) {
        this._saveBtnNode.querySelector('.icon').style.display = "none";
        this._saveBtnNode.querySelector('.spinner').style.display = "block";
    }

    handleSaveProductVariantValue(event) { }



}

export default ProductAjaxForm;