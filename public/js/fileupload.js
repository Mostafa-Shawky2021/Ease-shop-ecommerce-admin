const productImageFileBrand = document.getElementById('productImageFileBrand')?.addEventListener('change', handleSingleImageUpload)
const productImageThumbnails = document.getElementById('productImageThumbnails')?.addEventListener('change', handleMultipleImageUpload)
const boxImageShow = document.getElementById('boxImageShow')
const boxImageShowmultiple = document.getElementById('boxImageShowmultiple')
const btnDeleteImage = Array.from(document.getElementsByClassName('btnDeleteImage'))
function handleSingleImageUpload(ev) {
    const imageUpload = ev.target.files[0]
    const coverttoUrl = URL.createObjectURL(imageUpload)
    if (boxImageShow.children[0]?.classList.contains('old')) boxImageShow.innerHTML = ''
    boxImageShow.innerHTML = `
        <div class='img-box'>
            <img class='img' src=${coverttoUrl} alt='image-view' />
        </div>
    `

}

function handleMultipleImageUpload(ev) {
    const imagesUpload = ev.target.files
    for (const imageUpload of imagesUpload) {
        const converttoUrl = URL.createObjectURL(imageUpload)
        boxImageShowmultiple.innerHTML += `
            <div class='img-box'>
                <img class='img' src=${converttoUrl} alt='image-view' />
            </div>
        `
    }
}
// class Image {

//     constructor() { }
//     setContainerNode(containerNode) {
//         this.containerNode = containerNode
//     }
//     setImageFile(imageFile) {
//         this.imageFile = imageFile
//     }
//     handleImageView() {
//         const fileReader = new FileReader()
//         fileReader.readAsDataURL(this.imageFile)
//         console.log(URL.createObjectURL(this.imageFile))
//         fileReader.onload = () => {

//             this.containerNode.innerHTML = `
//                 <div class='img-box'>
//                     <img
//                         class='img'
//                         src=${fileReader.result}
//                         alt='image-brand'/>
//                     <i class='icon-delete single fa fa-trash'></i>
//                 </div>
//             `
//         }
//     }
//     handleMultipleImage() {
//         for (const file of this.imageFile) {
//             const fileReader = new FileReader()
//             fileReader.readAsDataURL(file)
//             fileReader.onload = () => {
//                 this.containerNode.innerHTML += `
//                 <div class='img-box'>
//                     <img
//                         class='img'
//                         src=${fileReader.result}
//                         alt='image-brand'/>
//                     <i class='icon-delete multiple fa fa-trash'></i>
//                 </div>
//             `
//             }

//         }
//     }
//     deleteImage(element) {
//         element.parentElement.remove()
//         // this.imageFile = ''
//         console.log(this)
//     }

// }

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




