<?php
include 'include/header.php';

	if (isset($_SESSION['member_id'])) {
		header('location: index.php');
	}

	if (isset($_POST['login'])) {

		$email = $_POST['email'];
		$password = $_POST['password'];

		$query = $db_con->prepare("SELECT * FROM member WHERE email = :email");
		$query->bindParam("email", $email, PDO::PARAM_STR);
		$query->execute();
		$result = $query->fetch(PDO::FETCH_ASSOC);
		if (!$result) {
			$errorMsg = "เข้าสู่ระบบล้มเหลว";
		} else {
			if (password_verify($password, $result['password'])) {
				$_SESSION['member_id'] = $result['m_id'];
				$_SESSION["member_name"] = $result["m_name"];
				$_SESSION['member_m_type'] = $result['m_type'];
				header('Location: index.php');
			} else {
				$errorMsg = "รหัสผ่านผิด";
			}
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
					<div class="panel-heading"><strong>เข้าสู่ระบบ</strong></div>
					<div class="panel-body">
						<form method="post" action="">
							<div class="form-group">
								<label>ชื่อผู้ใช้งาน</label>
								<input type="text" name="email" class="form-control" placeholder="ระบุชื่อผู้ใช้งาน" required>
							</div>
							<div class="form-group">
								<label>รหัสผ่าน</label>
								<input type="password" name="password" class="form-control" placeholder="ระบุรหัสผ่าน" required>
							</div>
							<button type="submit" name="login" class="btn btn-primary">เข้าสู่ระบบ</button>
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