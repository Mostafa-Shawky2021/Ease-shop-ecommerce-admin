import { ImageUploadView } from './plugins/image-upload-view';

const productImageFile = document.getElementById('productImage');
const productImagesFile = document.getElementById('productImages');
    
productImageFile && new ImageUploadView(productImageFile);
productImagesFile && new ImageUploadView(productImagesFile)









