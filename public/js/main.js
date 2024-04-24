const homeCarouselEl = document.querySelector("#homeCarousel");
const productGalleryCarouselEl = document.querySelector(
  "#productGalleryCarousel"
);

// const carousel1 = new bootstrap.Carousel(homeCarouselEl, {
//   interval: 2000,
//   touch: false,
// });
// const carousel2 = new bootstrap.Carousel(productGalleryCarouselEl, {
//   interval: 2000,
//   touch: true,
// });

// const btnProductImgUpload = document.getElementById("#btn-productImageUpload");

// btnProductImgUpload.addEventListener("click", (e) => e.preventDefault());

// rich text editor setup

document.addEventListener("DOMContentLoaded", () => {
  // console.log("DOM fully loaded and parsed");
  const textareas = document.querySelectorAll("textarea.quill-editor");

  textareas.forEach((textarea) => {
    const editor = document.createElement("div");
    editor.innerHTML = textarea.value;
    textarea.parentNode.insertBefore(editor, textarea);
    textarea.style.display = "none"; // Hide the original textarea
    editor.style.height = "300px";

    const toolbarOptions = [
      ["bold", "italic", "underline"], // toggled buttons
      ["link"],
      [
        {
          list: "ordered",
        },
        {
          list: "bullet",
        },
      ],

      ["clean"], // remove formatting button
    ];

    const quill = new Quill(editor, {
      modules: {
        toolbar: toolbarOptions,
      },
      placeholder: "Enter content",
      theme: "snow",
    });

    quill.on("text-change", function () {
      textarea.value = quill.root.innerHTML; // Sync the content with the hidden textarea
    });
  });
});
