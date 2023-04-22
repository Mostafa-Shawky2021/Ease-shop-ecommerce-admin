import { Datatable } from './plugins';
import { URI } from './data';

const categoriesWrapper = document.getElementById('categoriesWrapper');
const productsWrapper = document.getElementById('productsWrapper');
const brandsWrapper = document.getElementById('brandsWrapper');
const colorsWrapper = document.getElementById('colorsWrapper');
const trashedProductsWrapper = document.getElementById('trashedProductsWrapper');
const ordersWrapper = document.getElementById('ordersWrapper');

categoriesWrapper && new Datatable(categoriesWrapper, 'categories-table', URI.DELETE_CATEGORIES);
productsWrapper && new Datatable(productsWrapper, 'products-table', URI.DELETE_PRODUCTS);
trashedProductsWrapper && new Datatable(trashedProductsWrapper, 'products-table', URI.DELETE_TRASHED_PRODUCTS, URI.RESTORE_PRODUCTS);

colorsWrapper && new Datatable(colorsWrapper, null, URI.DELETE_COLORS);
brandsWrapper && new Datatable(brandsWrapper, null, URI.DELETE_BRANDS);
ordersWrapper && new Datatable(ordersWrapper, 'orders-table', URI.DELETE_ORDERS);