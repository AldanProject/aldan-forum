<?php
if(isset($_POST['id_user']))
{
	$id = $_POST['id_user'];
	$biographyNew = $_POST['biography'];
	$locationNew = $_POST['location'];
	$genderNew = $_POST['gender'];
	$avatar = $_FILES['avatar'];

	if(!empty($biographyNew))
	{
		updateQuery('biography', $biographyNew, 'users', 'id_user', 'si', $id);
	}
	else
	{
		updateQuery('biography', '[NONE]', 'users', 'id_user', 'si', $id);	
	}

	if(!empty($locationNew))
	{
		updateQuery('location', $locationNew, 'users', 'id_user', 'si', $id);
	}
	else
	{
		updateQuery('location', '[NONE]', 'users', 'id_user', 'si', $id);	
	}

	updateQuery('gender', $genderNew, 'users', 'id_user', 'ii', $id);
	if(!empty($avatar))
	{
		if(preg_match("/(.png)+$/", $avatar['name']))
		{
			$image = imagecreatefrompng($avatar['tmp_name']);
			imagejpeg($image, $avatar['tmp_name'], 100);
			imagedestroy($image);
		}
		$uploadFile = "img/users/" . $id . ".jpg";
    	move_uploaded_file($avatar['tmp_name'], $uploadFile);
    	header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
		header("Pragma: no-cache"); // HTTP 1.0.
		header("Expires: 0");
	}
}

$result = selectQuery('username, biography, location, gender', 'users', 'id_user', 'i', $_SESSION['userID'], null);
if($result)
{
	$nr = mysqli_num_rows($result);
	if($nr > 0)
	{
		$rows = mysqli_fetch_assoc($result);
		$username = $rows['username'];
		if($rows['biography'] != "[NONE]")
		{
			$biography = $rows['biography'];
		}
		else
		{
			$biography = "";
		}

		if($rows['location'] != "[NONE]")
		{
			$location = $rows['location'];
		}
		else
		{
			$location = "";
		}

		$gender = $rows['gender'];
	}
	else
	{
		header("Location: " . SERVER_URL);
		die();
	}
}
else
{
	header("Location: " . SERVER_URL);
	die();
}
?>
<form method="post" class="new-forum login-form" enctype="multipart/form-data">
	<input type="hidden" name="id_user" value="<?php print($_SESSION['userID']); ?>">
	<p>Nombre de usuario</p>
	<input type="text" name="username" value="<?php print($username); ?>" disabled>
	<p>Biografía</p>
	<textarea name="biography"><?php print($biography); ?></textarea>
	<p>Locación</p>
	<input type="text" name="location" value="<?php print($location); ?>">
	<p>Género</p>
	<select name="gender">
		<option value="0" <?php if($gender == 0) { print('selected'); } ?>>Sin definir</option>
		<option value="2" <?php if($gender == 2) { print('selected'); } ?>>Femenino</option>
		<option value="1" <?php if($gender == 1) { print('selected'); } ?>>Masculino</option>
	</select>
	<p>Avatar</p>
	<input type="file" name="avatar" accept="image/jpeg, image/png">
	<p>Contraseña actual</p>
	<input type="password" name="password">
	<p>Nueva contraseña</p>
	<input type="password" name="passwordOne">
	<p>Repetir nueva contraseña</p>
	<input type="password" name="passwordTwo">
	<input type="submit" value="Guardar cambios">
</form>