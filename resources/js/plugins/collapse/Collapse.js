class Collapse {
    constructor(
        collapseWrapperNode,
        checkRoute,
        closeOnMouseClick,
        closeOnKeyDown
    ) {
        // initialization properties
        this.collapseWrapperNode = collapseWrapperNode;
        this.buttoneElementNode =
            collapseWrapperNode.querySelectorAll(".button-toggle");

        this.registerToggleMenuEvent();

        if (checkRoute) this.checkActiveMenu();

        if (closeOnMouseClick) this.registerCloseMenuOnMouseClick();
    }

    registerToggleMenuEvent() {
        this.buttoneElementNode.forEach((button) => {
            button.addEventListener("click", this.toggleMenu);
        });
    }

    registerCloseMenuOnMouseClick() {
        document.body.addEventListener("click", (event) => {
            // in case user clicks on the menu prevent close menu
            if (this.collapseWrapperNode.contains(event.target)) return false;

            const buttonsToggle = Array.from(this.buttoneElementNode);

            buttonsToggle.forEach((button) => {
                button.nextElementSibling.style.height = "0px";
                button.classList.remove("submenu-visible");
            });
        });
    }

    toggleMenu() {
        const classStatus = this.classList.toggle("submenu-visible");
        const subMenu = this.nextElementSibling;

        const subMenuHeight = this.nextElementSibling.scrollHeight;

        if (classStatus) subMenu.style.height = subMenuHeight + "px";
        else subMenu.style.height = "0px";
    }

    checkActiveMenu() {
        this.buttoneElementNode.forEach((button) => {
            if (button.classList.contains("submenu-visible")) {
                const subMenu = button.nextElementSibling;
                const subMenuHeight = subMenu.scrollHeight;
                subMenu.style.height = subMenuHeight + "px";
            }
        });
    }
}

export default Collapse;
