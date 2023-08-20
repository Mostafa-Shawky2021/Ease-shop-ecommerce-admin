class ImageUploadView {
    constructor(inputFileNode) {
        this.inputFileNode = inputFileNode;

        this.parentFileElement = inputFileNode.parentElement;

        this.handleFileUploaded = this.handleFileUploaded.bind(this);

        this.handleDeleteImage = this.handleDeleteImage.bind(this);

        this.renderModalView = this.renderModalView.bind(this);

        this.renderRemoveBtn = this.renderRemoveBtn.bind(this);

        this.inputFileNode.addEventListener("change", this.handleFileUploaded);

        this.checkFirstLoad();
    }

    checkFirstLoad() {
        // render image in  case of update product and product have image path
        if (!this.isImageOld()) return false;
        let oldImagePath =
            this.parentFileElement.querySelector("#oldImage")?.value;

        // imges will render as images path seperated by | and that process handled by backend
        const isOldImageMultiplePaths = oldImagePath.search(/\|/);
        oldImagePath =
            isOldImageMultiplePaths > -1
                ? oldImagePath.split("|")
                : oldImagePath;

        this.renderBtnShow();
        this.renderRemoveBtn();
        this.renderImageWrapper(oldImagePath);
        this.renderImagesLength(oldImagePath);
    }

    handleFileUploaded(event) {
        if (!event.target.files.length) return false; // user dosen;t choose image

        this.renderBtnShow(event.target.files);
        this.renderRemoveBtn();
        this.renderImageWrapper(event.target.files);
        this.renderImagesLength(event.target.files);
    }

    renderImagesLength(files) {
        const imageCount = typeof files === "string" ? 1 : files.length;
        let createdElement =
            this.parentFileElement.querySelector(".images-count");
        if (!createdElement) {
            createdElement = this.createElement(
                "span",
                "images-count",
                this.parentFileElement
            );
        }
        createdElement.innerText = `تم اضافة عدد ${imageCount} صور`;
    }
    renderOldImagesContainer(images) {
        let imageWrapperContainer = this.createElement("div");

        if (Array.isArray(images)) {
            imageWrapperContainer.classList.add("image-wrapper-multiple");
            images.forEach((image) => {
                const imageContent = this.createElement(
                    "div",
                    "image-content",
                    imageWrapperContainer
                );
                const imageElement = this.createElement(
                    "img",
                    "img-fluid",
                    imageContent
                );
                imageElement.src = `${image}`;
                imageElement.alt = "file image";
            });
        } else {
            const imageElement = this.createElement(
                "img",
                "img-fluid",
                imageWrapperContainer
            );
            imageWrapperContainer.classList.add("image-wrapper-single");
            imageElement.src = `${images}`;
            imageElement.alt = "file image";
        }
        return imageWrapperContainer;
    }

    renderImagesContainer(images) {
        let imageWrapperContainer = this.createElement("div");
        imageWrapperContainer.classList.add("image-wrapper-multiple");
        if (images instanceof FileList && images.length > 1) {
            images.forEach((image) => {
                const imageContent = this.createElement(
                    "div",
                    "image-content",
                    imageWrapperContainer
                );
                const imageElement = this.createElement(
                    "img",
                    "img-fluid",
                    imageContent
                );
                imageElement.src = URL.createObjectURL(image);
                imageElement.alt = "file image";
            });
        } else {
            imageWrapperContainer.classList.add("image-wrapper-single");
            const image = this.createElement(
                "img",
                "img-fluid",
                imageWrapperContainer
            );
            image.src = URL.createObjectURL(images[0]);
            image.alt = "file image";
        }
        return imageWrapperContainer;
    }

    renderImageWrapper(files) {
        // we need that condition because render images from user file system is different from the retrieved from database
        // the retrieved from database will be the images path

        let imageContainerWrapper = this.isImageOld()
            ? this.renderOldImagesContainer(files)
            : this.renderImagesContainer(files);

        this.renderModalView(imageContainerWrapper);
    }

    renderModalView(imageWrapperContainerNode) {
        let modalNodeWrapper =
            this.parentFileElement.querySelector(".modalWrapper");

        modalNodeWrapper = !modalNodeWrapper
            ? this.createElement("div", "modalWrapper", this.parentFileElement)
            : modalNodeWrapper;

        const inputNodeId = this.inputFileNode.id;

        modalNodeWrapper.innerHTML = `
        <div class="modal fade" id="${inputNodeId}-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog model-show-image">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-5" id="exampleModalLabel">الصور</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style='position:realtive;'>
                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal">اغلاق</button>
                    </div>
                </div>
            </div>
      </div>`;

        modalNodeWrapper
            .querySelector(".modal-body")
            .appendChild(imageWrapperContainerNode);
    }

    isImageOld() {
        // check if the image Path retrieved from database
        return !!this.parentFileElement.querySelector("#oldImage")?.value;
    }

    renderBtnShow() {
        // get input file id so we can bind it to bootstrap modal
        const inputFileNodeId = this.inputFileNode.id;
        let btnWrapper = this.parentFileElement.querySelector(".btn-wrapper");
        let btnShowNode = this.parentFileElement.querySelector(".view-btn");

        if (!btnWrapper) {
            btnWrapper = this.createElement(
                "div",
                "btn-wrapper",
                this.parentFileElement
            );
        }
        if (!btnShowNode) {
            btnShowNode = this.createElement(
                "button",
                ["btn", "btn-primary", "view-btn", "btn-action"],
                btnWrapper
            );

            btnShowNode.setAttribute(
                "data-bs-target",
                `#${inputFileNodeId}-modal`
            );
            btnShowNode.setAttribute("data-bs-toggle", "modal");

            btnShowNode.innerHTML = ` عرض الصورة <i class="fa-solid fa-eye icon"></i>`;
        }

        btnShowNode.addEventListener("click", (event) =>
            event.preventDefault()
        );
    }

    renderRemoveBtn() {
        let btnShowNode = this.parentFileElement.querySelector(".delete-btn");
        let btnWrapper = this.parentFileElement.querySelector(".btn-wrapper");

        if (!btnWrapper) {
            btnWrapper = this.createElement(
                "div",
                "btn-wrapper",
                this.parentFileElement
            );
        }
        if (!btnShowNode) {
            btnShowNode = this.createElement(
                "button",
                ["btn-danger", "btn-action", "btn", "delete-btn"],
                btnWrapper
            );

            btnShowNode.innerHTML = `حذف الصورة <i class="fa-solid fa-trash icon"></i>`;
        }

        btnShowNode.addEventListener("click", this.handleDeleteImage);
    }

    handleDeleteImage(event) {
        event.preventDefault();
        this.parentFileElement.querySelector(".delete-btn")?.remove();
        this.parentFileElement.querySelector(".view-btn")?.remove();
        this.parentFileElement.querySelector(".modalWrapper")?.remove();
        this.parentFileElement.querySelector(".images-count").innerText = "";
        this.inputFileNode.value = "";

        // reset old image so server can detected that the user delete old image
        this.parentFileElement.querySelector("#oldImage").value = "";
    }

    createElement(elementNode = "div", classesName = null, parentNode = null) {
        const createdElement = document.createElement(elementNode);
        classesName &&
            createdElement.classList.add(
                ...(Array.isArray(classesName) ? classesName : [classesName])
            );
        parentNode && parentNode.appendChild(createdElement);
        return createdElement;
    }
}

export default ImageUploadView;
