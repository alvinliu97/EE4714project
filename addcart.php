<?php
//开启session
session_start();

//判断是否登录
if (empty($_COOKIE['uid'])) {
	echo "<script>alert('please Login First!');location.href='index.php';</script>";
	exit();
}
if ($_GET['act'] == 'clear') {
	$_SESSION['cart'] = [];
	echo "<script>alert('clear cart success!');location.href='" . $_SERVER["HTTP_REFERER"] . "';</script>";
}
//获取id
$id = $_GET['id'];
//获取数量
$count = $_GET['num'] ? $_GET['num'] : 1;

$shopping = empty($_SESSION['cart']) ? array() : $_SESSION['cart'];


if (!$id) {
	echo '产品为空，请重新选择！';
	die;
}
$poduct['id'] 	 = $_GET['id'];
$poduct['num'] 	 = $count;
$poduct['size']  = $_GET['size'];


if (!$shopping) {
	$shopping[0] = $poduct;
} else {
	$i = 0;

	foreach ($shopping as $key => $vo) {
		$isSet = false;
		if ($vo['id'] == $_GET['id']) {
			$shopping[$i]['num'] = $shopping[$i]['num'] + $_GET['num'];
			$shopping[$i]['size'] = $_GET['size'];
			$isSet = true;
			break;
		}
		$i++;
	}

	if (!$isSet) {
		$shopping[] = $poduct;
	}
}

$_SESSION['cart'] = $shopping;

echo "<script>alert('add cart success!');location.href='" . $_SERVER["HTTP_REFERER"] . "';</script>";
exit();
