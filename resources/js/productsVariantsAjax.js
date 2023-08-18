import {
    BrandAjaxForm,
    CategoryAjaxForm,
    ColorAjaxForm,
    SizeAjaxForm,
} from "./plugins/add-product-variant-ajax";

const productBrandModal = document.getElementById("productBrandModal");
const productCategoryModal = document.getElementById("productCategoryModal");
const productColorModal = document.getElementById("productColorModal");
const productSizeModal = document.getElementById("productSizeModal");

productBrandModal && new BrandAjaxForm(productBrandModal);
productCategoryModal && new CategoryAjaxForm(productCategoryModal);
productColorModal && new ColorAjaxForm(productColorModal);
productSizeModal && new SizeAjaxForm(productSizeModal);