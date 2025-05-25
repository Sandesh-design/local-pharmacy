<?php
session_start();

if (isset($_POST['product_id'])) {
  $id = intval($_POST['product_id']);
  unset($_SESSION['cart'][$id]);
}

header("Location: cart.php");
exit();
