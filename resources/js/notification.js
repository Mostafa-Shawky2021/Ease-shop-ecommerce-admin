import { Collapse } from "./plugins";

const collapseNotification = document.getElementById("collapseNotification");
collapseNotification && new Collapse(collapseNotification, true, true);
