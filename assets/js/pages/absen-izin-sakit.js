$(document).ready(function () {
	$("#fileInput").on("change", function (event) {
		var file = event.target.files[0];
		if (file) {
			var fileName = file.name;
			var fileSize = (file.size / 1024 / 1024).toFixed(2); // Size in MB
			var fileExtension = fileName.split(".").pop().toLowerCase();
			var allowedExtensions = ["jpg", "png", "pdf"];
			var maxSize = 1; // Max size in MB

			if ($.inArray(fileExtension, allowedExtensions) === -1) {
				Swal.fire({
					icon: "error",
					title: "Format File Tidak Diperbolehkan",
					text: "Format file yang diperbolehkan hanya jpg, png, pdf.",
				});
				return;
			}

			if (fileSize > maxSize) {
				Swal.fire({
					icon: "error",
					title: "Ukuran File Terlalu Besar",
					text: "Ukuran file maksimal adalah 1MB.",
				});
				return;
			}

			if (fileName.length > 20) {
				var truncatedFileName =
					fileName.substring(0, 15) + "... ." + fileExtension;
			} else {
				var truncatedFileName = fileName;
			}

			$(".file-icon").text(fileExtension.toUpperCase());
			$(".file-name").text(truncatedFileName);
			$(".file-size").text("Size: " + fileSize + " MB");

			$(".absence-upload-container").hide();
			$(".absence-file-card").show();
		}
	});

	$("#saveAbsence").on("click", function () {
		var fileInput = $("#fileInput")[0].files[0];

		// Cek apakah file sudah dipilih
		if (!fileInput) {
			Swal.fire({
				icon: "error",
				title: "File Tidak Ditemukan",
				text: "Harap pilih file sebelum menyimpan absensi.",
			});
			return;
		}

		// Disable button and show loader
		$("#saveAbsence")
			.prop("disabled", true)
			.html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');

		// Check if Geolocation is available
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(
				function (position) {
					var latitude = position.coords.latitude;
					var longitude = position.coords.longitude;

					var formData = new FormData();
					formData.append("status", $("input[name='status']:checked").val());
					formData.append("latitude", latitude);
					formData.append("longitude", longitude);
					formData.append("reason", $("textarea[name='reason']").val());
					formData.append("photo", fileInput);

					$.ajax({
						url: base_url + "absen/ajaxizinsakit",
						type: "POST",
						data: formData,
						contentType: false,
						processData: false,
						success: function (response) {
							var data = JSON.parse(response);
							if (data.status === "success") {
								Swal.fire({
									icon: "success",
									title: "Absensi Berhasil",
									text: data.message,
								}).then(() => {
									location.reload();
								});
							} else {
								Swal.fire({
									icon: "error",
									title: "Absensi Gagal",
									text: data.message,
								});
								// Re-enable button and reset text
								$("#saveAbsence")
									.prop("disabled", false)
									.html("Absen Sekarang");
							}
						},
						error: function () {
							Swal.fire({
								icon: "error",
								title: "Kesalahan",
								text: "Terjadi kesalahan saat mengirim data.",
							});
							// Re-enable button and reset text
							$("#saveAbsence").prop("disabled", false).html("Absen Sekarang");
						},
					});
				},
				function (error) {
					Swal.fire({
						icon: "error",
						title: "Geolocation Error",
						text: "Tidak dapat mengambil lokasi Anda.",
					});
					// Re-enable button and reset text
					$("#saveAbsence").prop("disabled", false).html("Absen Sekarang");
				}
			);
		} else {
			Swal.fire({
				icon: "error",
				title: "Geolocation Not Available",
				text: "Browser Anda tidak mendukung Geolocation.",
			});
			// Re-enable button and reset text
			$("#saveAbsence").prop("disabled", false).html("Absen Sekarang");
		}
	});
});
