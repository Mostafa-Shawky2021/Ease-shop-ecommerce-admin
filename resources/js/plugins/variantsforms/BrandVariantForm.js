import Variant from './VariantForm';

class BrandVariant extends Variant {

    constructor(variantFormNode) {
        super(variantFormNode);
    }

    handleAddProductVariant(event) {

        event.preventDefault();

        let variantContainer = this.variantFormNode.querySelector('.variant-container');

        if (!this.inputVariantNode?.value.trim()) {

            alert('من افضلك ادخل قيمه')
            return;
        }

        variantContainer = !variantContainer
            ? this.createElement('div', 'variant-container', this.variantFormNode)
            : variantContainer;

        const variantWrapper = this.createElement(
            'div',
            ['variant-default', 'variant-brand'],
            variantContainer);

        variantWrapper.setAttribute('value', this.inputVariantNode.value);

        const productVariantSpan = this.createElement('span', 'brand-text-value', variantWrapper);

        const productVariantValueSpan = document.createTextNode(this.inputVariantNode.value);
        productVariantSpan.appendChild(productVariantValueSpan);

        this.inputVariantNode.value = '';

        const deleteButton = this.createElement('button', 'delete-btn', variantWrapper);
        deleteButton.innerHTML = '<i class="fa fa-close"></i>';

        this.registerDeleteEvent();
    }

}

export default BrandVariant;