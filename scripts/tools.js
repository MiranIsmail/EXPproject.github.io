const BASE_ULR = "https://rasts.se/api/";
function load_image(indata) {
    var img = document.createElement("img");
    img.setAttribute("id", "profile_image");
    img.setAttribute("class", "img-fluid d-block");
    img.alt = "Profile Image";
    img.src = indata;
    var src = document.getElementById("profile_box");
    src.appendChild(img);
}

function image_to_blob(inputElement) {
    const file = inputElement.files[0];
    if (!file) {
        return Promise.reject(new Error("No file selected"));
    }
    const reader = new FileReader();
    reader.readAsArrayBuffer(file);
    return new Promise((resolve, reject) => {
        reader.onload = () => {
        const blob = new Blob([reader.result], { type: file.type });
        resolve(blob);
        };
        reader.onerror = () => {
        reject(new Error("Error reading file"));
        };
    });
    }


function image_compress_64(inputfile) {
    return new Promise((resolve, reject) => {
        var return_variable = ""
        const MAX_WIDTH = 320;
        const MAX_HEIGHT = 180;
        const MIME_TYPE = "image/jpeg";
        const QUALITY = 0.7;

        const file = inputfile.files[0]; // get the file
        const blobURL = URL.createObjectURL(file);
        const img = new Image();
        img.src = blobURL;
        img.onerror = function () {
        URL.revokeObjectURL(this.src);
        // Handle the failure properly
        console.log("Cannot load image");
        };
        img.onload = function () {
        URL.revokeObjectURL(this.src);
        const [newWidth, newHeight] = calculateSize(img, MAX_WIDTH, MAX_HEIGHT);
        const canvas = document.createElement("canvas");
        canvas.width = newWidth;
        canvas.height = newHeight;
        const ctx = canvas.getContext("2d");
        ctx.drawImage(img, 0, 0, newWidth, newHeight);
        canvas.toBlob(
            (blob) => {
            // Handle the compressed image. es. upload or save in local state

            blobToBase64(blob).then(function (result) {
                resolve(result)
            }).catch(function (error) {
                console.log(error);
            });
            },
            MIME_TYPE,
            QUALITY
        );
        document.getElementById("root").append(canvas);
        };
    });
}

function image_compress_64_large(inputfile) {
  return new Promise((resolve, reject) => {
    var return_variable = ""
    const MAX_WIDTH = 1920;
    const MAX_HEIGHT = 1080;
    const MIME_TYPE = "image/jpeg";
    const QUALITY = 0.7;

    const file = inputfile.files[0]; // get the file
    const blobURL = URL.createObjectURL(file);
    const img = new Image();
    img.src = blobURL;
    img.onerror = function () {
      URL.revokeObjectURL(this.src);
      // Handle the failure properly
      console.log("Cannot load image");
    };
    img.onload = function () {
      URL.revokeObjectURL(this.src);
      const [newWidth, newHeight] = calculateSize(img, MAX_WIDTH, MAX_HEIGHT);
      const canvas = document.createElement("canvas");
      canvas.width = newWidth;
      canvas.height = newHeight;
      const ctx = canvas.getContext("2d");
      ctx.drawImage(img, 0, 0, newWidth, newHeight);
      canvas.toBlob(
        (blob) => {
          // Handle the compressed image. es. upload or save in local state

          blobToBase64(blob).then(function (result) {
            resolve(result)
            // return_variable = result // "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/4gHYSUNDX"
          }).catch(function (error) {
            console.log(error);
          });
        },
        MIME_TYPE,
        QUALITY
      );
      document.getElementById("root").append(canvas);
    };

    // return return_variable
  });
}

function calculateSize(img, maxWidth, maxHeight) {
    let width = img.width;
    let height = img.height;

    // calculate the width and height, constraining the proportions
    if (width > height) {
      if (width > maxWidth) {
        height = Math.round((height * maxWidth) / width);
        width = maxWidth;
      }
    } else {
      if (height > maxHeight) {
        width = Math.round((width * maxHeight) / height);
        height = maxHeight;
      }
    }
    return [width, height];
  }



function displayInfo(label, file) {
    const p = document.createElement("p");
    p.innerText = `${label} - ${readableBytes(file.size)}`;
    document.getElementById("root").append(p);
}

function readableBytes(bytes) {
    const i = Math.floor(Math.log(bytes) / Math.log(1024)),
        sizes = ["B", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"];

    return (bytes / Math.pow(1024, i)).toFixed(2) + " " + sizes[i];
}

const get_cookie = (name) =>
  document.cookie.match("(^|;)\\s*" + name + "\\s*=\\s*([^;]+)")?.pop() || "";

function blobToBase64(blob) {
return new Promise((resolve, _) => {
    const reader = new FileReader();
    reader.onloadend = () => resolve(reader.result);
    reader.readAsDataURL(blob);
});
}

async function calculate_age(date) {
    if (date != null) {
      var today = new Date();
      var birthDate = new Date(await date);
      var age = today.getFullYear() - birthDate.getFullYear();
      var m = today.getMonth() - birthDate.getMonth();
      if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
      }
      return age;
    }

    return "missing";
  }

function image_to_blob(inputElement) {
    const file = inputElement.files[0];
    if (!file) {
        return Promise.reject(new Error("No file selected"));
    }
    const reader = new FileReader();
    reader.readAsArrayBuffer(file);
    return new Promise((resolve, reject) => {
        reader.onload = () => {
        const blob = new Blob([reader.result], { type: file.type });
        resolve(blob);
        };
        reader.onerror = () => {
        reject(new Error("Error reading file"));
        };
    });
}
