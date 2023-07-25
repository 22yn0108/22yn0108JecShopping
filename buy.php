<?php
    require_once './helpers/MemberDAO.php';
    require_once './helpers/CartDAO.php';
    require_once './helpers/SaleDAO.php';

    session_start();

    if(empty($_SESSION['member'])){
        header('Location:login.php');
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        header('Location:cart.php');
        exit;
    }

    $member = $_SESSION['member'];

    $cartDAO = new CartDAO();
    $cart_list = $cartDAO->get_cart_by_memberid($member->memberid);

    $saleDAO = new SaleDAO();
    $saleDAO->insert($member->memberid,$cart_list);

    $cartDAO->delete_by_memberid($member->memberid);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>購入完了</title>
    </head>
    <body>
        <?php include "header.php"; ?>
        <p>購入が完了しました。</p>
        <a href="index.php">トップページへ</a>
    </body>
</html>
