import axios from "axios";
import AbstractProductAjaxForm from "./AbstractProductAjaxForm";
import Pickr from "@simonwep/pickr/dist/pickr.es5.min";

import { productFormVariantUri } from "./data";

class ColorAjaxForm extends AbstractProductAjaxForm {
    constructor(productVariantModal) {
        super(productVariantModal);

        this._colorWrapperBox = productVariantModal.nextElementSibling;

        this._picker = Pickr.create({
            el: ".color-picker",
            theme: "classic",
            appClass: "color-picker-app",
            comparison: true,

            container: ".color-picker-wrapper",
            useAsButton: false,
            components: {
                preview: true,
                opacity: true,
                hue: true,
                palette: true,
                interaction: {
                    hex: true,
                    rgba: true,
                    input: true,
                    cancel: true,
                    save: true,
                },
            },
        });

        this._picker.on("save", (instance) => this._picker.hide());
        this._picker.on("cancel", (instance) => this._picker.hide());
        this._modalBootstrap = new bootstrap.Modal(
            document.getElementById("productColorModal")
        );
    }

    handleSaveProductVariantValue(event) {
        event.preventDefault();

        const colorVariantValue = this._variantInputNode.value;
        const chossenColorValue = this._picker.getColor().toHEXA().toString();

        if (!this.checkProductVariantValue(colorVariantValue)) return false;

        this.sendProductVariantAjax({
            color_name: colorVariantValue,
            color_value: chossenColorValue,
        });
    }

    // category value which will be send via ajax request
    async sendProductVariantAjax(valueData) {
        super.sendProductVariantAjax(valueData);

        try {
            const res = await axios.post(
                productFormVariantUri.ADD_COLOR,
                valueData
            );

            if (res.status === 201) {
                // in case no color exist there are element by default contain disabled attribut
                const isColorBoxWrapperIsEmpty =
                    this._colorWrapperBox.children[0].getAttribute("disabled");
                if (isColorBoxWrapperIsEmpty) {
                    this._colorWrapperBox.children[0].remove();
                }

                const { data } = res.data;

                this._colorWrapperBox.innerHTML += `<div class='product-variant' value='${data.id}'>
                    ${data.color_name}
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
                this._errorBox.innerHTML = `<div class='alert alert-danger'>
                ${this._errorMsg}
                </div>`;
            } else {
                console.log(error);
            }
        }
    }
}

export default ColorAjaxForm;
