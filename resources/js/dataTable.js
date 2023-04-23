import { Datatable } from './plugins';
import { dataTableUri } from './data';

const categoriesWrapper = document.getElementById('categoriesWrapper');
const productsWrapper = document.getElementById('productsWrapper');
const brandsWrapper = document.getElementById('brandsWrapper');
const colorsWrapper = document.getElementById('colorsWrapper');
const trashedProductsWrapper = document.getElementById('trashedProductsWrapper');
const ordersWrapper = document.getElementById('ordersWrapper');

categoriesWrapper && new Datatable(categoriesWrapper, 'categories-table', dataTableUri.DELETE_CATEGORIES);
productsWrapper && new Datatable(productsWrapper, 'products-table', dataTableUri.DELETE_PRODUCTS);
trashedProductsWrapper && new Datatable(trashedProductsWrapper, 'products-table', dataTableUri.DELETE_TRASHED_PRODUCTS, URI.RESTORE_PRODUCTS);

colorsWrapper && new Datatable(colorsWrapper, null, dataTableUri.DELETE_COLORS);
brandsWrapper && new Datatable(brandsWrapper, null, dataTableUri.DELETE_BRANDS);
ordersWrapper && new Datatable(ordersWrapper, 'orders-table', dataTableUri.DELETE_ORDERS);