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

// control accordion collapse in small device
function adjustAccordionBehavior() {
  const accordionItems = document.querySelectorAll(".accordion-collapse");

  if (window.innerWidth >= 768) {
    accordionItems.forEach((item) => {
      item.classList.add("show");
    });
  } else {
    accordionItems.forEach((item) => {
      item.classList.remove("show");
    });
  }
}
window.addEventListener("resize", adjustAccordionBehavior);
window.addEventListener("DOMContentLoaded", adjustAccordionBehavior);

// changelog date synchronize date if one of them is empty
document.addEventListener("DOMContentLoaded", () => {
  const changeLogDateFrom = document.getElementById("dateFromChangelog");
  const changeLogDateTo = document.getElementById("dateToChangelog");
  function changeLogDateHandling(source, target) {
    if (source.value && !target.value) {
      target.value = source.value;
    }
  }

  changeLogDateFrom.addEventListener("change", () =>
    changeLogDateHandling(changeLogDateFrom, changeLogDateTo)
  );
  changeLogDateTo.addEventListener("change", () =>
    changeLogDateHandling(changeLogDateTo, changeLogDateFrom)
  );
});
