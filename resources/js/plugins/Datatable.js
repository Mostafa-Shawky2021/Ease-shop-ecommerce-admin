import axios from "axios";

class Datatable {
    constructor(dataTableWrapper, datatableId, deleteURI, restoreURI) {
        this.selectedValue = [];

        this.dataTableId = datatableId;

        this.dataTableWrapper = dataTableWrapper;

        this.deleteURI = deleteURI;

        this.restoreURI = restoreURI;

        this.searchInputNode =
            this.dataTableWrapper?.querySelector("#searchDatatable");

        this.deleteBtnNode =
            this.dataTableWrapper?.querySelector("#deleteAction");

        this.restoreBtnNode =
            this.dataTableWrapper?.querySelector("#restoreAction");

        this.handleCheckbox = this.handleCheckbox?.bind(this);

        this.handleDeleteBtn = this.handleDeleteBtn?.bind(this);

        this.handleRestoreBtn = this.handleRestoreBtn?.bind(this);

        this.handleSearchInput = this.handleSearchInput?.bind(this);

        this.dataTableWrapper &&
            document.body.addEventListener("click", this.handleCheckbox);

        this.searchInputNode?.addEventListener("keyup", this.handleSearchInput);

        this.deleteBtnNode?.addEventListener("click", this.handleDeleteBtn);

        this.restoreBtnNode?.addEventListener("click", this.handleRestoreBtn);
    }

    handleCheckbox(event) {
        const checkBox = event.target;
        if (!checkBox.classList.contains("action-multiple-box")) return false;

        if (checkBox.checked) {
            this.selectedValue.push(checkBox.value);
        } else {
            this.selectedValue = this.selectedValue.filter(
                (value) => value != checkBox.value
            );
        }

        console.log(this.selectedValue);
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
            }
        } catch (error) {
            console.log(error);
        }
    }
}

export default Datatable;
