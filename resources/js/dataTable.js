import { Datatable } from './plugins';

const categoriesWrapper = document.getElementById('categoriesWrapper');
const productsWrapper = document.getElementById('productsWrapper');
const brandsWrapper = document.getElementById('brandsWrapper');
const colorsWrapper = document.getElementById('colorsWrapper');

categoriesWrapper && new Datatable(categoriesWrapper, 'categories-table', '/admin/categories/delete');
productsWrapper && new Datatable(productsWrapper, 'products-table', '/admin/products/delete');
colorsWrapper && new Datatable(colorsWrapper, null, '/admin/colors/delete');
brandsWrapper && new Datatable(brandsWrapper, null, '/admin/brands/delete');