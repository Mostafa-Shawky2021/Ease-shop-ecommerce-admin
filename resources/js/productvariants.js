import { SelectProductVariants } from './plugins';
import {
    SizeVariantForm,
    ColorVariantForm,
    BrandVariantForm
} from './plugins/variantsforms';

import { BrandAjaxForm } from './plugins/productform';

const colorsForm = document.getElementById('colorsForm');
const sizesForm = document.getElementById('sizesForm');
const brandsForm = document.getElementById('brandsForm');

const productBrandModal = document.getElementById('productBrandModal');

const selectColorsOtionsWrapper = document.getElementById('selectColorsOtionsWrapper');
const selectSizesOptionWrapper = document.getElementById('selectSizesOptionWrapper');

sizesForm && new SizeVariantForm(sizesForm);
colorsForm && new ColorVariantForm(colorsForm);
brandsForm && new BrandVariantForm(brandsForm);

productBrandModal && new BrandAjaxForm(productBrandModal);

selectColorsOtionsWrapper && new SelectProductVariants(selectColorsOtionsWrapper);
selectSizesOptionWrapper && new SelectProductVariants(selectSizesOptionWrapper);

