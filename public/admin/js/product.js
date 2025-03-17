function previewThumbnail(event) {
  var reader = new FileReader();
  reader.onload = function (e) {
    var thumbnailPreview = document.getElementById("thumbnailPreview");
    thumbnailPreview.src = e.target.result;
    thumbnailPreview.style.display = "block";
  };
  reader.readAsDataURL(event.target.files[0]);
}

function previewImages(event) {
  var container = document.getElementById("imagesContainer");

  Array.from(event.target.files).forEach((file) => {
    var reader = new FileReader();
    reader.onload = function (e) {
      var imgContainer = document.createElement("div");
      imgContainer.className = "image-preview";

      var img = document.createElement("img");
      img.src = e.target.result;

      var removeBtn = document.createElement("button");
      removeBtn.innerHTML = "&times;";
      removeBtn.className = "remove-image";
      removeBtn.onclick = function () {
        imgContainer.remove();
      };

      imgContainer.appendChild(img);
      imgContainer.appendChild(removeBtn);
      container.appendChild(imgContainer);
    };
    reader.readAsDataURL(file);
  });
}

document.addEventListener("click", function (event) {
  if (event.target.classList.contains("remove-image")) {
    var imageId = event.target.dataset.id;
    var imageElement = document.getElementById("image-" + imageId);

    fetch(`/admin/products/delete-image/${imageId}`, {
      method: "DELETE",
      headers: {
        "X-CSRF-TOKEN": document
          .querySelector('meta[name="csrf-token"]')
          .getAttribute("content"),
        "Content-Type": "application/json",
      },
    })
      .then((response) => {
        if (!response.ok) {
          return response.text().then((text) => {
            throw new Error(text);
          });
        }
        return response.json();
      })
      .then((data) => {
        if (data.success) {
          imageElement.remove();
        } else {
          alert("Failed to delete image!");
        }
      })
      .catch((error) => console.error("Error:", error));
  }
});
