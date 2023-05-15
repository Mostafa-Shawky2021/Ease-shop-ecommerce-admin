class VariantForm {
    constructor(variantFormNode) {
        this._variantFormNode = variantFormNode;

        // the displayed user input field which user will type the product variant value
        this._inputVariantNode = variantFormNode.querySelector("#variantInput");

        // will be used to deal with the product variant and will be send via default form request
        // will be used also to get the old data in case user want to update
        this._hiddenInputNode = variantFormNode.querySelector(
            "#variantHiddenInput"
        );

        this._saveButtonNode = variantFormNode.querySelector("#saveBtn");

        this._addButtonNode =
            variantFormNode.querySelector("#addProductVariant");

        // bindings
        this.onAddProductVariant = this.onAddProductVariant.bind(this);

        this.onSaveProductVariant = this.onSaveProductVariant.bind(this);

        this.onDeleteProductVariant = this.onDeleteProductVariant.bind(this);

        this.registerDeleteEvent = this.registerDeleteEvent.bind(this);

        // event listeners
        this._addButtonNode?.addEventListener(
            "click",
            this.onAddProductVariant
        );
        this._saveButtonNode?.addEventListener(
            "click",
            this.onSaveProductVariant
        );
    }

    createElement(elementNode, classesName, parentNode) {
        const variantContainer = document.createElement(elementNode);
        variantContainer.classList.add(
            ...(Array.isArray(classesName) ? classesName : [classesName])
        );
        parentNode.appendChild(variantContainer);
        return variantContainer;
    }

    registerDeleteEvent() {
        this._variantFormNode
            .querySelectorAll(".delete-btn")
            .forEach((deletebtn) => {
                deletebtn.addEventListener(
                    "click",
                    this.onDeleteProductVariant
                );
            });
    }

    onDeleteProductVariant(event) {
        event.preventDefault();
        event.currentTarget.parentElement.remove();
    }
    // submit product variant value
    onSaveProductVariant(event) {
        event.preventDefault();

        const variantValuesArray = Array.from(
            this._variantFormNode.querySelectorAll(".variant-default")
        );

        if (variantValuesArray.length === 0) {
            alert("قم باضافة قيمة علي الاقل");
            return false;
        }

        let variantValueString = "";

        // iterate throught each variant button and get data attribute value from it
        variantValuesArray.forEach(
            (variant) =>
                (variantValueString += variant.getAttribute("value") + "|")
        );

        const trimmedVariantValueString = variantValueString.slice(
            0,
            variantValueString.length - 1
        );

        this._hiddenInputNode.value = trimmedVariantValueString;

        this._variantFormNode.submit();
    }

    onAddProductVariant(event) {}
}

export default VariantForm;
