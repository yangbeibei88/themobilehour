const homeCarouselEl = document.querySelector("#homeCarousel");
const productGalleryCarouselEl = document.querySelector(
  "#productGalleryCarousel"
);

const carousel1 = new bootstrap.Carousel(homeCarouselEl, {
  interval: 2000,
  touch: false,
});
const carousel2 = new bootstrap.Carousel(productGalleryCarouselEl, {
  interval: 2000,
  touch: true,
});

const btnProductImgUpload = document.getElementById("#btn-productImageUpload");

// btnProductImgUpload.addEventListener("click", (e) => e.preventDefault());
