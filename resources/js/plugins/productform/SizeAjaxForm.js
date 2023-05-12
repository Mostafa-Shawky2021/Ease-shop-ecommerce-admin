import axios from "axios";
import ProductAjaxForm from "./ProductAjaxForm";

import { productFormVariantUri } from "./data";

class ColorAjaxForm extends ProductAjaxForm {
    constructor(productVariantModal) {
        super(productVariantModal);

        this._sizeWrapperBox = productVariantModal.nextElementSibling;

        this._modalBootstrap = new bootstrap.Modal(
            document.getElementById("productSizeModal")
        );
    }

    handleSaveProductVariantValue(event) {
        event.preventDefault();
        const sizeVariantValue = this._variantInputNode.value;
        if (!this.checkProductVariantValue(sizeVariantValue)) return false;
        this.sendProductVariantAjax({ size_name: sizeVariantValue });
    }

    // category value which will be send via ajax request
    async sendProductVariantAjax(valueData) {
        super.sendProductVariantAjax(valueData);

        try {
            const res = await axios.post(
                productFormVariantUri.ADD_SIZE,
                valueData
            );

            if (res.status === 201) {
                const isColorBoxWrapperIsEmpty =
                    this._sizeWrapperBox.children[0].getAttribute("disabled");
                if (isColorBoxWrapperIsEmpty) {
                    this._sizeWrapperBox.children[0].remove();
                }

                const { data } = res.data;

                this._sizeWrapperBox.innerHTML += `<div class='product-variant' value='${data.id}'>
                    ${data.size_name}
                 </div>`;

                this._saveBtnNode.querySelector(".icon").style.display =
                    "block";
                this._saveBtnNode.querySelector(".spinner").style.display =
                    "none";

                this._variantInputNode.value = "";
                this._modalBootstrap.hide();
            }
        } catch (error) {
            this._saveBtnNode.querySelector(".icon").style.display = "block";
            this._saveBtnNode.querySelector(".spinner").style.display = "none";
            // error validation rules
            if (error?.response?.status === 422) {
                this._errorMsg = error.response.data.message;
                this._errorBox.innerHTML = `<div class='alert alert-danger alert-dismissible fade show' role='start'>
                    ${this._errorMsg}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`;
            } else {
                console.log(error);
            }
        }
    }
}

export default ColorAjaxForm;
