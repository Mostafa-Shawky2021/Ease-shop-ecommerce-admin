class SelectProductVariants {
    constructor(productVariantNode) {
        // handle select product variant in add product page
        this._selectedVariantValueArr = [];
        // the parent wrapper of select element
        this._productVariantNode = productVariantNode;
        this._boxWrapper = productVariantNode.querySelector("#boxWrapper");
        this._productVariantBox =
            productVariantNode.querySelectorAll(".product-variant");
        // will be used to send data via form request after manipulation the selected varaint
        this._hiddenInputProductVariant = productVariantNode.querySelector(
            "#variantHiddenInput"
        );

        // binding
        this.onAddProductVariant = this.onAddProductVariant.bind(this);

        // event listeners
        this._boxWrapper?.addEventListener("click", this.onAddProductVariant);

        this.checkFirstLoad();
    }

    // if user edit product or redirect page on error form validation
    checkFirstLoad() {
        const hiddenInputValue = this._hiddenInputProductVariant.value;
        if (hiddenInputValue.trim()) {
            // convert the string from hidden input to array
            this._selectedVariantValueArr = hiddenInputValue
                .split("|")
                .map((value) => Number(value));

            // loop through each box if its value exist in _selectedVariantValueArr add class selected-variant
            this._productVariantBox.forEach((variant) => {
                const selectedValueArr = this._selectedVariantValueArr;
                const variantValueNumeric = Number(
                    variant.getAttribute("value")
                );
                if (selectedValueArr.includes(variantValueNumeric)) {
                    variant.classList.add("selected-variant");
                }
            });
        }
    }

    onAddProductVariant(event) {
        const selectedVariant = event.target;

        if (!selectedVariant.classList.contains("product-variant"))
            return false;

        selectedVariant.classList.toggle("selected-variant");

        const valueExist = this._selectedVariantValueArr.findIndex(
            (value) => value === Number(selectedVariant.getAttribute("value"))
        );

        if (selectedVariant.classList.contains("selected-variant")) {
            // push value to selected variant value list if list dosen't contain that value
            if (valueExist < 0)
                this._selectedVariantValueArr.push(
                    Number(selectedVariant.getAttribute("value"))
                );
        } else {
            // value exist in selected value array then remove it
            if (valueExist >= 0)
                this._selectedVariantValueArr.splice(valueExist, 1);
        }

        this._hiddenInputProductVariant.value =
            this._selectedVariantValueArr.join("|");
    }
}

export default SelectProductVariants;
