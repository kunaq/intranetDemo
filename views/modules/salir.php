<?php

//Destruimos las sesiones habilitadas
session_destroy();

echo '<script>
	window.location = "inicio"
</script>';