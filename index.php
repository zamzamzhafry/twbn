<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Twibbon</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>


  <link rel="stylesheet" href="style.css">
</head>

<body>

  Pilih Frame Twibbon <br>

  Made by zam2 dengan buru2 maap tampilan menyiksa
  <br>

  <select id="twibbonimg">
    <option value="img/hut.png">FRAME HUT 2</option>
    <option value="img/4.png">FRAME CONTOH</option>
  </select>
  <br>

  <!-- Changing this part into buttons for adding and decreasing value. -->
  Upload Foto Profil <input type="file" id="photoimg" value=""> <br>
  <div>
    <button id="increaseWidth" class="btn btn-primary">+ Tambah Lebar Samping</button>
    <button id="decreaseWidth" class="btn btn-primary">- Kurang Lebar Samping</button>
    <label id="widthLabel">Lebar: 100%</label>
    <br>
    <button id="increaseHeight" class="btn btn-primary">+ Tambah Lebar atas</button>
    <button id="decreaseHeight" class="btn btn-primary">- Kurangi Lebasr Atas</button>
    <label id="heightLabel">Tinggi: 100%</label>
    <br>
    <button id="increaseTop" class="btn btn-primary">Bawah</button>
    <button id="decreaseTop" class="btn btn-primary">Atas</button>
    <label id="topLabel">atas bawah: 0px</label>
    <br>
    <button id="increaseLeft" class="btn btn-primary">Kanan</button>
    <button id="decreaseLeft" class="btn btn-primary">Kiri</button>
    <label id="leftLabel">kiri kanan: 0px</label>
  </div>

  <hr>

  <h2>Pick A Photo</h2>
  <div class="card">
    <div class="twibbon">
      <img src="" id="twibbon" alt="">
      <img src="" id="photo" alt="">
    </div>
  </div>
  <a href="#" id="download">Download</a>

  <!-- <div class="preview-container">
    <h2>Preview</h2>
    <canvas id="previewCanvas" width="400" height="300"></canvas>
  </div> -->

  <script type="text/javascript">
    var photoimg = "";
    var width = 100;
    var height = 100;
    var topPos = 0;
    var leftPos = 0;

    // Upload image to the directory
    $(document).ready(function() {
      $('#photoimg').change(function() {
        var formData = new FormData();
        var files = $('#photoimg')[0].files;
        formData.append('photo', files[0]);
        $.ajax({
          url: "upload.php",
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
          success: function(response) {
            photoimg = response;
            preview();
          }
        });
      });

      // Event listeners for buttons to change values
      $('#increaseWidth').click(function() {
        width += 10;
        updateWidthLabel();
        preview();
      });

      $('#decreaseWidth').click(function() {
        if (width > 10) {
          width -= 10;
          updateWidthLabel();
          preview();
        }
      });

      $('#increaseHeight').click(function() {
        height += 10;
        updateHeightLabel();
        preview();
      });

      $('#decreaseHeight').click(function() {
        if (height > 10) {
          height -= 10;
          updateHeightLabel();
          preview();
        }
      });

      $('#increaseTop').click(function() {
        topPos += 10;
        updateTopLabel();
        preview();
      });

      $('#decreaseTop').click(function() {
        if (topPos > 0) {
          topPos -= 10;
          updateTopLabel();
          preview();
        }
      });

      $('#increaseLeft').click(function() {
        leftPos += 10;
        updateLeftLabel();
        preview();
      });

      $('#decreaseLeft').click(function() {
        if (leftPos > 0) {
          leftPos -= 10;
          updateLeftLabel();
          preview();
        }
      });
    });

    // Function to update width label
    function updateWidthLabel() {
      $('#widthLabel').text("Width: " + width + "%");
    }

    // Function to update height label
    function updateHeightLabel() {
      $('#heightLabel').text("Height: " + height + "%");
    }

    // Function to update top label
    function updateTopLabel() {
      $('#topLabel').text("Top: " + topPos + "px");
    }

    // Function to update left label
    function updateLeftLabel() {
      $('#leftLabel').text("Left: " + leftPos + "px");
    }

    // Real time preview twibbon
    function preview() {
      var twibbonimg = $('#twibbonimg').val();
      $("#photo").attr("src", photoimg);
      $('#twibbon').attr("src", twibbonimg);
      $('#photo').css("width", width + "%");
      $('#photo').css("height", height + "%");
      $('#photo').css("top", topPos + "px");
      $('#photo').css("left", leftPos + "px");
    }

    // Download current view as image
    $("#download").on('click', function() {
      html2canvas($('.card')[0], { // Pass the selector for the card div
        allowTaint: true,
        useCORS: true,
        scale: 2
      }).then(function(canvas) {
        // Convert canvas to data URL and trigger download
        var imageData = canvas.toDataURL("image/png");
        var newData = imageData.replace(/^data:image\/png/, "data:application/octet-stream");
        $("#download").attr("download", "twibbon.png").attr("href", newData);
      });
    });


    // // Download current view as image
    // $("#download").on('click', function() {
    //   html2canvas(document.body, {
    //     allowTaint: true,
    //     useCORS: true,
    //     scale: 2
    //   }).then(function(canvas) {
    //     // Convert canvas to data URL and trigger download
    //     var imageData = canvas.toDataURL("image/png");
    //     var newData = imageData.replace(/^data:image\/png/, "data:application/octet-stream");
    //     $("#download").attr("download", "twibbon.png").attr("href", newData);
    //   });
    // });

    // // Download current view as image
    // $("#download").on('click', function() {
    //   console.log($('#previewCanvas')); // Log the canvas element
    //   html2canvas($('#previewCanvas')[0], {
    //     allowTaint: true,
    //     useCORS: true,
    //     scale: 2
    //   }).then(function(canvas) {
    //     // Convert canvas to data URL and trigger download
    //     var imageData = canvas.toDataURL("image/png");
    //     var newData = imageData.replace(/^data:image\/png/, "data:application/octet-stream");
    //     $("#download").attr("download", "twibbon.png").attr("href", newData);
    //   });
    // });
  </script>
</body>

</html>