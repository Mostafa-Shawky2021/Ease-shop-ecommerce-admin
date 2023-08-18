import { Collapse } from "./plugins/collapse";
const collapseNotification = document.getElementById("collapseNotification");
collapseNotification && new Collapse(collapseNotification, true, true);
