class SelectProductVariants {
    constructor(productVariantNode) {

        this.selectedVariantValue = [];

        this.productVariantNode = productVariantNode;
        this.productVariant = productVariantNode.querySelectorAll('.product-variant');
        this.hiddenInputProductVariant = productVariantNode.querySelector('#variantHiddenInput');

        this.handleProductVariant = this.handleProductVariant.bind(this);

        this.productVariant.forEach((variantNode) => (
            variantNode.addEventListener('click', this.handleProductVariant))
        );

        this.checkFirstLoad()

    }

    checkFirstLoad() {
        const hiddenInputValue = this.hiddenInputProductVariant.value;
        if (hiddenInputValue.trim()) {
            this.selectedVariantValue = hiddenInputValue.split('|');

            this.productVariant.forEach(variant => {
                if (this.selectedVariantValue.includes(variant.getAttribute('value'))) {
                    variant.classList.add('selected-variant');
                }
            })
        }
    }

    handleProductVariant(event) {
        const selectedVariant = event.target;
        selectedVariant.classList.toggle('selected-variant');
        const valueExist = this.selectedVariantValue.findIndex((value) =>
            value === Number(selectedVariant.getAttribute('value')));

        if (selectedVariant.classList.contains('selected-variant')) {
            // check if exist in the array

            if (valueExist < 0) this
                .selectedVariantValue
                .push(Number(selectedVariant.getAttribute('value')));

        } else {

            if (valueExist >= 0) this.selectedVariantValue.splice(valueExist, 1);
        }

        this.handleVariantHiddenInput();
    }

    handleVariantHiddenInput() {
        this.hiddenInputProductVariant.value = this.selectedVariantValue.join("|");

    }
}


export default SelectProductVariants