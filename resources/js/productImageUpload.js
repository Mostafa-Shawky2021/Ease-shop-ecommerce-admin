import { FileUploadView } from './plugins';

const productImageFile = document.getElementById('productImage');
const productImagesFile = document.getElementById('productImages');

productImageFile && new FileUploadView(productImageFile);
productImagesFile && new FileUploadView(productImagesFile)









