		<?php
		include 'include/header.php';

		if (!isset($_SESSION["member_name"])) {
			header("Location:login.php");
		}

		if (isset($_POST['register'])) {
			$title = $_POST["qt_title"];
			$detail = $_POST["qt_detail"];
			$id = $_SESSION["member_id"];
			$created = date("Y-m-d H:i:s");

			$qt_image = $_FILES['qt_image']['name'];
			$tmp_dir = $_FILES['qt_image']['tmp_name'];
			$upload_dir = "uploads/image_qt/" . $qt_image;
			move_uploaded_file($tmp_dir, $upload_dir);

			$stmt = $db_con->prepare("INSERT INTO question (qt_title,qt_detail,qt_created,m_id,qt_image) VALUES (?,?,?,?,?)");
			$stmt->bindParam(1, $title);
			$stmt->bindParam(2, $detail);
			$stmt->bindParam(3, $created);
			$stmt->bindParam(4, $id);
			$stmt->bindParam(5, $qt_image);

			if ($stmt->execute()) {
				echo "<script>alert('เพิ่มข้อมูลสำเร็จ');window.location.href='index.php';</script>";
			} else {
				echo "<script>alert('เพิ่มข้อมูลไม่สำเร็จ');</script>";
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
							<div class="panel-heading"><strong>ตั้งกระทู้</strong></div>
							<div class="panel-body">
								<form method="post" action="" enctype="multipart/form-data">
									<div class="form-group">
										<label>หัวข้อ</label>
										<input type="text" name="qt_title" class="form-control" placeholder="ระบุหัวข้อ" required>
									</div>
									<div class="form-group">
										<label>รายละเอียด</label>
										<textarea class="form-control" name="qt_detail" rows="3" placeholder="ระบุรายละเอียด" required></textarea>
									</div>
									<div class="form-group">
										<label>รูป</label>
										<input type="file" accept="image/*" class="form-control" name="qt_image">
									</div>
									<button type="submit" name="register" value="register" class="btn btn-primary">สร้าง</button>
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