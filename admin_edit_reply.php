<?php
include 'include/header.php';

//ดึงข้อมูลเพื่อมาแสดงเพื่อทำการแก้ไข
$sql = "SELECT * FROM reply WHERE rp_id = '" . $_GET["edit"] . "' ";
$update = $db_con->prepare($sql);
$update->execute();
$row = $update->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['update'])) {
	$detail = $_POST["rp_detail"];
	$id = $_POST["rp_id"];

	$p = "SELECT * FROM reply WHERE rp_id = ?";
	$p = $db_con->prepare("SELECT * FROM reply WHERE rp_id = ?");
	$p->bindParam(1, $id);
	$p->execute();
	$r = $p->fetch(PDO::FETCH_ASSOC);


	$rp_image = $_FILES['rp_image']['name'];
	$tmp_dir = $_FILES['rp_image']['tmp_name'];
	$upload_dir = "uploads/reply/" . $rp_image;
	$dir = "uploads/reply/";
	if ($rp_image) {
		if (!file_exists($upload_dir)) {
			unlink($dir . $r["rp_image"]);
			move_uploaded_file($tmp_dir, "uploads/reply/" . $rp_image);
		}
	} else {
		$rp_image = $r["rp_image"];
	}

	$sql = "UPDATE reply SET rp_detail = ?, rp_image = ? WHERE rp_id = ? ";
	$update = $db_con->prepare("UPDATE reply SET rp_detail = :detail, rp_image = :image WHERE rp_id = :id ");
	$update->bindParam(":detail", $detail);
	$update->bindParam(":image", $rp_image);
	$update->bindParam(":id", $id);
	
	if ($update->execute()) {
		echo "<script>alert('แก้ไขข้อมูลสำเร็จ'); window.location.href='admin_reply.php';</script>";
	} else {
		echo "<script>alert('แก้ไขข้อมูลไม่สำเร็จ'); window.location.href='admin_reply.php';</script>";
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
					<div class="panel-heading"><strong>แก้ไขความคิดเห็น</strong></div>
					<div class="panel-body">
						<form method="post" action="" enctype="multipart/form-data">
							<div class="form-group">
								<label>แก้ไข</label>
								<textarea class="form-control" name="rp_detail" rows="3" placeholder="ระบุรายละเอียด" required><?php echo $row["rp_detail"]; ?></textarea>
							</div>
							<div class="form-group">
								<label>แก้ไขรูป</label>
								<input type="file" accept="image/*" class="form-control" name="rp_image">
							</div>
							<input type="hidden" name="rp_id" id="rp_id" value="<?php echo $row["rp_id"]; ?>" />
							<button type="submit" name="update" class="btn btn-primary">บันทึก</button>
							<a href="reply_me.php" class="btn btn-danger">ยกเลิก</a>
						</form>
					</div>
				</div>
			</div>
		</div>
		<hr>
	</div>
</body>

</html>