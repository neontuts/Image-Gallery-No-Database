<!-- header and functions -->
<?php include('layout/header.php'); ?>
<?php include('includes/functions.inc.php'); ?>

	<!-- Header Section -->
	<h1 class="viewpage-heading bg-dark">View Or Download The Image</h1>

	<!-- Breadcrumb -->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="index.php">Home</a>
		</li>
		<li class="breadcrumb-item">
			View Image
		</li>
	</ol>

	<!-- viewImage Section -->
	<div class="container mt-5 mb-5">
		<?php
			if (isset($_GET['image'])) {
				echo viewImages($_GET['image']);
			} else {
				echo $errorViewImages;
			}
		?>
	</div>
<!-- footer -->
<?php include('layout/footer.php'); ?>
