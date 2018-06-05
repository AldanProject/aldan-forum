<?php
if(!isset($_SESSION['username']))
{
	header("Location: " . SERVER_URL);
}
?>
<h2 class="message large download-game">Medal of Darkness</h2>
<div class="download">
	<a class="download-button" href="<?php print(DOWNLOAD_URL); ?>">Descagar ahora</a>
</div>