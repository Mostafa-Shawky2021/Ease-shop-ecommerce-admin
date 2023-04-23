import { SelectProductVariants } from './plugins';
import {
    SizeVariantForm,
    ColorVariantForm,
    BrandVariantForm
} from './plugins/variantsforms';

import { BrandAjaxForm, CategoryAjaxForm } from './plugins/productform';

const colorsForm = document.getElementById('colorsForm');
const sizesForm = document.getElementById('sizesForm');
const brandsForm = document.getElementById('brandsForm');

const productBrandModal = document.getElementById('productBrandModal');
const productCategoryModal = document.getElementById('productCategoryModal');

const selectColorsOtionsWrapper = document.getElementById('selectColorsOtionsWrapper');
const selectSizesOptionWrapper = document.getElementById('selectSizesOptionWrapper');

sizesForm && new SizeVariantForm(sizesForm);
colorsForm && new ColorVariantForm(colorsForm);
brandsForm && new BrandVariantForm(brandsForm);

productBrandModal && new BrandAjaxForm(productBrandModal);
productCategoryModal && new CategoryAjaxForm(productCategoryModal);
selectColorsOtionsWrapper && new SelectProductVariants(selectColorsOtionsWrapper);
selectSizesOptionWrapper && new SelectProductVariants(selectSizesOptionWrapper);

