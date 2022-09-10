<?php
include 'include/header.php';

//ลบข้อมูลในฐานข้อมูล
if (isset($_GET["del"])) {
	$del = $db_con->prepare("DELETE FROM member WHERE m_id = '" . $_GET["del"] . "' ");
	$del->execute();

	header("Location:profile.php");
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
				<h3>ข้อมูลของฉัน</h3>
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>อีเมล</th>
								<th>ชื่อ</th>
								<th>วันที่สร้าง</th>
								<th>รูปภาพ</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$query = $db_con->prepare("SELECT * FROM member WHERE m_id = '" . $_SESSION["member_id"] . "' ORDER BY m_id DESC");
							$query->execute();
							$row = $query->fetch(PDO::FETCH_ASSOC);
							?>
								<tr>
									<td><?php echo $row["email"]; ?></a></td>
									<td><?php echo $row["m_name"]; ?></td>
									<td><?php echo $row["m_created"]; ?></td>
									<td><img src="uploads/<?php echo $r['m_image'] ?>" alt="" width="64" height="64"></td>
									<td width="130">
										<a class="btn btn-info" href="profile_edit.php?edit=<?php echo $row["m_id"]; ?>" role="button">แก้ไข</a>
									</td>
								</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>

</html>