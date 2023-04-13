import { FileUploadView } from './plugins';

const categoryImageFile = document.getElementById('categoryImage');
const thumbnailCategoryImageFile = document.getElementById('thumbnailCategoryImage');

categoryImageFile && new FileUploadView(categoryImageFile);
thumbnailCategoryImageFile && new FileUploadView(thumbnailCategoryImageFile);