

class FileUploadView {

    constructor(event) {

        this.fileNode = event.target;

        this.parentFileElement = event.target.parentElement;

        this.fileUploaded = event.target.files;

        this.handleSingleDelete = this.handleSingleDelete.bind(this)

        this.renderModalView = this.renderModalView.bind(this);

        this.handleFiles();

    }

    handleSingleDelete(event) {
        event.preventDefault();
        console.log(this);
        this.containerFile.innerHTML = '';

    }


    showFileName() {

        let imageName = '';
        if (this.fileUploaded.length > 1) {

            // render multiple files
        } else {
            imageName = this.fileUploaded[0].name;
        }
        let imageNameContainer = this.parentFileElement.querySelector('.image-name-container');

        if (!imageNameContainer) {
            imageNameContainer = document.createElement('div');
            imageNameContainer.className = 'image-name-container';
            this.parentFileElement.appendChild(imageNameContainer);

        }

        imageNameContainer.innerHTML = `
        <span>${imageName}</span> `

    }

    renderModalView() {


        let modalNodeWrapper = this.parentFileElement.querySelector('.modalWrapper');
        let renderImage = '';

        if (!modalNodeWrapper) {

            modalNodeWrapper = document.createElement('div');
            modalNodeWrapper.className = "modalWrapper";
            this.parentFileElement.appendChild(modalNodeWrapper);
        }

        // render images to display
        if (this.fileUploaded.length > 1) {

        } else {
            const url = URL.createObjectURL(this.fileUploaded[0])
            renderImage = `
                <div class='image-wrapper'>
                    <img class="img-fluid" src=${url} alt=${this.fileUploaded[0].name} />
                </div>  
            `
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
          </div>  `


    }
    handleBtnShow() {

        let btnShowNode = this.parentFileElement.querySelector('.view-btn');

        if (!btnShowNode) {
            btnShowNode = document.createElement('button');
            btnShowNode.className = 'view-btn btn btn-primary';

            btnShowNode.setAttribute('data-bs-target', '#showModalImages');
            btnShowNode.setAttribute('data-bs-toggle', "modal");
            btnShowNode.setAttribute('type', 'button');

            this.parentFileElement.appendChild(btnShowNode)
            btnShowNode.innerHTML = `
            عرض الصورة
            <i class="fa-solid fa-eye icon"></i>
            `
        }

        btnShowNode.addEventListener('click', (event) => {
            event.preventDefault();
            this.renderModalView()

        });

    }
    handleFiles() {

        this.showFileName();

        this.handleBtnShow();

        this.renderModalView();

        return;
        const fileReader = new FileReader()
        fileReader.readAsDataURL(this.fileUpload)
        fileReader.onload = () => {

            this.containerFile.innerHTML = `
                <div class='img-box'>
                    <img
                        class='img'
                        src=${fileReader.result}
                        alt='image-brand'/>
                    <button class='delete-btn' id='deleteFile'>
                     <i class='icon-delete single fa fa-trash'></i>
                    </button>
                </div>
            `
            document.getElementById('deleteFile').addEventListener('click', this.handleSingleDelete)
        }

    }
    handleMultipleFiles() {

        for (const file of this.fileUpload) {

            const fileReader = new FileReader()
            fileReader.readAsDataURL(file)
            fileReader.onload = () => {
                this.containerFile.innerHTML += `
                <div class='img-box'>
                    <img
                        class='img'
                        src=${fileReader.result}
                        alt='image-brand'/>
                    <i class='icon-delete multiple fa fa-trash'></i>
                </div>
            `
            }

        }
    }


}

// singleImageUpload.addEventListener('change', (event) => new FileUpload(event, 'boxImageShow', false))



// let brandImage = new Image()
// let thumbnailsImage = new Image()

// productImageFileBrand.addEventListener('change', (e) => {
//     let uploadedFile = e.target.files[0]
//     if (uploadedFile) {
//         brandImage.setImageFile(uploadedFile)
//         brandImage.setContainerNode(boxImageShow)
//         brandImage.handleImageView()

//     }
// })
// productImageThumbnails.addEventListener('change', (e) => {
//     const uploadedFiles = e.target.files
//     if (uploadedFiles) {
//         thumbnailsImage.setImageFile(uploadedFiles)
//         thumbnailsImage.setContainerNode(boxImageShowmultiple)
//         thumbnailsImage.handleMultipleImage()
//     }

// })


// document.body.onclick = function (e) {
//     const deleteElementClass = e.target.classList
//     if (deleteElementClass.contains('single')) {
//         brandImage.deleteImage(e.target)
//     }
//     if (deleteElementClass.contains('multiple')) {
//         thumbnailsImage.deleteImage(e.target)
//     }
// }


export default FileUploadView;



