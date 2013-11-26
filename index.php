<?php
require './librerias/sesion.php';
$sesion = new manejadorSesion;
?>
<!DOCTYPE HTML>
<html>

<head>
  <title>Gestion de contratos</title>
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <!-- modernizr enables HTML5 elements and feature detects -->
  <script type="text/javascript" src="js/modernizr-1.5.min.js"></script>
</head>

<body>
  <div id="main">
    <header>
      <div id="logo">
        <div id="logo_text">
          <!-- class="logo_colour", allows you to change the colour of the text -->
          <h1><a href="index.html">Gestion <span class="logo_colour">de contratos</span></a></h1>
          <h2>PEMEX</h2>
        </div>
      </div>
      <nav>
        <?php
        $menuNivel = "";
        require 'menu.php';?>
      </nav>
    </header>
    <div id="site_content">
      <div id="content">
<!--        <h1>Welcome to photo_style_two</h1>
        <p>This standards compliant, fixed width website template is released as an 'open source' design (under a <a href="http://creativecommons.org/licenses/by/3.0">Creative Commons Attribution 3.0 Licence</a>), which means that you are free to use it for anything you want (including modifying and amending it). All I ask is that you leave the 'design from css3templates.co.uk' link in the footer of the template. All of the photos were taken by me - use as you wish.</p>
        <h3>Browser Compatibility</h3>
        <p>This template has been tested in the following browsers:</p>
        <ul>
          <li>Internet Explorer 8</li>
          <li>Internet Explorer 7</li>
          <li>FireFox 10</li>
          <li>Google Chrome 17</li>-->
        </ul>
      </div>
    </div>
    <footer>
<!--      <p>Copyright &copy; photo_style_two | <a href="http://www.css3templates.co.uk">design from css3templates.co.uk</a></p>-->
    </footer>
  </div>
  <p>&nbsp;</p>
  <!-- javascript at the bottom for fast page loading -->
  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="js/jquery.easing-sooper.js"></script>
  <script type="text/javascript" src="js/jquery.sooperfish.js"></script>
  <script type="text/javascript" src="js/image_fade.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('ul.sf-menu').sooperfish();
    });
  </script>
</body>
</html>
