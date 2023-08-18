import { Collapse } from './plugins/collapse';

const sideBar = document.getElementById('collapseSidebar');

sideBar && new Collapse(sideBar, true);