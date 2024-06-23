<?php
	$_SESSION['nonce'] = base64_encode(bin2hex(openssl_random_pseudo_bytes(7)));
?>
<meta http-equiv="content-language" content="es-ar" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<!--<meta http-equiv="Content-Security-Policy" content="script-src 'nonce-<?= $_SESSION['nonce'] ?>' 'self' 'unsafe-eval'; style-src 'self' 'unsafe-inline'; default-src 'self'; img-src 'self' data:" /> <!--'strict-dynamic'-->

<title><?php

	$nombre_pagina = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
	if (strpos($nombre_pagina, '/') !== FALSE )
		$nombre_pagina = preg_replace('/\.php$/', '' , explode('/', $nombre_pagina));

	echo $nombre_pagina[2];

	$link= basename($_SERVER['PHP_SELF']);
	?>
</title>
<link rel="stylesheet" type="text/css" href="css/abm.css?v=2.034">
<link rel="stylesheet" type="text/css" href="css/alertify.css">
<link rel="stylesheet" type="text/css" href="css/style.css?v=0.2">
<link rel="preload" as="font" crossorigin href="fonts/KFOmCnqEu92Fr1Mu4mxK.woff2">
<link rel="preload" as="font" crossorigin href="fonts/KFOlCnqEu92Fr1MmWUlfBBc4.woff2">
<link rel="stylesheet" type="text/css" href="css/estilos-doc.css?v=2.09">
<link rel="shortcut icon" type="image/x-icon" href="imagenes/favesc.ico">
<link rel="stylesheet" type="text/css" href="css/alerta.css?v=2.09">
<noscript><meta http-equiv="Refresh" content="0;url=../acceso/login.php?access=javascript"></noscript>
