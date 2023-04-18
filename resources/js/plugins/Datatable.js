import axios from "axios";

class Datatable {

    constructor(dataTableWrapper, datatableId, url) {

        this.selectedValue = [];

        this.dataTableId = datatableId;

        this.dataTableWrapper = dataTableWrapper;

        this.endPointUrl = url;

        this.searchInputNode = this.dataTableWrapper?.querySelector('#searchDatatable');

        this.deleteBtnNode = this.dataTableWrapper?.querySelector("#delete-action");

        this.handleCheckbox = this.handleCheckbox?.bind(this);

        this.handleDeleteBtn = this.handleDeleteBtn?.bind(this);

        this.handleSearchInput = this.handleSearchInput?.bind(this);

        this.dataTableWrapper && document.body.addEventListener('click', this.handleCheckbox);

        this.searchInputNode?.addEventListener('keyup', this.handleSearchInput);

        this.deleteBtnNode?.addEventListener('click', this.handleDeleteBtn);

    }

    handleSearchInput(event) {

        window.LaravelDataTables[this.dataTableId].search(event.target.value).draw()
    }


    async handleDeleteBtn() {

        if (!this.selectedValue.length) {
            alert('برجاء اختيار قيم');
            return false;
        }

        try {
            const res = await axios.post(this.endPointUrl, { id: this.selectedValue });
            if (res.status === 200) {
                if (this.dataTableId) window.LaravelDataTables[this.dataTableId].draw();
                else window.location.reload();
            }
        } catch (error) {
            console.log(error);
        }
    }

    handleCheckbox(event) {


        const checkBox = event.target;
        if (!checkBox.classList.contains('action-multiple-box')) return false;

        if (checkBox.checked) {
            this.selectedValue.push(checkBox.value);

        } else {
            this.selectedValue = this.selectedValue.filter((value) => value != checkBox.value);

        }

        console.log(this.selectedValue);
    }

}

export default Datatable;