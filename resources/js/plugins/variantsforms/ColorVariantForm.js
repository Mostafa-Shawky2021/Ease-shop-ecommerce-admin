import Pickr from "@simonwep/pickr/dist/pickr.es5.min";
import VariantForm from "./VariantForm";

class ColorVariant extends VariantForm {
    constructor(variantFormNode) {
        super(variantFormNode);
        this._editButtonNode = variantFormNode.querySelector("#editBtn");

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

        //bindings
        this.onEditColorVaraint = this.onEditColorVaraint.bind(this);

        //event listeners
        this._editButtonNode?.addEventListener(
            "click",
            this.onEditColorVaraint
        );

        this.loadProductVariant();
    }

    loadProductVariant() {
        // in case user edit color variant
        if (!this._hiddenInputNode.value.trim()) return false;
        const colorValue = this._hiddenInputNode.value.split(",");

        this._picker.setColor(colorValue[1]);
        this._picker.options.default = colorValue[1];
    }

    onEditColorVaraint(event) {
        event.preventDefault();

        const colorName = this._inputVariantNode.value.trim();
        if (!colorName) {
            alert("لا يجب ان يكون اسم اللون فارغاً");
            return false;
        }
        const colorPickerValue = this._picker.getColor().toHEXA().toString();

        this._hiddenInputNode.value = `${colorName},${colorPickerValue}`;

        this._variantFormNode.submit();
    }

    // user click on add variant btn
    onAddProductVariant(event) {
        event.preventDefault();
        let variantContainer =
            this._variantFormNode.querySelector(".variant-container");
        const chossenColorValue = this._picker.getColor().toHEXA().toString();
        const colorName = this._inputVariantNode.value;

        if (!colorName.trim()) {
            alert("يجب اختيار قيمة للون وكتابة الاسم");
            return false;
        }

        variantContainer = !variantContainer
            ? this.createElement(
                  "div",
                  "variant-container",
                  this._variantFormNode
              )
            : variantContainer;

        const variantWrapper = this.createElement(
            "div",
            [
                "variant-default",
                "color-variant",
                "d-flex",
                "align-items-center",
            ],
            variantContainer
        );

        variantWrapper.setAttribute(
            "value",
            `${colorName},${chossenColorValue}`
        );

        // Represent the box color which the use choose from color picker
        const colorBoxNode = this.createElement(
            "div",
            "color-box",
            variantWrapper
        );
        colorBoxNode.style.backgroundColor = chossenColorValue;

        const colorTextWrapper = this.createElement(
            "div",
            "color-text-value",
            variantWrapper
        );
        const colorTextValueName = document.createTextNode(colorName);
        colorTextWrapper.appendChild(colorTextValueName);

        const deleteButton = this.createElement(
            "button",
            "delete-btn",
            variantWrapper
        );
        deleteButton.innerHTML = '<i class="fa fa-close"></i>';
        this._inputVariantNode.value = "";
        this.registerDeleteEvent();
    }
}

export default ColorVariant;
