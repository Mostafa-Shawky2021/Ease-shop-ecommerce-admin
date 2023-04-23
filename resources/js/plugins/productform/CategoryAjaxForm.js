import axios from 'axios';
import ProductAjaxForm from './ProductAjaxForm';
import { productFormVariantUri } from './data';

class CategoryAjaxForm extends ProductAjaxForm {

    constructor(productVariantModal) {

        super(productVariantModal);

        this._categorySelectBox = productVariantModal.nextElementSibling;
        this._modalBootstrap = new bootstrap.Modal(document.getElementById('productCategoryModal'));

    }

    handleSaveProductVariantValue(event) {

        event.preventDefault();

        const categoryVariantValue = this._variantInputNode.value;

        if (!this.checkProductVariantValue(categoryVariantValue)) return false;

        this.sendProductVariantValue({ cat_name: categoryVariantValue });

    }

    async sendProductVariantValue(variantValue) {

        super.sendProductVariantValue(variantValue);

        try {

            const res = await axios.post(productFormVariantUri.ADD_CATEGORY, variantValue);

            if (res.status === 201) {
                const lastOption = this._categorySelectBox.length - 1;
                const isDisableOptionExist = this._categorySelectBox[lastOption].disabled;

                if (isDisableOptionExist) this._categorySelectBox[lastOption].remove();

                const { data } = res.data;
                const option = new Option(data.cat_name, data.id, false, true);
                this._categorySelectBox[lastOption] = option;

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

export default CategoryAjaxForm;