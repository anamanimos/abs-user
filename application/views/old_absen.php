<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        .container-custom {
            max-width: 750px;
            margin: 0 auto;
        }

        .profile-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
        }

        .camera-container {
            position: relative;
            width: 80%;
            max-width: 600px;
            height: auto;
            margin: 20px auto;
            overflow: hidden;
            text-align: center;
        }

        .camera-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        .photo-preview {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        .action-btns {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container container-custom mt-4">
        <h2 class="text-center">Absensi</h2>
        <div class="camera-container">
            <video id="videoElement" class="photo-preview" playsinline style="display: none;"></video>
            <img id="photoPreview" class="photo-preview" style="display: none;">
            <button class="camera-btn" id="openCameraBtn">Buka Kamera</button>
            <div class="action-btns" style="display: none;">
                <button class="camera-btn" id="retakePhotoBtn">Ambil Gambar Ulang</button>
                <button class="camera-btn" id="sendAbsenceBtn">Kirim Absen</button>
            </div>
        </div>
    </div>

    <div class="container-custom fixed-bottom">
        <nav class="navbar navbar-light bg-light border-top">
            <div class="container-fluid justify-content-around">
                <a class="navbar-brand text-center" href="<?= base_url() ?>">
                    <i class="bi bi-house-door"></i>
                    <br>
                    Dashboard
                </a>
                <a class="navbar-brand text-center" href="<?= base_url('absen') ?>">
                    <i class="bi bi-calendar-check"></i>
                    <br>
                    Absen
                </a>
                <a class="navbar-brand text-center" href="#" id="logout">
                    <i class="bi bi-box-arrow-right"></i>
                    <br>
                    Logout
                </a>
            </div>
        </nav>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#logout').on('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You will be logged out!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, log me out!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '<?php echo site_url('auth/logout'); ?>';
                    }
                });
            });

            // Check if today's absence has been done
            var todayAbsenceDone = <?= json_encode($today_absence_done) ?>;

            if (todayAbsenceDone) {
                $('#openCameraBtn').hide();
                Swal.fire({
                    icon: 'success',
                    title: 'Kamu sudah melakukan Absensi hari ini',
                    showConfirmButton: false,
                    timer: 1500
                });
            } else {
                $('#openCameraBtn').show();
            }

            $('#openCameraBtn').on('click', function() {
                openCamera('user');
            });

            function openCamera(facingMode) {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var latitude = position.coords.latitude;
                        var longitude = position.coords.longitude;

                        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                            navigator.mediaDevices.getUserMedia({
                                video: {
                                    facingMode: facingMode
                                }
                            }).then(function(stream) {
                                var video = $('#videoElement').get(0);
                                video.srcObject = stream;
                                video.play();
                                $('#videoElement').show();
                                $('#openCameraBtn').hide();
                                $('<button class="camera-btn">Ambil Gambar</button>')
                                    .appendTo('.camera-container')
                                    .on('click', function() {
                                        var canvas = document.createElement('canvas');
                                        canvas.width = video.videoWidth;
                                        canvas.height = video.videoHeight;
                                        canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                                        var imageUrl = canvas.toDataURL('image/jpeg');
                                        $('#photoPreview').attr('src', imageUrl).show();
                                        $('#videoElement').hide();
                                        $('.action-btns').show();
                                        $(this).remove();
                                    });
                            }).catch(function(error) {
                                console.error('Error accessing camera:', error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Error accessing camera. Please check your camera settings.'
                                });
                            });
                        } else {
                            console.error('getUserMedia not supported');
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'getUserMedia is not supported in this browser.'
                            });
                        }

                        $('#sendAbsenceBtn').click(function() {
                            // Get coordinates
                            if (navigator.geolocation) {
                                navigator.geolocation.getCurrentPosition(function(position) {
                                    var latitude = position.coords.latitude;
                                    var longitude = position.coords.longitude;

                                    // Get student_id (you might want to get it dynamically)
                                    var student_id = '12345'; // Replace with actual student ID
                                    var photo = document.getElementById('photoPreview').src;

                                    // Send AJAX request
                                    $.ajax({
                                        url: '<?= base_url('absen/ajax') ?>',
                                        type: 'POST',
                                        data: {
                                            student_id: student_id,
                                            latitude: latitude,
                                            longitude: longitude,
                                            photo: photo
                                        },
                                        success: function(response) {
                                            var result = JSON.parse(response);
                                            if (result.status === 'success') {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Absen Berhasil',
                                                    text: result.message,
                                                    showConfirmButton: false,
                                                    timer: 1500
                                                });
                                            } else {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Oops...',
                                                    text: result.message
                                                });
                                            }
                                        },
                                        error: function() {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Oops...',
                                                text: 'Gagal mengirim absen. Silakan coba lagi.'
                                            });
                                        }
                                    });
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Geolokasi tidak didukung oleh browser ini.'
                                });
                            }
                        });

                    }, function(error) {
                        console.error('Error getting location:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Error getting location.'
                        });
                    });
                } else {
                    console.error('Geolocation is not supported by this browser.');
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Geolocation is not supported by this browser.'
                    });
                }
            }
        });
    </script>
</body>

</html>