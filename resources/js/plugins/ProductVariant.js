class ProductVariant {

    constructor(WrapperProductVariant) {

        this.variantFormNode = WrapperProductVariant;

        this.inputVariantNode = WrapperProductVariant.querySelector('#variantInput');

        this.hiddenInputNode = WrapperProductVariant.querySelector('#variantHiddenInput')

        this.saveButtonNode = WrapperProductVariant.querySelector('#saveBtn');

        this.addProductNode = WrapperProductVariant.querySelector('#addProductVariant');

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
        variantWrapper.className = "variant-wrapper";
        variantContainer.appendChild(variantWrapper);

        variantWrapper.innerHTML += `
            <button class="delete-btn">
                <i class="fa fa-close"></i>
            </button>
            <span class='variant-value' value=${this.inputVariantNode.value}>
                ${this.inputVariantNode.value}
            </span>`;

        this.inputVariantNode.value = '';
        variantWrapper.addEventListener('click', this.handleDeleteVariant);

    }
    handleDeleteVariant(event) {

        event.preventDefault();
        event.currentTarget.remove();

    }

    saveProductVariant(event) {

        event.preventDefault();

        const variantValuesArrayWrapper = Array.from(this.variantFormNode.querySelectorAll('.variant-wrapper'));
        let variantValueString = '';
        if (variantValuesArrayWrapper.length === 0) {
            alert('قم باضافة قيمة علي الاقل');
            return;
        }
        variantValuesArrayWrapper.forEach(variant => {

            variantValueString += variant.querySelector('.variant-value').getAttribute('value') + '|';
        })
        const trimmedVariantValueString = variantValueString.slice(0, variantValueString.length - 1);

        this.hiddenInputNode.value = trimmedVariantValueString;

        this.variantFormNode.submit();
    }
}


export default ProductVariant;