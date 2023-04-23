import axios from 'axios';
import ProductAjaxForm from './ProductAjaxForm';
import { productFormVariantUri } from './data';

class BrandAjaxForm extends ProductAjaxForm {

    constructor(productVariantModal) {

        super(productVariantModal);

        this._brandSelectBox = productVariantModal.nextElementSibling;

        this._modalBootstrap = new bootstrap.Modal(document.getElementById('productBrandModal'))

    }

    handleSaveProductVariantValue(event) {

        event.preventDefault();

        const brandVariantValue = this._variantInputNode.value;

        if (!this.checkProductVariantValue(brandVariantValue)) return false;

        this.sendProductVariantValue({ brand_name: brandVariantValue });

    }

    async sendProductVariantValue(variantValue) {

        super.sendProductVariantValue(variantValue);

        try {

            const res = await axios.post(productFormVariantUri.ADD_BRAND, variantValue);

            if (res.status === 201) {
                const lastOption = this._brandSelectBox.length - 1;
                const isDisableOptionExist = this._brandSelectBox[lastOption].disabled;

                if (isDisableOptionExist) this._brandSelectBox[lastOption].remove();

                const { data } = res.data;
                const option = new Option(data.brand_name, data.id, false, true);
                this._brandSelectBox[lastOption] = option;

                this._saveBtnNode.querySelector('.icon').style.display = "block";
                this._saveBtnNode.querySelector('.spinner').style.display = "none";

                this._variantInputNode.value = "";
                this._modalBootstrap.hide();

            }

        } catch (error) {

            this._saveBtnNode.querySelector('.icon').style.display = "block";
            this._saveBtnNode.querySelector('.spinner').style.display = "none";

            if (error?.response?.status === 422) {
                this._errorMsg = error.response.data.message;
                this._errorBox.innerHTML =
                    `<div class='alert alert-danger'>
                ${this._errorMsg}
                </div>`

            } else {
                console.log(error);
            }
        }

    }
    checkProductVariantValue(value) {
        if (value.trim().length < 4) {
            this._errorMsg = 'يجب ان يكون عدد الحروف اكبر من 4';
            this._errorBox.innerHTML = `<div class='alert alert-danger'>${this._errorMsg}</div>`
            return false
        }
        return true;

    }

}

export default BrandAjaxForm;