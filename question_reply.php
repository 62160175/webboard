	<?php
	include 'include/header.php';

	//นับจำนวนผู้เข้ามาอ่าน
	$id = $_GET["qt_id"];

	$stmt = $db_con->prepare("SELECT * FROM question WHERE qt_id = :id");
	$stmt->execute(array(":id" => $id));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$count = $row['qt_view'] + 1;

	$update = $db_con->prepare("UPDATE question SET qt_view = :qt_view WHERE qt_id = :qt_id ");
	$update->bindParam(":qt_view", $count);
	$update->bindParam(":qt_id", $id);
	$update->execute();

	//ดึงข้อมูลกระทู้เพื่อมาแสดง
	$question = $db_con->prepare("SELECT * FROM question WHERE qt_id = '" . $_GET["qt_id"] . "'");
	$question->execute();
	$row = $question->fetch(PDO::FETCH_ASSOC);

	if (isset($_POST["comment"])) {

		if (!isset($_SESSION["member_id"])) {
			header("Location:login.php");
		}

		$stmt = $db_con->prepare("SELECT * FROM question WHERE qt_id = :id");
		$stmt->execute(array(":id" => $id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$count = $row['qt_reply'] + 1;

		$update = $db_con->prepare("UPDATE question SET qt_reply = :qt_reply WHERE qt_id = :qt_id ");
		$update->bindParam(":qt_reply", $count);
		$update->bindParam(":qt_id", $id);
		$update->execute();

		$detail = $_POST["rp_detail"];
		$id = $_POST["qt_id"];
		$created = date("Y-m-d H:i:s");
		$m_id = $_SESSION["member_id"];

		$rp_image = $_FILES['rp_image']['name'];
		$tmp_dir = $_FILES['rp_image']['tmp_name'];
		$upload_dir = "uploads/reply/" . $rp_image;
		move_uploaded_file($tmp_dir, $upload_dir);

		$sql = $db_con->prepare("INSERT INTO reply (rp_detail,rp_created,qt_id,rp_image,m_id) VALUES (?,?,?,?,?)");
		$sql->bindParam(1, $detail);
		$sql->bindParam(2, $created);
		$sql->bindParam(3, $id);
		$sql->bindParam(4, $rp_image);
		$sql->bindParam(5, $m_id);

		if ($sql->execute()) {
			echo "<script>alert('บันทึกข้อมูลสำเร็จ');window.location.href='question_reply.php?qt_id=" . $id . "'</script>";
		} else {
			echo "<script>alert('บันทึกข้อมูลไม่สำเร็จ');window.location.href='question_reply.php?qt_id=" . $id . "'</script>";
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
				<div class="col-md-12" style="border: 3px dashed #8BD2EC;background-color:#D0F4DE;font-size: 20px;">
					<h3><?php echo $row["qt_title"]; ?></h3>
					<?php echo $row["qt_detail"]; ?>
					<?php if ($row["qt_image"] != "") { ?>
						<div class="div" >
							<img src="uploads/image_qt/<?php echo $row["qt_image"]; ?>" width="200" height="100%">
						</div>
					<?php } ?>
					<hr>
				</div>
				<hr>
				<div class="row">
					<div class="col-md-12">
						<?php
						$l = 1;
						$reply = $db_con->prepare("SELECT * FROM reply 
														LEFT JOIN member ON (reply.m_id = member.m_id)
														WHERE qt_id = '" . $_GET["qt_id"] . "' ORDER BY rp_id DESC");
						$reply->execute();

						while ($row = $reply->fetch(PDO::FETCH_ASSOC)) { // mysql_fetch_assoc()
						?>
							<div class="panel panel-default" >
								<div class="panel-heading" style="border: 3px dashed #FFBBDA;background-color:#FEE5E0" ><strong>(ชือผู้ตอบ <?php echo ($row["m_name"]); ?>)
								</strong></div>
								<div class="panel-body" style="border: 3px dashed #FFBBDA;background-color:#FFFFE0">
									<div class="div">
										<?php
										if ($row["rp_image"] != null) {
										?>
											<img src="uploads/reply/<?php echo $row['rp_image'] ?>" width="100" height="100%">
										<?php
										}
										?>
									</div>

									<?php echo $row["rp_detail"]; ?>
									<p>&nbsp;</p>
									<small>สร้างเมื่อ <?php echo $row["rp_created"]; ?></small>
								</div>
							</div>
						<?php
						}
						?>


					</div>

				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-primary">
							<div class="panel-heading">แสดงความคิดเห็น</div>
							<div class="panel-body">
								<form method="post" action="" enctype="multipart/form-data">
									<div class="form-group">
										<label>ความคิดเห็น</label>
										<textarea class="form-control" name="rp_detail" rows="3" placeholder="ระบุรายละเอียด" required></textarea>
									</div>
									<div class="form-group">
										<label>รูป</label>
										<input type="file" accept="image/*" class="form-control" name="rp_image">
									</div>
									<input type="hidden" name="qt_id" value="<?php echo $_GET["qt_id"]; ?>">
									<button type="submit" name="comment" class="btn btn-primary">บันทึก</button>
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