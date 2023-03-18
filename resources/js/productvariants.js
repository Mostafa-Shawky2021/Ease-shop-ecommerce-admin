import { ProductVariant } from './plugins';

const colorsForm = document.getElementById('colorsForm');
const sizesForm = document.getElementById('sizesForm');


colorsForm && new ProductVariant(colorsForm);
sizesForm && new ProductVariant(sizesForm);
