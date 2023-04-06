class ProductVariant {

    constructor(variantFormNode) {

        this.variantFormNode = variantFormNode;

        this.inputVariantNode = variantFormNode.querySelector('#variantInput');

        this.hiddenInputNode = variantFormNode.querySelector('#variantHiddenInput')

        this.saveButtonNode = variantFormNode.querySelector('#saveBtn');

        this.addProductNode = variantFormNode.querySelector('#addProductVariant');

        this.handleAddProductVariant = this.handleAddProductVariant.bind(this);

        this.saveProductVariant = this.saveProductVariant.bind(this);

        this.addProductNode.addEventListener('click', this.handleAddProductVariant);

        this.saveButtonNode.addEventListener('click', this.saveProductVariant);

    }

    handleAddProductVariant(event) {

        event.preventDefault();

        let variantContainer = this.variantFormNode.querySelector('.variant-container');
        if (!this.inputVariantNode.value.trim()) {

            alert('من افضلك ادخل قيمه')
            return;
        }
        if (!variantContainer) {

            variantContainer = document.createElement('div');
            variantContainer.className = "variant-container";
            this.variantFormNode.appendChild(variantContainer);
        }

        const variantWrapper = document.createElement('div');
        variantWrapper.classList.add("variant-default");

        variantContainer.appendChild(variantWrapper);
        variantWrapper.setAttribute('value', this.inputVariantNode.value);

        const productVariantSpan = document.createElement('span');
        const productVariantValueSpan = document.createTextNode(this.inputVariantNode.value);
        productVariantSpan.appendChild(productVariantValueSpan);
        variantWrapper.appendChild(productVariantSpan);

        variantWrapper.innerHTML += `
            <button class="delete-btn">
                <i class="fa fa-close"></i>
            </button>`

        this.inputVariantNode.value = '';

        this.variantFormNode.querySelectorAll('.delete-btn').forEach(deletebtn => {

            deletebtn.addEventListener('click', this.handleDeleteVariant);
        })

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
        variantValuesArray.forEach(variant => {

            variantValueString += variant.getAttribute('value') + '|';
        });

        const trimmedVariantValueString = variantValueString.slice(0, variantValueString.length - 1);

        this.hiddenInputNode.value = trimmedVariantValueString;

        this.variantFormNode.submit();
    }
}

export default ProductVariant;