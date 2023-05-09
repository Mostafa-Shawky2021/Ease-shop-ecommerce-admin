import axios from "axios";

class Datatable {
    constructor(dataTableWrapper, datatableId, deleteURI, restoreURI) {
        this.selectedValue = [];

        this.dataTableId = datatableId;

        this.dataTableWrapper = dataTableWrapper;

        //endpoint to api which will delete specific resource
        this.deleteURI = deleteURI;
        //endpoint to api which will restore specific resource
        this.restoreURI = restoreURI;

        // this in case there are serach in datatable
        this.searchInputNode =
            this.dataTableWrapper?.querySelector("#searchDatatable");

        this.deleteBtnNode =
            this.dataTableWrapper?.querySelector("#deleteAction");

        this.restoreBtnNode =
            this.dataTableWrapper?.querySelector("#restoreAction");

        // checkbox will be used to select multiple checkbox element so user don't need to
        // select each record in datatable
        this.multipleSelectorCheckbox =
            this.dataTableWrapper?.querySelector("#multipleSelector");

        // binding functions
        this.handleCheckbox = this.handleCheckbox?.bind(this);

        this.handleDeleteBtn = this.handleDeleteBtn?.bind(this);

        this.handleRestoreBtn = this.handleRestoreBtn?.bind(this);

        this.handleSearchInput = this.handleSearchInput?.bind(this);

        this.multipleSelectorCheckbox?.addEventListener(
            "click",
            this.handleMultipleSelectorCheckbox
        );

        //Event handler functions
        this.dataTableWrapper.addEventListener("click", this.handleCheckbox);
        this.searchInputNode?.addEventListener("keyup", this.handleSearchInput);
        this.deleteBtnNode?.addEventListener("click", this.handleDeleteBtn);
        this.restoreBtnNode?.addEventListener("click", this.handleRestoreBtn);
    }

    handleCheckbox(event) {
        const checkBox = event.target;

        // this will make all checkboxes to be checked
        if (checkBox.id === "multipleSelector") {
            if (checkBox.checked) {
                this.dataTableWrapper
                    .querySelectorAll(".action-checkbox")
                    .forEach((box) => {
                        box.checked = true;
                        this.selectedValue.push(box.value);
                    });
            } else {
                this.dataTableWrapper
                    .querySelectorAll(".action-checkbox")
                    .forEach((box) => {
                        box.checked = false;
                        this.selectedValue = this.selectedValue.filter(
                            (value) => value != box.value
                        );
                    });
            }
        }

        if (checkBox.classList.contains("action-checkbox")) {
            if (checkBox.checked) this.selectedValue.push(checkBox.value);
            else
                this.selectedValue = this.selectedValue.filter(
                    (value) => value != checkBox.value
                );
        }
    }

    handleSearchInput(event) {
        window.LaravelDataTables[this.dataTableId]
            .search(event.target.value)
            .draw();
    }

    async handleRestoreBtn(event) {
        event.preventDefault();

        if (!this.checkSelectedValuesIsEmpty()) return false;
        if (!confirm("هل انت متاكد من تنفيذ العملة ?")) return false;

        try {
            const res = await axios.post(this.restoreURI, {
                id: this.selectedValue,
            });
            if (res.status === 200) {
                if (this.dataTableId)
                    window.LaravelDataTables[this.dataTableId].draw();
                else window.location.reload();
                console.log("hello");
            }
        } catch (error) {
            console.log(error);
        }
    }

    checkSelectedValuesIsEmpty() {
        if (!this.selectedValue.length) {
            alert("برجاء اختيار قيم");
            return false;
        }
        return true;
    }

    async handleDeleteBtn(event) {
        event.preventDefault();

        if (!this.checkSelectedValuesIsEmpty()) return false;

        if (!confirm("هل انت متاكد من تنفيذ العملة ?")) return false;

        try {
            const res = await axios.post(this.deleteURI, {
                id: this.selectedValue,
            });

            if (res.status === 200) {
                if (this.dataTableId)
                    window.LaravelDataTables[this.dataTableId].draw();
                else window.location.reload();

                this.multipleSelectorCheckbox.checked = false;
                this.selectedValue = [];
            }
        } catch (error) {
            console.log(error);
        }
    }
}

export default Datatable;
