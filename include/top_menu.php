
<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php">Guru Board</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		

			<ul class="nav navbar-nav navbar-right">
				<?php 
				if(isset($_SESSION["member_id"])){
					$l = $_SESSION["member_id"];
				}
				$p = $db_con->prepare("SELECT * FROM member WHERE m_id = :l");
				$p->bindParam(":l", $l);
				$p->execute();
				$r = $p->fetch(PDO::FETCH_ASSOC);
					if(isset($_SESSION["member_id"])&&$r["m_type"]==1){

				?>
				<li class="active"><a href="index.php">หน้าแรก</a></li>
				<li><a href="question_me.php">กระทู้ของฉัน</a></li>
				<li><a href="reply_me.php">ความคิดเห็น</a></li>
				<li><a href="profile.php"> <?php echo $_SESSION["member_name"]; ?></a></li>
				<li><a href="logout.php">[ออกจากระบบ]</a></li>
			<?php 
			}
				
				if(isset($_SESSION["member_id"])&&$r["m_type"]==2){
			?>
					
				<li><a href="admin_edit_index.php">แก้ไขกระทู้</a></li>
				<li><a href="admin_reply.php">แก้ไขความคิดเห็น</a></li>
				<li><a href="member.php">สมาชิก</a></li>
				<li><a href="profile.php"> <?php echo $_SESSION["member_name"]; ?></a></li>
				<li><a href="logout.php">[ออกจากระบบ]</a></li>
				<?php 
				}
					if(!isset($_SESSION["member_id"])){
				?>
				<li><a href="login.php">เข้าสู่ระบบ</a></li>
				<li><a href="register.php">ลงทะเบียน</a></li>
			<?php 
					}
			?>
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>