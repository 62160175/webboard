<?php
include 'include/header.php';
if (isset($_POST['register'])) {
	$email = $_POST["email"];
	$password = $_POST["password"];
	$passHash = password_hash($password, PASSWORD_DEFAULT);
	$name = $_POST["m_name"];
	$created = date("Y-m-d H:i:s");

	$m_image = $_FILES['m_image']['name'];
	$tmp_dir = $_FILES['m_image']['tmp_name'];
	$upload_dir = "uploads/" . $m_image;
	move_uploaded_file($tmp_dir, $upload_dir);

	$sql = $db_con->prepare("INSERT INTO member (email,password,m_name,m_created,m_image) VALUES (?,?,?,?,?)");
	$sql->bindParam(1, $email);
	$sql->bindParam(2, $passHash);
	$sql->bindParam(3, $name);
	$sql->bindParam(4, $created);
	$sql->bindParam(5, $m_image);
	if ($sql->execute()) {
		echo "บันทึกข้อมูลได้สำเร็จ";
		echo "<meta http-equiv='refresh' content='1;url=login.php'>";
	} else {
		echo "บันทึกข้อมูลไม่สำเร็จ";
		echo "<meta http-equiv='refresh' content='1;url=register.php'>";
	}
}
?>

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
					<div class="panel-heading"><strong>ลงทะเบียน</strong></div>
					<div class="panel-body">
						<form method="post" action="" enctype="multipart/form-data">
							<div class="form-group">
								<label>E-mail</label>
								<input type="email" name="email" class="form-control" placeholder="ระบุอีเมล" required>
							</div>
							<div class="form-group">
								<label>รหัสผ่าน</label>
								<input type="password" name="password" class="form-control" placeholder="ระบุรหัสผ่าน" required>
							</div>
							<hr>
							<div class="form-group">
								<label>ชื่อ-นามสกุล</label>
								<input type="text" name="m_name" class="form-control" placeholder="ระบุชื่อ" required>
							</div>
							<div class="form-group">
								<label>รูปโปรไฟล์</label>
								<input type="file" accept="image/*" class="form-control" name="m_image">
							</div>
							<button type="submit" name="register" value="register" class="btn btn-primary">ลงทะเบียน</button>
							<a href="index.php" class="btn btn-danger">ยกเลิก</a>
						</form>
					</div>
				</div>
			</div>
		</div>
		<hr>
	</div>
</body>

</html>