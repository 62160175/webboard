	<?php
	include 'include/header.php';

	//ดึงข้อมูลเพื่อมาแสดงเพื่อทำการแก้ไข
	$sql = "SELECT * FROM question WHERE qt_id = '" . $_GET["edit"] . "' ";
	$update = $db_con->prepare($sql);
	$update->execute();
	$row = $update->fetch(PDO::FETCH_ASSOC);

	if (isset($_POST["update"])) {
		$title = $_POST["qt_title"];
		$detail = $_POST["qt_detail"];
		$id = $_POST["qt_id"];

		$p = "SELECT * FROM question WHERE qt_id = ?";
		$p = $db_con->prepare("SELECT * FROM question WHERE qt_id = ?");
		$p->bindParam(1, $id);
		$p->execute();
		$r = $p->fetch(PDO::FETCH_ASSOC);

		$qt_image = $_FILES['qt_image']['name'];
		$tmp_dir = $_FILES['qt_image']['tmp_name'];
		$upload_dir = "uploads/image_qt/" . $qt_image;
		$dir = "uploads/image_qt/";
		if ($qt_image) {
			if (!file_exists($upload_dir)) {
				unlink($dir . $r["qt_image"]);
				move_uploaded_file($tmp_dir, "uploads/image_qt/" . $qt_image);
			}
		} else {
			$qt_image = $r["qt_image"];
		}
		$sql = "UPDATE question SET qt_title = ?,qt_detail = ? ,qt_image = ? WHERE qt_id = ? ";
		$update = $db_con->prepare("UPDATE question SET qt_title = ?,qt_detail = ? ,qt_image = ? WHERE qt_id = ? ");
		$update->bindParam(1, $title);
		$update->bindParam(2, $detail);
		$update->bindParam(3, $qt_image);
		$update->bindParam(4, $id);
		$update->execute();
		if ($update) {
			echo "<script>alert('แก้ไขข้อมูลสำเร็จ');window.location.href='index.php';</script>";
		} else {
			echo "<script>alert('แก้ไขข้อมูลไม่สำเร็จ');</script>";
			header("Location: question_edit.php?edit=" . $id);
		}
	}

	?>
	</head>

	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<?php include 'include/top_menu.php' ?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<div class="panel panel-default">
						<div class="panel-heading"><strong>แก้ไขกระทู้</strong></div>
						<div class="panel-body">
							<form method="post" action="" enctype="multipart/form-data">
								<div class="form-group">
									<label>หัวข้อ</label>
									<input type="text" name="qt_title" class="form-control" value="<?php echo $row["qt_title"]; ?>" required>
								</div>
								<div class="form-group">
									<label>รายละเอียด</label>
									<textarea class="form-control" name="qt_detail" required><?php echo $row["qt_detail"]; ?> </textarea>
								</div>
								<div class="form-group">
									<label>รูป</label>
									<input type="file" accept="image/*" class="form-control" name="qt_image">
								</div>
								<input type="hidden" name="qt_id" id="qt_id" value="<?php echo $row["qt_id"]; ?>" />
								<button type="submit" name="update" class="btn btn-primary">บันทึก</button>
								<a href="question_me.php" class="btn btn-danger">ยกเลิก</a>
							</form>
						</div>
					</div>
				</div>
			</div>
			<hr>
		</div>
	</body>

	</html>