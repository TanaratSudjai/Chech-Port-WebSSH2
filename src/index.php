<!DOCTYPE html>
<html>

<head>
	<title>MINI JECT</title>
</head>

<body>


	<?php
	error_reporting(0); // ปิดกั้น error extension 

	if (isset($_POST['submit'])) {
		$hostname = $_POST['hostname']; //ip server
		$username = $_POST['username']; //login "root"
		$password = $_POST['password']; // pasw "root"
		$portNumber = $_POST['port']; //portNumber

		try {

			$connection = ssh2_connect($hostname, 2222); // connect putty 2222 "ssh"

			if ($connection) {
				if (!ssh2_auth_password($connection, $username, $password)) {
					echo "<script>
						alert('Putty login error');
						</script>";
				} else {

					$command = "echo >/dev/tcp/$hostname/$portNumber && echo \"พอร์ต $portNumber เปิดใช้งาน\" || echo \"พอร์ต $portNumber ปิดใช้งาน\"";

					//    / dev / tcp -> connect host port result status port

					$stream = ssh2_exec($connection, $command);
					stream_set_blocking($stream, true);
					$output = stream_get_contents($stream);
				}
			} else {
				echo	"<script>
						alert('Connect putty error !');
						</script>";
			}
		} catch (Exception $e) {
			echo $e;
		}
	}
	?>

	<div class="container">
		<h2 style="color:green">WEBAPP PUTTY</h2>
		<form action="" method="post" enctype="multipart/form-data">
			<div class="conin">
				<div class="form_input">
					<label for="hostname">Hostname / Ipaddess</label>
					<input type="text" name="hostname" id="hostname" required>
				</div>
				<div class="form_input">
					<label for="username">User putty</label>
					<input type="text" name="username" id="username" required>
				</div>
				<div class="form_input">
					<label for="password">Password putty</label>
					<input type="password" name="password" id="password" required>
				</div>
				<div class="form_input">
					<label for="port">Port click </label>
					<input type="text" name="port" id="port">
				</div>
			</div>
			<input type="submit" name="submit" id="submit" value="ตรวจสอบ">
			<br><br>

			Port status
			<input style="color:green" type="text" value=" <?php echo $output; ?>">

		</form>
	</div>


</body>

</html>

<style>
	body {
		padding: 0;
		margin: 0;
		display: flex;
		justify-content: center;
		align-items: center;
	}

	.container {
		margin-top: 5%;
		background-color: black;
		color: aliceblue;
		width: 500px;
		padding: 5%;
	}

	.form_input {
		display: flex;
		flex-direction: column;
		margin-bottom: 10px;
	}

	.form_input label {
		margin-bottom: 5px;
	}

	.form_input input {
		padding: 5px;
	}

	#submit {
		margin-top: 10px;
		padding: 5px;
		background-color: green;
		color: white;
	}
</style>