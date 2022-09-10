<?php
include 'include/header.php';

//ดึงข้อมูลเพื่อมาแสดงเพื่อทำการแก้ไข
$sql = $db_con->prepare("SELECT * FROM member WHERE m_id = '" . $_GET["edit"] . "' ");
$sql->execute();
$row = $sql->fetch(PDO::FETCH_ASSOC);

if (isset($_POST["update"])) {
	
	$m_name = $_POST["m_name"];
	$id = $_POST["m_id"];

	$p = $db_con->prepare("SELECT * FROM member WHERE m_id = ?");
	$p->bindParam(1, $id);
	$p->execute();
	$r = $p->fetch(PDO::FETCH_ASSOC);

	$m_image = $_FILES['m_image']['name'];
	$tmp_dir = $_FILES['m_image']['tmp_name'];
	$upload_dir = "uploads/" . $m_image;
	$dir = "uploads/";
	if ($m_image) {
		if (!file_exists($upload_dir)) {
			unlink($dir . $r["m_image"]);
			move_uploaded_file($tmp_dir, "uploads/" . $m_image);
		}
	} else {
		$m_image = $r["m_image"];
	}

	$query = $db_con->prepare("UPDATE member SET m_name = ?, m_image = ? WHERE m_id = ? ");
	$query->bindParam(1, $m_name);
	$query->bindParam(2, $m_image);
	$query->bindParam(3, $id);
	
	if ($query->execute()) {
		echo "<script>alert('แก้ไขข้อมูลสำเร็จ');window.location.href='profile.php';</script>";
	} else {
		echo "<script>alert('แก้ไขข้อมูลไม่สำเร็จ');window.location.href='profile.php';</script>";
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
					<div class="panel-heading"><strong>แก้ไขข้อมูล</strong></div>
					<div class="panel-body">
						<form method="post" action="" enctype="multipart/form-data">
							<div class="form-group">
								<label>Full Name</label>
								<input type="text" class="form-control" name="m_name" value="<?php echo $row["m_name"]; ?>" required>
							</div>
							<div class="form-group">
								<label>Picture</label>
								<input type="file" class="form-control" name="m_image" value="<?php echo $row["m_image"]; ?>">
							</div>
							<input type="hidden" name="m_id" id="m_id" value="<?php echo $row["m_id"]; ?>" />
							<button type="submit" name="update" class="btn btn-primary">บันทึก</button>
							<a href="profile.php" class="btn btn-danger">ยกเลิก</a>
						</form>
					</div>
				</div>
			</div>
		</div>
		<hr>
	</div>
</body>

</html>