$(document).ready(function () {
	// Fungsi untuk memeriksa akses kamera
	function checkCameraAccess() {
		navigator.mediaDevices
			.getUserMedia({ video: true })
			.then(function (stream) {
				console.log("Akses kamera diizinkan.");
				// Hentikan penggunaan stream setelah dicek
				stream.getTracks().forEach((track) => track.stop());
			})
			.catch(function (error) {
				if (
					error.name === "NotAllowedError" ||
					error.name === "PermissionDeniedError"
				) {
					console.log("Akses kamera ditolak oleh pengguna.");
					window.location.href = base_url + "/permission/camera";
				} else {
					console.log("Terjadi kesalahan lain:", error);
				}
			});
	}

	// Panggil fungsi untuk memeriksa akses kamera
	checkCameraAccess();

	$("#openCameraBtn").on("click", function () {
		$(this).attr("disabled", true);
		$(this).html(
			'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...'
		);
		openCamera("user");
	});

	function openCamera(facingMode) {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(
				function (position) {
					var latitude = position.coords.latitude;
					var longitude = position.coords.longitude;

					if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
						navigator.mediaDevices
							.getUserMedia({
								video: {
									facingMode: facingMode,
								},
							})
							.then(function (stream) {
								var video = $("#videoElement").get(0);
								video.srcObject = stream;
								video.play();
								$("#iconAbsen").hide();
								$("#videoElement").show();
								$("#openCameraBtn").hide();

								$(
									'<button class="camera-btn btn btn-primary btn-sm mt-3" id="takeImageBtn">Ambil Gambar</button>'
								)
									.appendTo("#cardFooterAbsen")
									.on("click", function () {
										$(this).attr("disabled", true);
										$(this).html(
											'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...'
										);
										var canvas = document.createElement("canvas");
										canvas.width = video.videoWidth;
										canvas.height = video.videoHeight;
										canvas
											.getContext("2d")
											.drawImage(video, 0, 0, canvas.width, canvas.height);
										var imageUrl = canvas.toDataURL("image/jpeg");
										$("#photoPreview").attr("src", imageUrl).show();
										$("#videoElement").hide();
										$(".action-btns").show();
										$(this).remove();
									});

								// Tambahkan fungsi untuk tombol retakePhotoBtn
								$("#retakePhotoBtn").on("click", function () {
									$("#photoPreview").hide();
									$("#videoElement").show();
									$(".action-btns").hide();

									// Tambahkan tombol "Ambil Gambar" lagi
									$(
										'<button class="camera-btn btn btn-primary btn-sm mt-3" id="takeImageBtn">Ambil Gambar</button>'
									)
										.appendTo("#cardFooterAbsen")
										.on("click", function () {
											$(this).attr("disabled", true);
											$(this).html(
												'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...'
											);
											var canvas = document.createElement("canvas");
											canvas.width = video.videoWidth;
											canvas.height = video.videoHeight;
											canvas
												.getContext("2d")
												.drawImage(video, 0, 0, canvas.width, canvas.height);
											var imageUrl = canvas.toDataURL("image/jpeg");
											$("#photoPreview").attr("src", imageUrl).show();
											$("#videoElement").hide();
											$(".action-btns").show();
											$(this).remove();
										});
								});
							})
							.catch(function (error) {
								console.error("Error accessing camera:", error);
								Swal.fire({
									icon: "error",
									title: "Oops...",
									text: "Error accessing camera. Please check your camera settings.",
								});
							});
					} else {
						console.error("getUserMedia not supported");
						Swal.fire({
							icon: "error",
							title: "Oops...",
							text: "getUserMedia is not supported in this browser.",
						});
					}
				},
				function (error) {
					console.error("Error getting location:", error);
					Swal.fire({
						icon: "error",
						title: "Oops...",
						text: "Error getting location.",
					});
				}
			);
		} else {
			console.error("Geolocation is not supported by this browser.");
			Swal.fire({
				icon: "error",
				title: "Oops...",
				text: "Geolocation is not supported by this browser.",
			});
		}
	}

	$("#sendAbsenceBtn").click(function () {
		if (navigator.geolocation) {
			$(this).attr("disabled", true);
			$(this).html(
				'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...'
			);

			navigator.geolocation.getCurrentPosition(function (position) {
				var latitude = position.coords.latitude;
				var longitude = position.coords.longitude;

				var student_id = "12345"; // Replace with actual student ID
				var photo = document.getElementById("photoPreview").src;

				$.ajax({
					url: base_url + "absen/ajax",
					type: "POST",
					data: {
						student_id: student_id,
						latitude: latitude,
						longitude: longitude,
						photo: photo,
					},
					success: function (response) {
						var result = JSON.parse(response);
						if (result.status === "success") {
							Swal.fire({
								icon: "success",
								title: "Absen Berhasil",
								text: result.message,
								showConfirmButton: false,
								timer: 1500,
							}).then(() => {
								location.reload();
							});
						} else {
							Swal.fire({
								icon: "error",
								title: "Oops...",
								text: result.message,
							});
						}
					},
					error: function () {
						Swal.fire({
							icon: "error",
							title: "Oops...",
							text: "Gagal mengirim absen. Silakan coba lagi.",
						});
					},
				});
			});
		} else {
			Swal.fire({
				icon: "error",
				title: "Oops...",
				text: "Geolokasi tidak didukung oleh browser ini.",
			});
		}
	});
});
