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
                                <th>ผู้ตั้งกระทู้</th>
                                <th>ลายละเอียด</th>
                                <th>วันที่สร้าง</th>
                                <th>รูปภาพ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = $db_con->prepare("SELECT * FROM reply LEFT JOIN member ON (reply.m_id = member.m_id) ORDER BY reply.rp_id DESC");
                            $sql->execute();
                            $result = $sql->fetchAll();
                            ?>
                            
                            <tr>
                                <?php foreach ($result as $row) { ?>
                                    <td><?php echo $row['m_name'] ?></td>
                                    <td><?php echo $row["rp_detail"]; ?></td>
									<td><?php echo $row["rp_created"]; ?></td>
                                    <td><?php
										if ($row["rp_image"] != null) {
										?>
											<img src="uploads/reply/<?php echo $row['rp_image'] ?>" width="64" height="64">
										<?php
										}
										?></td>
									<td width="130">
										<a class="btn btn-info" href="admin_edit_reply.php?edit=<?php echo $row["rp_id"]; ?>" role="button">แก้ไข</a>
										<a class="btn btn-danger" href="reply_me.php?del=<?php echo $row["rp_id"]; ?>" onclick="return confirm('ท่านต้องการลบแถวนี้ใช่หรือไม่');" role="button">ลบ</a>
									</td>
                            </tr>
                        <?php } ?>

                        </tbody>
                    </table>
				</div>
			</div>
		</div>
	</div>
</body>

</html>