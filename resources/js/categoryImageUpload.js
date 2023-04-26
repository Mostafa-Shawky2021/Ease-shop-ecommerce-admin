import { FileUploadView } from './plugins';

const categoryImageFile = document.getElementById('categoryImage');
const thumbnailCategoryImageFile = document.getElementById('thumbnailCategoryImage');
const topCategoryImageFile = document.getElementById('topCategoryImageFile');

categoryImageFile && new FileUploadView(categoryImageFile);
thumbnailCategoryImageFile && new FileUploadView(thumbnailCategoryImageFile);
topCategoryImageFile && new FileUploadView(topCategoryImageFile);