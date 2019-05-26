<?php include('layout/header.php'); ?>
<?php include('includes/functions.inc.php'); ?>

	<!-- Header Section -->
	<header>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			<a href="index.php" class="navbar-brand">Image Gallery</a>

			<ul class="navbar-nav">
				<li class="nav-item">
					<a href="#gallery" id="gallery-link" class="nav-link">Gallery</a>
				</li>
			</ul>
		</nav>
	</header><!-- /header -->

	<!-- Main Section -->
	<div class="container showcase mt-5">

	<?php
		if (isset($_GET['upload'])) {
			$upload = $_GET['upload'];

			if ($upload === 'empty') {
				echo setAlertMessages($alertTypeEmpty, $alertMessageWarningText);
			} else if ($upload === 'not-allowed') {
				echo setAlertMessages($alertTypeNotAllowed, $alertMessageNotAllowedText);
			} else if ($upload === 'error') {
				echo setAlertMessages($alertTypeError, $alertMessageErrorText);
			} else if ($upload === 'big-file-size') {
				echo setAlertMessages($alertTypeBigFileSize, $alertMessageBigFileSizeText);
			} else if ($upload === 'image-exist'){
				echo setAlertMessages($alertTypeImageExist, $alertMessageImageExistText);
			} else if ($upload === 'success') {
				echo setAlertMessages($alertTypeSuccess, $alertMessageSuccessText);
			}
		}
	?>

		<h1 class="mb-3">Upload and View Images</h1>
		<h2 class="sub-heading mb-3">Select the image to upload</h2>
		<form action="includes/upload.inc.php" method="POST" enctype="multipart/form-data">
			<div class="form-group bg-light border mb-4">
				<input type="file" name="file" class="form-control-file">
			</div>
			<div class="btn-wrapper mb-4">
				<button type="submit" name="upload" class="btn btn-primary">Upload</button>
			</div>
		</form>
		<p class="text-muted placeholder">Image Formats Allowed : <strong>JPEG JPG</strong> and <strong>PNG</strong></p>
		<p class="text-muted placeholder">File Size : Less Than <strong>2MB</strong></p>
	</div>

	<!-- Gallery Section -->
	<div id="gallery" class="gallery-wrapper mt-5 mb-5">
		<h2 class="p-3 mb-4 text-uppercase">Gallery</h2>
		<div class="container">
			<div class="row">

				<?php
					$path = 'uploads/thumb';
					//	Reomving the '..' & '.' from the array
					$images = array_diff(scandir($path, 1), array('..', '.'));

					foreach ($images as $image) {
						echo '<div class="col-lg-3 col-md-4 col-sm-6">
					<a href="view.php?image='.$image.'" class="d-block mb-4 h-100">
						<img class="img-fluid img-thumbnail" src="uploads/thumb/'.$image.'" alt="">
					</a>
				</div>';
					}
				?>

		</div>
	</div>

<?php include('layout/footer.php'); ?>
