$(document).ready(function () {
	// Fungsi untuk memeriksa akses kamera
	function checkCameraAccess() {
		navigator.mediaDevices
			.getUserMedia({ video: true })
			.then(function (stream) {
				console.log("Akses kamera diizinkan.");
				stream.getTracks().forEach((track) => track.stop());
			})
			.catch(function (error) {
				if (
					error.name === "NotAllowedError" ||
					error.name === "PermissionDeniedError"
				) {
					console.log("Akses kamera ditolak oleh pengguna.");
					window.location.href = base_url + "permission/camera";
				} else {
					console.log("Terjadi kesalahan lain:", error);
				}
			});
	}

	const absenceCamera = $('input[name="absence-camera"]').val();
	if (absenceCamera === true) {
		// Panggil fungsi untuk memeriksa akses kamera
		checkCameraAccess();
	}

	function getCurrentPosition(callback) {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(
				function (position) {
					callback(position.coords.latitude, position.coords.longitude);
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

	function checkArea(latitude, longitude, callback) {
		$.ajax({
			url: base_url + "absen/check_area",
			type: "POST",
			data: {
				latitude: latitude,
				longitude: longitude,
			},
			success: function (response) {
				var result = JSON.parse(response);
				callback(result.status === "success");
			},
			error: function () {
				console.error("Error checking absence area.");
				callback(false);
			},
		});
	}

	function openCamera(facingMode) {
		navigator.mediaDevices
			.getUserMedia({ video: { facingMode: facingMode } })
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
						$(this)
							.attr("disabled", true)
							.html(
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

				$("#retakePhotoBtn").on("click", function () {
					$("#photoPreview").hide();
					$("#videoElement").show();
					$(".action-btns").hide();

					$(
						'<button class="camera-btn btn btn-primary btn-sm mt-3" id="takeImageBtn">Ambil Gambar</button>'
					)
						.appendTo("#cardFooterAbsen")
						.on("click", function () {
							$(this)
								.attr("disabled", true)
								.html(
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
	}

	function sendAbsence(latitude, longitude, photo, session_id) {
		$.ajax({
			url: base_url + "absen/ajax",
			type: "POST",
			data: {
				latitude: latitude,
				longitude: longitude,
				photo: photo,
				session_id: session_id,
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
					}).then(() => {
						location.reload();
					});
				}
			},
			error: function () {
				Swal.fire({
					icon: "error",
					title: "Oops...",
					text: "Gagal mengirim absen. Silakan coba lagi.",
				}).then(() => {
					location.reload();
				});
			},
		});
	}

	// Lakukan pengecekan area ketika halaman baru saja di reload jika allow === "true"
	if ($("input[name='allow']").val() === "true") {
		getCurrentPosition(function (latitude, longitude) {
			checkArea(latitude, longitude, function (isInside) {
				if (isInside) {
					console.log("User berada di dalam area absen.");
				} else {
					console.log("User tidak berada di dalam area absen.");
					window.location.href = base_url + "permission/outofarea";
				}
			});
		});
	}

	$("#openCameraBtn").on("click", function () {
		$(this)
			.attr("disabled", true)
			.html(
				'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...'
			);
		$("#row-opening").addClass("d-none");
		openCamera("user");
	});

	$("#sendAbsenceBtn").click(function () {
		if (navigator.geolocation) {
			$(this)
				.attr("disabled", true)
				.html(
					'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...'
				);

			getCurrentPosition(function (latitude, longitude) {
				var photo = $("#photoPreview").attr("src");
				var session_id = window.location.pathname.split("/").pop();

				checkArea(latitude, longitude, function (isInside) {
					if (isInside) {
						sendAbsence(latitude, longitude, photo, session_id);
					} else {
						window.location.href = base_url + "permission/outofarea";
						$("#sendAbsenceBtn").removeAttr("disabled").html("Kirim Absen");
					}
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

	$("#absenceNoCamera").on("click", function () {
		Swal.fire({
			title: "Konfirmasi",
			text: "Apakah Anda yakin?",
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: "Ya, kirim absen",
			cancelButtonText: "Batal",
		}).then((result) => {
			if (result.isConfirmed) {
				if (navigator.geolocation) {
					$(this)
						.attr("disabled", true)
						.html(
							'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...'
						);

					getCurrentPosition((latitude, longitude) => {
						var session_id = window.location.pathname.split("/").pop();

						checkArea(latitude, longitude, (isInside) => {
							if (isInside) {
								sendAbsence(latitude, longitude, "", session_id);
							} else {
								window.location.href = base_url + "permission/outofarea";
								$("#absenceNoCamera")
									.removeAttr("disabled")
									.html("Kirim Absen");
							}
						});
					});
				} else {
					Swal.fire({
						icon: "error",
						title: "Oops...",
						text: "Geolokasi tidak didukung oleh browser ini.",
					});
				}
			}
		});
	});
});
