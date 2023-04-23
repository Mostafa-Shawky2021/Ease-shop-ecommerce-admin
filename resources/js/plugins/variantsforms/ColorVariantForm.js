import Pickr from "@simonwep/pickr/dist/pickr.es5.min";
import Variant from "./VariantForm";

class ColorVariant extends Variant {

    constructor(variantFormNode) {

        super(variantFormNode);

        this.editButtonNode = this.variantFormNode?.querySelector('#editBtn');

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
                    hex: true,
                    rgba: true,
                    input: true,
                    cancel: true,
                    save: true
                }
            }
        });

        this.picker.on('save', (instance) => this.picker.hide());

        this.handleEditColorVaraint = this.handleEditColorVaraint.bind(this);

        this.editButtonNode?.addEventListener('click', this.handleEditColorVaraint)

        this.loadProductVariant();
    }

    loadProductVariant() {

        if (!this.hiddenInputNode.value.trim()) return false;
        const colorValue = this.hiddenInputNode.value.split(',');

        this.picker.setColor(colorValue[1]);
        this.picker.options.default = colorValue[1];

    }

    handleEditColorVaraint(event) {

        event.preventDefault();

        const colorName = this.inputVariantNode.value.trim();
        if (!colorName) {
            alert('لا يجب ان يكون اسم اللون فارغاً')
            return false;
        }
        const colorPickerValue = this.picker.getColor().toHEXA().toString();

        this.hiddenInputNode.value = `${colorName},${colorPickerValue}`;

        this.variantFormNode.submit();
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