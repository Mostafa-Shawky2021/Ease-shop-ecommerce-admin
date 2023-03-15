import { FileUploadView } from './plugins';

const productImageFile = document.getElementById('productImage');
const productImagesFile = document.getElementById('productImages');

productImageFile?.addEventListener('change', (event) => new FileUploadView(event));







