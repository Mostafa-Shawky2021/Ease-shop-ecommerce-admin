

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
        const oldImagePath = this.parentFileElement.querySelector('#oldImage')?.value;
        if (oldImagePath) {
            // this.showFileName(oldImagePath);
            this.handleBtnShow();
            this.handleShowRemoveButton();
            this.renderModalView(oldImagePath);
        }
    }
    handleFileUploaded(event) {

        // this.showFileName(event.target.files);

        this.handleBtnShow(event.target.files);

        this.handleShowRemoveButton();

        this.renderModalView(event.target.files);

    }

    showFileName(files) {

        let imageName = '';

        if (files.length > 1) {

            // render multiple files

        } else {
            imageName = files[0].name;

        }

        let imageNameContainer = this.parentFileElement.querySelector('.image-name-container');

        if (!imageNameContainer) {
            imageNameContainer = document.createElement('div');
            imageNameContainer.className = 'image-name-container';
            this.parentFileElement.appendChild(imageNameContainer);
        }

        imageNameContainer.innerHTML = `<span>${imageName}</span> `

    }

    renderModalView(files) {

        let modalNodeWrapper = this.parentFileElement.querySelector('.modalWrapper');

        let renderImage = '';

        if (!modalNodeWrapper) {

            modalNodeWrapper = document.createElement('div');
            modalNodeWrapper.className = "modalWrapper";
            this.parentFileElement.appendChild(modalNodeWrapper);
        }

        // render images to display
        if (typeof files === 'string') {
            renderImage = `
                 <div class='image-wrapper'>
                    <img class="img-fluid" src=/${files} alt=${files} />
                </div>`
        }
        else if (files.length > 1) {

        } else {
            const url = URL.createObjectURL(files[0])
            renderImage = `
                 <div class='image-wrapper'>
                    <img class="img-fluid" src=${url} alt=${files[0].name} />
                </div>`
        }

        modalNodeWrapper.innerHTML = `
            <div class="modal fade" id="showModalImages" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

        let btnShowNode = this.parentFileElement.querySelector('.view-btn');

        if (!btnShowNode) {

            btnShowNode = document.createElement('button');
            btnShowNode.className = 'view-btn btn-action';

            btnShowNode.setAttribute('data-bs-target', '#showModalImages');
            btnShowNode.setAttribute('data-bs-toggle', "modal");

            this.parentFileElement.appendChild(btnShowNode)
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
        // this.parentFileElement.querySelector('.image-name-container').remove();

        this.inputFileNode.value = "";

        this.parentFileElement.querySelector('#oldImage').value = "";
    }


}

export default FileUploadView;



