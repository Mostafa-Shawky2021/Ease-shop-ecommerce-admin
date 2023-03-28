import { ProductVariant, SelectProductVariants } from './plugins';

const colorsForm = document.getElementById('colorsForm');
const sizesForm = document.getElementById('sizesForm');
const brandsForm = document.getElementById('brandsForm');

const selectColorsOtionsWrapper = document.getElementById('selectColorsOtionsWrapper');
const selectSizesOptionWrapper = document.getElementById('selectSizesOptionWrapper');

colorsForm && new ProductVariant(colorsForm);
sizesForm && new ProductVariant(sizesForm);
brandsForm && new ProductVariant(brandsForm);

selectColorsOtionsWrapper && new SelectProductVariants(selectColorsOtionsWrapper);
selectSizesOptionWrapper && new SelectProductVariants(selectSizesOptionWrapper);

