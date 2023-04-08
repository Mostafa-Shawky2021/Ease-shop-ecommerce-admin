import Pickr from "@simonwep/pickr/dist/pickr.es5.min";
import Variant from "./Variant";

class ColorVariant extends Variant {

    constructor(variantFormNode) {

        super(variantFormNode);

        this.picker = Pickr.create({
            el: '.color-picker',
            theme: 'classic',
            appClass: 'color-picker-app',
            comparison: true,
            container: '.color-picker-wrapper',
            useAsButton: false,
            components: {
                preview: true,
                opacity: true,
                hue: true,
                palette: true,
                interaction: {
                    hex: false,
                    rgba: true,
                    input: true,
                    clear: false,
                    save: false,
                    cancel: true
                }
            }
        });

    }

    handleAddProductVariant(event) {

        event.preventDefault();
        let variantContainer = this.variantFormNode.querySelector('.variant-container');
        const chossenColorValue = this.picker.getColor().toHEXA().toString();
        const colorName = this.inputVariantNode.value;

        if (!colorName.trim()) {
            alert('يجب اختيار قيمة للون وكتابة الاسم');
            return false;
        }

        variantContainer = !variantContainer
            ? this.createElement('div', 'variant-container', this.variantFormNode)
            : variantContainer;

        const variantWrapper = this.createElement(
            'div',
            ['variant-default', 'color-variant', 'd-flex', 'align-items-center'],
            variantContainer);

        variantWrapper.setAttribute('value', `${colorName},${chossenColorValue}`);

        // Represent the box color which the use choose from color picker
        const colorBoxNode = this.createElement('div', 'color-box', variantWrapper);
        colorBoxNode.style.backgroundColor = chossenColorValue;

        const colorTextWrapper = this.createElement('div', 'color-text-value', variantWrapper);
        const colorTextValueName = document.createTextNode(colorName);
        colorTextWrapper.appendChild(colorTextValueName);

        const deleteButton = this.createElement('button', 'delete-btn', variantWrapper);
        deleteButton.innerHTML = '<i class="fa fa-close"></i>';

        this.registerDeleteEvent();
    }
}

export default ColorVariant;