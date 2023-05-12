import { Datatable } from "./plugins";
import { dataTableUri } from "./data";

const categoriesWrapper = document.getElementById("categoriesWrapper");
const productsWrapper = document.getElementById("productsWrapper");
const brandsWrapper = document.getElementById("brandsWrapper");
const colorsWrapper = document.getElementById("colorsWrapper");
const sizesWrapper = document.getElementById("sizesWrapper");
const trashedProductsWrapper = document.getElementById(
    "trashedProductsWrapper"
);
const notificationsWrapper = document.getElementById("notificationsWrapper");
const ordersWrapper = document.getElementById("ordersWrapper");
const messagesWrapper = document.getElementById("messagesWrapper");

categoriesWrapper &&
    new Datatable(
        categoriesWrapper,
        "categories-table",
        dataTableUri.DELETE_CATEGORIES
    );
productsWrapper &&
    new Datatable(
        productsWrapper,
        "products-table",
        dataTableUri.DELETE_PRODUCTS
    );
trashedProductsWrapper &&
    new Datatable(
        trashedProductsWrapper,
        "products-table",
        dataTableUri.DELETE_TRASHED_PRODUCTS,
        dataTableUri.RESTORE_PRODUCTS
    );

colorsWrapper && new Datatable(colorsWrapper, null, dataTableUri.DELETE_COLORS);
brandsWrapper && new Datatable(brandsWrapper, null, dataTableUri.DELETE_BRANDS);
sizesWrapper && new Datatable(sizesWrapper, null, dataTableUri.DELETE_SIZES);
ordersWrapper &&
    new Datatable(ordersWrapper, "orders-table", dataTableUri.DELETE_ORDERS);
notificationsWrapper &&
    new Datatable(
        notificationsWrapper,
        null,
        dataTableUri.DELETE_NOTIFICATIONS
    );
messagesWrapper &&
    new Datatable(messagesWrapper, null, dataTableUri.DELETE_MESSAGES);
