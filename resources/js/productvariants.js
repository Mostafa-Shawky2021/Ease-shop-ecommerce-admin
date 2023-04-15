import { SelectProductVariants } from './plugins';
import { SizeVariant, ColorVariant, BrandVariant } from './plugins/variants';


const colorsForm = document.getElementById('colorsForm');
const sizesForm = document.getElementById('sizesForm');
const brandsForm = document.getElementById('brandsForm');

const selectColorsOtionsWrapper = document.getElementById('selectColorsOtionsWrapper');
const selectSizesOptionWrapper = document.getElementById('selectSizesOptionWrapper');

sizesForm && new SizeVariant(sizesForm);
colorsForm && new ColorVariant(colorsForm);
brandsForm && new BrandVariant(brandsForm);

selectColorsOtionsWrapper && new SelectProductVariants(selectColorsOtionsWrapper);
selectSizesOptionWrapper && new SelectProductVariants(selectSizesOptionWrapper);

