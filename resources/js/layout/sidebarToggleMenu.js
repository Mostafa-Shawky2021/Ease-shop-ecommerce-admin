
const buttonToggle = Array.from(document.getElementsByClassName('button-toggle'));

buttonToggle.forEach(element => element.addEventListener('click', handleSubMenuButton));


function handleSubMenuButton() {
    const classStatus = this.classList.toggle('submenu-visible');
    const subMenu = this.nextElementSibling;
    const subMenuHeight = this.nextElementSibling.scrollHeight;
    if (classStatus) {
        subMenu.style.height = subMenuHeight + 'px';
    } else {
        subMenu.style.height = '0px';
    }
}

