<?php
include 'include/header.php';

//ลบข้อมูลในฐานข้อมูล
if (isset($_GET["del"])) {
	$del = $db_con->prepare("DELETE FROM member WHERE m_id = '" . $_GET["del"] . "' ");
	$del->execute();

	header("Location:member.php");
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
		<h3>รายการสมาชิกทั้งหมด</h3>
		<hr>
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Name</th>
								<th>Status</th>
								<th>Email</th>
								<th>วันที่สร้าง</th>
								<th>รูปภาพ</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$sql = "SELECT * FROM member ORDER BY m_id = '" . $_SESSION["member_id"] . "'";
							$stmt = $db_con->prepare($sql);
							$stmt->execute();

							while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { // mysql_fetch_assoc()
								$countReply = $db_con->prepare("SELECT * FROM `member` WHERE m_id = " . $row["m_id"] . " ");
								$countReply->execute();
							?>
								<tr>
									<td><?php echo $row["m_name"]; ?></td>
									<td><?php echo $row["m_type"]; ?></td>
									<td><?php echo $row["email"]; ?></td>
									<td><?php echo $row["m_created"]; ?></td>
									<td><?php
										if ($row["m_image"] != null) {
										?>
											<img src="uploads/<?php echo $row['m_image'] ?>" width="64" height="100%">
										<?php
										}
										?></td>
									<td width="130">
										<a class="btn btn-info" href="member_edit.php?edit=<?php echo $row["m_id"]; ?>" role="button">แก้ไข</a>
										<a class="btn btn-danger" href="member.php?del=<?php echo $row["m_id"]; ?>" onclick="return confirm('ท่านต้องการลบแถวนี้ใช่หรือไม่');" role="button">ลบ</a>
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