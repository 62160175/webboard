<?php
include 'include/header.php';

//ลบข้อมูลในฐานข้อมูล
if (isset($_GET["del"])) {
	$del = $db_con->prepare("DELETE FROM reply WHERE rp_id = '" . $_GET["del"] . "' ");
	$del->execute();

	header("Location:reply_me.php");
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
		<hr>
		<div class="row">
			<div class="col-md-12">
				<h3>รายการ ความคิดเห็น </h3>
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>ความคิดเห็น</th>
								<th>วันที่สร้าง</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$sql = "SELECT * FROM reply 
                                                WHERE m_id = '" . $_SESSION["member_id"] . "' ORDER BY rp_id DESC";
							$stmt = $db_con->prepare($sql);
							$stmt->execute();

							while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { // mysql_fetch_assoc()
								$countReply = $db_con->prepare("SELECT * FROM `reply` WHERE qt_id = " . $row["qt_id"] . " ");
								$countReply->execute();
							?>
								<tr>
									<td><?php echo $row["rp_detail"]; ?></td>
									<td><?php echo $row["rp_created"]; ?></td>
									<td width="130">
										<a class="btn btn-info" href="reply_edit.php?edit=<?php echo $row["rp_id"]; ?>" role="button">แก้ไข</a>
										<a class="btn btn-danger" href="reply_me.php?del=<?php echo $row["rp_id"]; ?>" onclick="return confirm('ท่านต้องการลบแถวนี้ใช่หรือไม่');" role="button">ลบ</a>
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