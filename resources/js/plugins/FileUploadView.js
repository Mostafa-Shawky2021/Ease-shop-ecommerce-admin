

class FileUploadView {

    constructor(inputFileNode) {

        this.inputFileNode = inputFileNode;

        this.parentFileElement = inputFileNode.parentElement;

        this.handleFileUploaded = this.handleFileUploaded.bind(this);

        this.handleDeleteImage = this.handleDeleteImage.bind(this)

        this.renderModalView = this.renderModalView.bind(this);

        this.handleShowRemoveButton = this.handleShowRemoveButton.bind(this);

        this.inputFileNode.addEventListener('change', this.handleFileUploaded)

        this.checkFirstLoad();
    }
    checkFirstLoad() {

        let oldImagePath = this.parentFileElement.querySelector('#oldImage')?.value;

        if (oldImagePath) {

            if (oldImagePath.search(/\|/) > -1) {
                oldImagePath = oldImagePath.split("|");

            }

            this.handleBtnShow();
            this.handleShowRemoveButton();
            this.renderModalView(oldImagePath);

        }
    }

    handleFileUploaded(event) {

        this.handleBtnShow(event.target.files);

        this.handleShowRemoveButton();

        this.renderModalView(event.target.files);

    }

    renderModalView(files) {

        let modalNodeWrapper = this.parentFileElement.querySelector('.modalWrapper');

        let renderImage = '';

        if (!modalNodeWrapper) {

            modalNodeWrapper = document.createElement('div');
            modalNodeWrapper.className = "modalWrapper";
            this.parentFileElement.appendChild(modalNodeWrapper);
        }

        // in case of one file from the server 
        if (typeof files === 'string') {

            renderImage = `
                 <div class='image-wrapper-single'>
                    <img class="img-fluid" src=/${files} alt=${"image"} />
                </div>`;
        }
        else if (Array.isArray(files)) {

            renderImage = `
                    <div class="image-wrapper-multiple">
                        ${files.map(file => {

                return "<div class='image'><img src=/" + file + " alt='image'/> </div>";
            })}
                </div>`;
        }

        //  user upload multiple file
        else if (files.length > 0 && typeof files === 'object') {

            const filesArr = Array.from(files);
            renderImage = `
                <div class="image-wrapper-multiple">
                        ${filesArr.map(file => {
                const url = URL.createObjectURL(file)
                return "<div class='image'><img src=" + url + " alt=" + file.name + "/> </div>";
            })}
                </div>`;

        } else {
            console.log(typeof files);
            const url = URL.createObjectURL(files[0])
            renderImage = `
                 <div class='image-wrapper-single'>
                    <img class="img-fluid" src=${url} alt=${files[0].name} />
                </div>`;
        }

        const inputNodeId = this.inputFileNode.id;

        modalNodeWrapper.innerHTML = `
            <div class="modal fade" id="${inputNodeId}-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog model-show-image">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">الصور</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style='position:realtive;'>
                             ${renderImage}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلاق</button>
                        </div>
                    </div>
                </div>
          </div>`

    }
    handleBtnShow() {

        const inputNodeId = this.inputFileNode.id;

        let btnShowNode = this.parentFileElement.querySelector('.view-btn');

        if (!btnShowNode) {

            btnShowNode = document.createElement('button');
            btnShowNode.className = 'view-btn btn-action';

            btnShowNode.setAttribute('data-bs-target', `#${inputNodeId}-modal`);
            btnShowNode.setAttribute('data-bs-toggle', "modal");

            this.parentFileElement.appendChild(btnShowNode);
            btnShowNode.innerHTML = `
            عرض الصورة
            <i class="fa-solid fa-eye icon"></i>`
        }

        btnShowNode.onclick = (event) => event.preventDefault();
    }

    handleShowRemoveButton() {

        let btnShowNode = this.parentFileElement.querySelector('.delete-btn');

        if (!btnShowNode) {

            btnShowNode = document.createElement('button');
            btnShowNode.className = 'delete-btn btn-action';

            this.parentFileElement.appendChild(btnShowNode)
            btnShowNode.innerHTML = `
            حذف الصورة 
            <i class="fa-solid fa-trash icon"></i>`
        }
        btnShowNode.addEventListener('click', this.handleDeleteImage);
    }
    handleDeleteImage(event) {

        event.preventDefault();
        this.parentFileElement.querySelector('.delete-btn').remove();
        this.parentFileElement.querySelector('.view-btn').remove();

        this.inputFileNode.value = "";

        this.parentFileElement.querySelector('#oldImage').value = "";
    }


}

export default FileUploadView;



