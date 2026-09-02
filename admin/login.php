<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$_SESSION['sesionUsuario']['permisos'] = 0;
$_SESSION['sesionUsuario']['id'] = 0;
?>
<!DOCTYPE html>
<html dir="ltr" lang="en" class="no-outlines">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard - DAdmin</title>
    <meta name="author" content="">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link rel="icon" href="favicon.png" type="image/png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700%7CMontserrat:400,500,600,700">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/jquery-ui.min.css">
    <link rel="stylesheet" href="assets/css/perfect-scrollbar.min.css">
    <link rel="stylesheet" href="assets/css/morris.min.css">
    <link rel="stylesheet" href="assets/css/select2.min.css">
    <link rel="stylesheet" href="assets/css/jquery-jvectormap.min.css">
    <link rel="stylesheet" href="assets/css/horizontal-timeline.min.css">
    <link rel="stylesheet" href="assets/css/weather-icons.min.css">
    <link rel="stylesheet" href="assets/css/dropzone.min.css">
    <link rel="stylesheet" href="assets/css/ion.rangeSlider.min.css">
    <link rel="stylesheet" href="assets/css/ion.rangeSlider.skinFlat.min.css">
    <link rel="stylesheet" href="assets/css/datatables.min.css">
    <link rel="stylesheet" href="assets/css/fullcalendar.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body.login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0f1117;
            font-family: 'Montserrat', 'Open Sans', sans-serif;
            overflow: hidden;
        }

        /* Animated background */
        body.login-page::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 20% 50%, rgba(220, 38, 38, 0.12) 0%, transparent 60%),
                radial-gradient(ellipse 60% 80% at 80% 30%, rgba(239, 68, 68, 0.08) 0%, transparent 60%);
            pointer-events: none;
            z-index: 0;
        }

        .login-card {
            position: relative;
            z-index: 1;
            display: flex;
            width: min(900px, 95vw);
            min-height: 520px;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 32px 80px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(255,255,255,0.05);
        }

        /* LEFT PANEL */
        .login-panel-left {
            flex: 1;
            background: linear-gradient(145deg, #1a0000 0%, #2d0808 40%, #1a0000 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px 40px;
            position: relative;
            overflow: hidden;
        }

        .login-panel-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url('fondo2.jpg');
            background-size: cover;
            background-position: center;
            opacity: 0.08;
        }

        .login-panel-left::after {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 240px;
            height: 240px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(220, 38, 38, 0.3) 0%, transparent 70%);
        }

        .brand-logo {
            position: relative;
            z-index: 1;
            width: 200px;
            height: auto;
            border-radius: 0;
            border: none;
            object-fit: contain;
            box-shadow: none;
            margin-bottom: 28px;
            background: transparent;
        }

        .brand-title {
            position: relative;
            z-index: 1;
            font-size: 1.6rem;
            font-weight: 700;
            color: #ffffff;
            text-align: center;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
        }

        .brand-title span {
            color: #ef4444;
        }

        .brand-subtitle {
            position: relative;
            z-index: 1;
            font-size: 0.82rem;
            color: rgba(255,255,255,0.45);
            text-align: center;
            line-height: 1.7;
            max-width: 240px;
            font-weight: 400;
        }

        .brand-divider {
            position: relative;
            z-index: 1;
            width: 40px;
            height: 3px;
            background: linear-gradient(90deg, #dc2626, #ef4444);
            border-radius: 2px;
            margin: 20px auto;
        }

        /* RIGHT PANEL */
        .login-panel-right {
            flex: 1.1;
            background: #16181f;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 56px 48px;
        }

        .login-heading {
            font-size: 1.4rem;
            font-weight: 700;
            color: #f1f5f9;
            margin-bottom: 6px;
            text-align: center;
            letter-spacing: -0.2px;
        }

        .login-subheading {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.35);
            text-align: center;
            margin-bottom: 36px;
            font-weight: 400;
        }

        /* Form */
        .login-form { width: 100%; max-width: 320px; }

        .field-group {
            margin-bottom: 18px;
        }

        .field-label {
            display: block;
            font-size: 0.7rem;
            font-weight: 600;
            color: rgba(255,255,255,0.4);
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 8px;
        }

        .field-input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .field-icon {
            position: absolute;
            left: 16px;
            color: rgba(255,255,255,0.25);
            font-size: 0.85rem;
            pointer-events: none;
            transition: color 0.2s;
        }

        .field-input {
            width: 100%;
            padding: 14px 16px 14px 44px;
            background: rgba(255,255,255,0.05);
            border: 1.5px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            color: #f1f5f9;
            font-size: 0.88rem;
            font-family: 'Open Sans', sans-serif;
            outline: none;
            transition: border-color 0.25s, background 0.25s, box-shadow 0.25s;
        }

        .field-input::placeholder { color: rgba(255,255,255,0.2); }

        .field-input:focus {
            border-color: rgba(220, 38, 38, 0.7);
            background: rgba(255,255,255,0.07);
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.12);
        }

        .field-input:focus + .field-icon,
        .field-input-wrap:focus-within .field-icon {
            color: #ef4444;
        }

        /* reorder icon after input in DOM but visually show left */
        .field-input-wrap .field-icon { z-index: 2; }

        /* Show/hide password toggle */
        .field-toggle {
            position: absolute;
            right: 14px;
            background: none;
            border: none;
            color: rgba(255,255,255,0.2);
            cursor: pointer;
            font-size: 0.85rem;
            padding: 2px;
            transition: color 0.2s;
        }
        .field-toggle:hover { color: rgba(255,255,255,0.5); }

        /* Submit button */
        .btn-login {
            width: 100%;
            padding: 14px;
            margin-top: 8px;
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            color: #ffffff;
            font-size: 0.88rem;
            font-weight: 700;
            font-family: 'Montserrat', sans-serif;
            letter-spacing: 0.5px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: transform 0.15s, box-shadow 0.15s, opacity 0.15s;
            box-shadow: 0 4px 20px rgba(220, 38, 38, 0.35);
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.12) 0%, transparent 60%);
            border-radius: inherit;
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 28px rgba(220, 38, 38, 0.45);
        }

        .btn-login:active {
            transform: translateY(0);
            opacity: 0.9;
        }

        .btn-login:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Loading spinner inside button */
        .btn-login .spinner {
            display: none;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            vertical-align: middle;
            margin-right: 8px;
        }
        .btn-login.loading .spinner { display: inline-block; }
        .btn-login.loading .btn-text { opacity: 0.7; }

        @keyframes spin { to { transform: rotate(360deg); } }

        /* Footer */
        .login-footer {
            margin-top: 32px;
            text-align: center;
            font-size: 0.72rem;
            color: rgba(255,255,255,0.2);
            font-weight: 400;
        }

        /* Responsive */
        @media (max-width: 640px) {
            .login-panel-left { display: none; }
            .login-card { width: 95vw; border-radius: 18px; }
            .login-panel-right { padding: 40px 28px; }
        }

        /* Entry animation */
        .login-card {
            animation: cardIn 0.5s cubic-bezier(0.22, 1, 0.36, 1) both;
        }
        @keyframes cardIn {
            from { opacity: 0; transform: translateY(24px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
    </style>
</head>

<body class="login-page">
<div class="login-card">

    <!-- LEFT: branding -->
    <div class="login-panel-left">
        <img
            class="brand-logo"
            src="https://seminuevosharo.mx/assets/media/general/logo.png"
            alt="HARO Logo"
        >
        <div class="brand-title">Sistema <span>HARO</span></div>
        <div class="brand-divider"></div>
        <p class="brand-subtitle">
            Plataforma de administración interna para empleados autorizados de Seminuevos HARO.
        </p>
    </div>

    <!-- RIGHT: form -->
    <div class="login-panel-right">
        <h1 class="login-heading">Bienvenido de nuevo</h1>
        <p class="login-subheading">Ingresa tus credenciales para continuar</p>

        <form id="formularioInicio" class="login-form" autocomplete="off" novalidate>

            <div class="field-group">
                <label class="field-label" for="login-email">Usuario</label>
                <div class="field-input-wrap">
                    <span class="field-icon"><i class="fas fa-user"></i></span>
                    <input
                        id="login-email"
                        class="field-input"
                        type="text"
                        name="email"
                        placeholder="Ingresa tu usuario"
                        autocomplete="off"
                        required
                    >
                </div>
            </div>

            <div class="field-group">
                <label class="field-label" for="login-pass">Contraseña</label>
                <div class="field-input-wrap">
                    <span class="field-icon"><i class="fas fa-lock"></i></span>
                    <input
                        id="login-pass"
                        class="field-input"
                        type="password"
                        name="pass"
                        placeholder="Ingresa tu contraseña"
                        autocomplete="off"
                        required
                    >
                    <button type="button" class="field-toggle" id="togglePass" tabindex="-1" aria-label="Mostrar contraseña">
                        <i class="fas fa-eye" id="togglePassIcon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-login" id="btnLogin">
                <span class="spinner"></span>
                <span class="btn-text">Iniciar sesión</span>
            </button>

        </form>

        <div class="login-footer">&copy; 2024 10H &mdash; SKULL</div>
    </div>

</div>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery-ui.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/perfect-scrollbar.min.js"></script>
<script src="assets/js/jquery.sparkline.min.js"></script>
<script src="assets/js/raphael.min.js"></script>
<script src="assets/js/morris.min.js"></script>
<script src="assets/js/select2.min.js"></script>
<script src="assets/js/jquery-jvectormap.min.js"></script>
<script src="assets/js/jquery-jvectormap-world-mill.min.js"></script>
<script src="assets/js/horizontal-timeline.min.js"></script>
<script src="assets/js/jquery.validate.min.js"></script>
<script src="assets/js/jquery.steps.min.js"></script>
<script src="assets/js/dropzone.min.js"></script>
<script src="assets/js/ion.rangeSlider.min.js"></script>
<script src="assets/js/datatables.min.js"></script>
<script src="assets/js/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  // Toggle password visibility
  document.getElementById('togglePass').addEventListener('click', function () {
    var passInput = document.getElementById('login-pass');
    var icon = document.getElementById('togglePassIcon');
    if (passInput.type === 'password') {
      passInput.type = 'text';
      icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
      passInput.type = 'password';
      icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
  });

  window.addEventListener("DOMContentLoaded", function () {
    const formularioCat = document.getElementById("formularioInicio");
    const btnLogin = document.getElementById("btnLogin");

    formularioCat.addEventListener("submit", function (e) {
      e.preventDefault();

      btnLogin.disabled = true;
      btnLogin.classList.add('loading');

      var datosDeInicio = new FormData(formularioCat);
      datosDeInicio.append("accion", "inicio");

      fetch("api/apiUsuarios.php", {
          method: "POST",
          body: datosDeInicio,
        })
        .then((respuesta) => respuesta.json())
        .then((data) => {
          if (data != 0) {
            var idUser = data[0];
            var tipo = data[1];
            var permiso = data[2];
            var imagen = data[3];

            if (idUser != "0") {
              var datosDeInicioSesion = new FormData();
              datosDeInicioSesion.append("id", idUser);
              datosDeInicioSesion.append("permiso", tipo);
              datosDeInicioSesion.append("permiso_banca", permiso);
              datosDeInicioSesion.append("imagen", imagen);
              console.log(idUser);

              fetch("banca/api/adminSesiones.php", {
                  method: "POST",
                  body: datosDeInicioSesion,
                })
                .then((respuesta) => respuesta.json())
                .then((data) => {
                  console.log("<?php echo $_SESSION['sesionUsuario']['id']; ?>");
                  setTimeout(() => {
                    Swal.fire({
                      position: "top-end",
                      icon: "success",
                      title: "Bienvenido a HARO",
                      showConfirmButton: false,
                      timer: 3000
                    });
                    if (permiso == 'Banca' || permiso == 'Cashier') {
                      location.href = "/admin/banca/index.php";
                    } else {
                      location.href = "/admin/banca/index.php";
                    }
                  }, 2000);
                });
            }

          } else {
            btnLogin.disabled = false;
            btnLogin.classList.remove('loading');
            Swal.fire({
              position: "top-end",
              icon: "error",
              title: "Usuario / contraseña incorrectos",
              showConfirmButton: false,
              timer: 1500
            });
          }
        })
        .catch(() => {
          btnLogin.disabled = false;
          btnLogin.classList.remove('loading');
          Swal.fire({
            position: "top-end",
            icon: "error",
            title: "Error de conexión",
            showConfirmButton: false,
            timer: 1500
          });
        });
    });
  });
</script>
</body>

</html>
