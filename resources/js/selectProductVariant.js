import { SelectProductVariant } from "./plugins/select-product-variant";

const selectColorsOtionsWrapper = document.getElementById("selectColorsOtionsWrapper");
const selectSizesOptionWrapper = document.getElementById("selectSizesOptionWrapper");

selectColorsOtionsWrapper && new SelectProductVariant(selectColorsOtionsWrapper);
selectSizesOptionWrapper && new SelectProductVariant(selectSizesOptionWrapper);