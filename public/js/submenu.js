let buttonToggle = Array.from(document.getElementsByClassName('button-toggle'));


buttonToggle.forEach(element => {
    element.addEventListener('click', handleSubMenuButton)
});

// toggle submenu
function handleSubMenuButton() {
    let classStatus = this.classList.toggle('submenu-visible');
    let subMenu = this.nextElementSibling;
    let subMenuHeight = this.nextElementSibling.scrollHeight;
    if (classStatus) {
        subMenu.style.height = subMenuHeight + 'px';
    } else {
        subMenu.style.height = '0px';
    }
}

