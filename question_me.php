	<?php
	include 'include/header.php';

	//ลบข้อมูลในฐานข้อมูล
	if (isset($_GET["del"])) {
		$del = $db_con->prepare("DELETE FROM question WHERE qt_id = '" . $_GET["del"] . "' ");
		$del->execute();

		header("Location:question_me.php");
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
				<div class="col-md-12">
					<a class="btn btn-success" href="question_add.php" role="button"><span class="glyphicon glyphicon-plus"></span> ตั้งกระทู้</a>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-12">
					<h3>รายการกระทู้ของฉัน</h3>
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>หัวข้อคำถาม</th>
									<th>จำนวนผู้เข้าอ่าน</th>
									<th>จำนวนผู้เข้าตอบ</th>
									<th>วันที่สร้าง</th>
									<th>จัดการ</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$sql = "SELECT * FROM question WHERE m_id = '" . $_SESSION["member_id"] . "' ORDER BY qt_id DESC";
								$stmt = $db_con->prepare($sql);
								$stmt->execute();

								while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { // mysql_fetch_assoc()
									$countReply = $db_con->prepare("SELECT * FROM `reply` WHERE qt_id = " . $row["qt_id"] . " ");
									$countReply->execute();
								?>
									<tr>
										<td><a href="question_reply.php?qt_id=<?php echo $row["qt_id"]; ?>"><?php echo $row["qt_title"]; ?></a></td>
										<td><?php echo $row["qt_view"]; ?></td>
										<td><?php echo $row["qt_reply"]; ?></td>
										<td><?php echo $row["qt_created"]; ?></td>
										<td width="130">
											<a class="btn btn-info" href="question_edit.php?edit=<?php echo $row["qt_id"]; ?>" role="button">แก้ไข</a>
											<a class="btn btn-danger" href="question_me.php?del=<?php echo $row["qt_id"]; ?>" onclick="return confirm('ท่านต้องการลบใช่หรือไม่');" role="button">ลบ</a>
										</td>
									</tr>
								<?php
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</body>

	</html>