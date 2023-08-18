import {
    SizeVariantForm,
    ColorVariantForm,
    BrandVariantForm,
} from "./plugins/products-variants-forms";



const colorsForm = document.getElementById("colorsForm");
const sizesForm = document.getElementById("sizesForm");
const brandsForm = document.getElementById("brandsForm");


sizesForm && new SizeVariantForm(sizesForm);
colorsForm && new ColorVariantForm(colorsForm);
brandsForm && new BrandVariantForm(brandsForm);



