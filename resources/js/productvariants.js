import { SelectProductVariants } from "./plugins";
import {
    SizeVariantForm,
    ColorVariantForm,
    BrandVariantForm,
} from "./plugins/variantsforms";

import {
    BrandAjaxForm,
    CategoryAjaxForm,
    ColorAjaxForm,
    SizeAjaxForm,
} from "./plugins/productform";

const colorsForm = document.getElementById("colorsForm");
const sizesForm = document.getElementById("sizesForm");
const brandsForm = document.getElementById("brandsForm");

const productBrandModal = document.getElementById("productBrandModal");
const productCategoryModal = document.getElementById("productCategoryModal");
const productColorModal = document.getElementById("productColorModal");
const productSizeModal = document.getElementById("productSizeModal");

const selectColorsOtionsWrapper = document.getElementById(
    "selectColorsOtionsWrapper"
);
const selectSizesOptionWrapper = document.getElementById(
    "selectSizesOptionWrapper"
);

sizesForm && new SizeVariantForm(sizesForm);
colorsForm && new ColorVariantForm(colorsForm);
brandsForm && new BrandVariantForm(brandsForm);

// add product varaiant with ajax request
productBrandModal && new BrandAjaxForm(productBrandModal);
productCategoryModal && new CategoryAjaxForm(productCategoryModal);
productColorModal && new ColorAjaxForm(productColorModal);
productSizeModal && new SizeAjaxForm(productSizeModal);

selectColorsOtionsWrapper &&
    new SelectProductVariants(selectColorsOtionsWrapper);
selectSizesOptionWrapper && new SelectProductVariants(selectSizesOptionWrapper);
