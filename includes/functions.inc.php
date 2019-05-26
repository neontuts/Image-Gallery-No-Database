<?php

// errorsTexts
$errorViewImagesText = 'Something Went Wrong';

// templates
$errorViewImages = "<h3 class='text-center'>{$errorViewImagesText}</h3>";

// Empty
$alertMessageWarningText = "Please select a file to upload.";
$alertTypeEmpty = "warning";

// NotAllowed
$alertMessageNotAllowedText = "You can upload only jpeg, jpg, png extensions files.";
$alertTypeNotAllowed = "danger";

// Error
$alertMessageErrorText = "Something went wrong, try again.";
$alertTypeError = "danger";

// BigFileSize
$alertMessageBigFileSizeText = "File size must be less than 2MB.";
$alertTypeBigFileSize = "danger";

// ImageExist
$alertMessageImageExistText = "The image already exists in the server.";
$alertTypeImageExist = "danger";

// Success
$alertMessageSuccessText = "Your file uploaded successfully.";
$alertTypeSuccess = "success";

// All functions

// function for viewing Images
function viewImages($getImages) {
	$extractImage = explode('_', htmlspecialchars($getImages));
	$image = end($extractImage);

	return '<img class="w-100" src="uploads/images/'.$image.'" alt="">';
}

// function for resizing jpg, gif, or png image files
function generateThumbnail($target, $newcopy, $w, $h, $ext) {
	list($w_orig, $h_orig) = getimagesize($target);
	$scale_ratio = $w_orig / $h_orig;
	if (($w / $h) > $scale_ratio) {
		$w = $h * $scale_ratio;
	} else {
		$h = $w / $scale_ratio;
	}
	$img = "";
	$ext = strtolower($ext);
	if ($ext == "gif"){
		$img = imagecreatefromgif($target);
	} else if($ext =="png"){
		$img = imagecreatefrompng($target);
	} else {
		$img = imagecreatefromjpeg($target);
	}
	$tci = imagecreatetruecolor($w, $h);

	imagecopyresampled($tci, $img, 0, 0, 0, 0, $w, $h, $w_orig, $h_orig);
	imagejpeg($tci, $newcopy, 80);
}

// function for setting location of header
function setLocationHeader($param = "") {
	$locationString = "";
	if(empty($param)) {
		$locationString = "Location: ../index.php";
	} else {
		$locationString = "Location: ../index.php?upload={$param}";
	}
	header($locationString);
	exit();
}

// function for uploading images
function uploadingImages() {
	if (isset($_POST['upload'])) {
		if (empty($_FILES['file']['name'])) {
			setLocationHeader("empty");
		} else {

			// variables for uploading images
			$imageName = $_FILES['file']['name'];
			$imageTmpName = $_FILES['file']['tmp_name'];
			$imageError = $_FILES['file']['error'];
			$imageSize = $_FILES['file']['size'];

			$extractExt = explode('.', $imageName);
			$imageExt = strtolower(end($extractExt));
			$allowed = array("jpeg", "jpg", "png");

			$imageNewName = uniqid('', true).".".$imageExt;
			$imageDestination = "../uploads/images/".$imageNewName;

			$target_file = "../uploads/images/{$imageNewName}";
			$resized_file = "../uploads/thumb/thumb_{$imageNewName}";
			$wmax = 350;
			$hmax = 300;

			if (!in_array($imageExt, $allowed)) {
				setLocationHeader("not-allowed");
			} else {
				if ($imageError > 0) {
					setLocationHeader("error");
				} else if ($imageError === 0) {
					if ($imageSize <= 2097152 === false) {
						setLocationHeader("big-file-size");
					} else {

						// checking image exist, if not upload the image
						$path = "../uploads/images";
						$backlist = array_diff(scandir($path, 1), array('..', '.'));
						$backlistMsg = array();

						foreach ($backlist as $image) {
							$md5Img1 = md5(file_get_contents($imageTmpName));
							$md5Img2 = md5(file_get_contents('../uploads/images/'.$image));

							if ($md5Img1 === $md5Img2) {
								array_push($backlistMsg, 'exist');
							} else {
								array_push($backlistMsg, 'not-exist');
							}
						}

						if (in_array('exist', $backlistMsg)) {
							setLocationHeader("image-exist");
						} else {
							move_uploaded_file($imageTmpName, $imageDestination);
						}
						// ---------- Include Universal Image Resizing Function --------
						generateThumbnail($target_file, $resized_file, $wmax, $hmax, $imageExt);
						// ----------- End Universal Image Resizing Function -----------
						setLocationHeader("success");
					}
				}
			}
		}
	} else {
		setLocationHeader();
	}
}

// function for setting Alert Messages
function setAlertMessages($alertType, $alertMessageText) {
	return "<div class='alert alert-{$alertType} alert-dismissible fade show' role='alert'>
				{$alertMessageText}
			<button type='button' class='close' data-dismiss='alert' aria-label='close'>
				<span aria-hidden='true'>&times;</span>
			</button>
		</div>";
}

?>
