<header>
	<nav>
		<ul class="menu">

			<li class="menuBurger"><button><img src="./assets/menu.svg" alt="menu"></button></li>
			<li class="<?php if ($current == "home") {
				echo "active";
			} ?>"><a href="./">Home</a></li>
			<?php
			if (isset($_SESSION['loggedin'])): ?>
				<li class="<?php if ($current == "settings") {
					echo "active";
				} ?>"><a href="./settings.php">settings</a></li>
				<?php
			else: ?>
				<li class="<?php if ($current == "login" || $current == "register") {
					echo "active";
				} ?>"><a href="./login.php">login</a></li>
				<?php
			endif;
			?>
		</ul>
	</nav>
</header>