import { FileUploadView } from './plugins';

const categoryImageFile = document.getElementById('categoryImage');


categoryImageFile && new FileUploadView(categoryImageFile);