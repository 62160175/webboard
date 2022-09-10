<?php
include 'include/header.php';
?>

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
                <h3>รายการกระทู้ทั้งหมด</h3>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>หัวข้อคำถาม</th>
                                <th>จำนวนผู้เข้าอ่าน</th>
                                <th>จำนวนผู้เข้าตอบ</th>
                                <th>วันที่สร้าง</th>
                                <th>ผู้ตั้งกระทู้</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = $db_con->prepare("SELECT * FROM question LEFT JOIN member ON (question.m_id = member.m_id) ORDER BY question.qt_id DESC");
                            $sql->execute();
                            $result = $sql->fetchAll();
                            ?>
                            <tr>
                                <?php foreach ($result as $row) { ?>
                                    <td><a href="question_reply.php?qt_id=<?php echo $row['qt_id'] ?>"><?php echo $row['qt_title'] ?></a></td>
                                    <td><?php echo $row['qt_view'] ?></td>
                                    <td><?php echo $row['qt_reply'] ?></td>
                                    <td><?php echo $row['qt_created'] ?></td>
                                    <td><?php echo $row['m_name'] ?></td>
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