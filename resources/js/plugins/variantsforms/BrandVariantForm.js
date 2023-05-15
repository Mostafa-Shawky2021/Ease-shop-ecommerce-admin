import VariantForm from "./VariantForm";

class BrandVariant extends VariantForm {
    constructor(variantFormNode) {
        super(variantFormNode);
    }

    onAddProductVariant(event) {
        event.preventDefault();

        let variantContainer =
            this._variantFormNode.querySelector(".variant-container");

        if (!this._inputVariantNode?.value.trim()) {
            alert("من افضلك ادخل قيمه");
            return;
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
            ["variant-default", "variant-brand"],
            variantContainer
        );

        variantWrapper.setAttribute("value", this._inputVariantNode.value);

        const productVariantSpan = this.createElement(
            "span",
            "brand-text-value",
            variantWrapper
        );

        const productVariantValueSpan = document.createTextNode(
            this._inputVariantNode.value
        );
        productVariantSpan.appendChild(productVariantValueSpan);

        this._inputVariantNode.value = "";

        const deleteButton = this.createElement(
            "button",
            "delete-btn",
            variantWrapper
        );
        deleteButton.innerHTML = '<i class="fa fa-close"></i>';

        this.registerDeleteEvent();
    }
}

export default BrandVariant;
