import { ImageUploadView } from './plugins/image-upload-view';

const categoryImageFile = document.getElementById('categoryImage');
const thumbnailCategoryImageFile = document.getElementById('thumbnailCategoryImage');
const topCategoryImageFile = document.getElementById('topCategoryImageFile');

// Show Category Image in Modal box
categoryImageFile && new ImageUploadView(categoryImageFile);
thumbnailCategoryImageFile && new ImageUploadView(thumbnailCategoryImageFile);
topCategoryImageFile && new ImageUploadView(topCategoryImageFile);