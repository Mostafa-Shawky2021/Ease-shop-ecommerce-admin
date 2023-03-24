class Collapse {
    constructor(collapseWrapperNode, checkRoute) {

        this.collapseWrapperNode = collapseWrapperNode;
        this.buttoneElementNode = collapseWrapperNode.querySelectorAll('.button-toggle');

        this.buttoneElementNode.forEach(button => button.addEventListener('click', this.handleTogglesubMenu));
        if (checkRoute) this.checkActiveMenu();
    }

    handleTogglesubMenu() {

        const classStatus = this.classList.toggle('submenu-visible');
        const subMenu = this.nextElementSibling;
        const subMenuHeight = this.nextElementSibling.scrollHeight;

        if (classStatus) {
            subMenu.style.height = subMenuHeight + 'px';
        } else {
            subMenu.style.height = '0px';
        }
    }

    checkActiveMenu() {

        this.buttoneElementNode.forEach(button => {
            if (button.classList.contains('submenu-visible')) {
                const subMenu = button.nextElementSibling;
                const subMenuHeight = subMenu.scrollHeight;
                subMenu.style.height = subMenuHeight + 'px';
            }
        })

    }
}


export default Collapse;
