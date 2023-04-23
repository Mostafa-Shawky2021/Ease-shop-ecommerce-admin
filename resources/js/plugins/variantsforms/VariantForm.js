class Variant {

    constructor(variantFormNode) {

        this.variantFormNode = variantFormNode;

        this.inputVariantNode = variantFormNode.querySelector('#variantInput');

        this.hiddenInputNode = variantFormNode.querySelector('#variantHiddenInput')

        this.saveButtonNode = variantFormNode.querySelector('#saveBtn');

        this.addButtonNode = variantFormNode.querySelector('#addProductVariant');

        this.editButtonNode = variantFormNode.querySelector('#editProductVariant');

        this.handleAddProductVariant = this.handleAddProductVariant.bind(this);

        this.saveProductVariant = this.saveProductVariant.bind(this);

        this.handleDeleteVariant = this.handleDeleteVariant.bind(this);

        this.registerDeleteEvent = this.registerDeleteEvent.bind(this);

        this.addButtonNode?.addEventListener('click', this.handleAddProductVariant);

        this.saveButtonNode?.addEventListener('click', this.saveProductVariant);

    }

    createElement(elementNode, classesName, parentNode) {

        const variantContainer = document.createElement(elementNode);
        variantContainer.classList.add(...(Array.isArray(classesName) ? classesName : [classesName]));
        parentNode.appendChild(variantContainer);
        return variantContainer;
    }

    registerDeleteEvent() {

        this.variantFormNode.querySelectorAll('.delete-btn').forEach(deletebtn => {
            deletebtn.addEventListener('click', this.handleDeleteVariant)
        });
    }

    handleDeleteVariant(event) {

        event.preventDefault();
        event.currentTarget.parentElement.remove();
    }

    saveProductVariant(event) {

        event.preventDefault();

        const variantValuesArray = Array.from(this.variantFormNode.querySelectorAll('.variant-default'));

        let variantValueString = '';

        if (variantValuesArray.length === 0) {
            alert('قم باضافة قيمة علي الاقل');
            return false;
        }

        variantValuesArray.forEach(variant =>
            variantValueString += variant.getAttribute('value') + '|');

        const trimmedVariantValueString = variantValueString.slice(0, variantValueString.length - 1);

        this.hiddenInputNode.value = trimmedVariantValueString;

        this.variantFormNode.submit();
    }

    handleAddProductVariant(event) { }


}

export default Variant;