<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if(G5_IS_MOBILE) {
	include_once(G5_THEME_MSHOP_PATH.'/shop.head.php');
	return;
}

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
$languageCode = $_COOKIE['language'];
include_once(G5_PATH.'/language/'.$languageCode.'.php');
if(empty($languageCode)) {
	$languageCode = 'kor';
	include_once(G5_PATH.'/language/'.$languageCode.'.php');
}
$langCodeType = array('kor', 'eng', 'fra', 'chi-zh'); // 각 언어의 언어코드
$langNameType = array('langKor', 'langEng', 'langFra', 'langChi'); // 각 언어별 라벨명
?>
<section class="top-bar-wrap">
	<div class="container">
		<div class="top-bar">
			<div class="dropdown language">
				<button class="btn btn-cafemart dropdown-toggle current-lang <?php echo($langStr['langCode']); ?>" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<?php echo $langStr['langName']; ?>
				</button>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					<?php
						for($i = 0; $i < count($langCodeType); $i++) {
							if($langCodeType[$i] != $langStr['langCode']) {
					?>
					<a class="dropdown-item <?php echo($langCodeType[$i]); ?>" href="#" data-lang="<?php echo($langCodeType[$i]); ?>"><?php echo($langStr[$langNameType[$i]]); ?></a>
					<?php
							}
						}
					?>
				</div>
			</div>
			<div class="dropdown">
				<button class="btn btn-cafemart dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					My account
				</button>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					<?php if ($is_member) { ?>
					<?php if ($is_admin) {  ?>
					<a class="dropdown-item" href="<?php echo G5_ADMIN_URL; ?>/shop_admin/"><b><?php echo($langStr['admin']); ?></b></a>
					<?php } ?>
					<a class="dropdown-item" href="<?php echo G5_BBS_URL; ?>/logout.php?url=shop"><?php echo($langStr['logout']); ?></a>
					<a class="dropdown-item" href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=register_form.php"><?php echo($langStr['memberConfig']); ?></a>
					<?php } else { ?>
					<a class="dropdown-item" href="<?php echo G5_BBS_URL; ?>/login.php?url=<?php echo $urlencode; ?>"><b><?php echo($langStr['login']); ?></b></a>
					<a class="dropdown-item" href="<?php echo G5_BBS_URL; ?>/register.php"><?php echo($langStr['join']); ?></a>
					<?php } ?>
					<a class="dropdown-item" href="<?php echo G5_SHOP_URL; ?>/mypage.php"><?php echo($langStr['myPage']); ?></a>
					<a class="dropdown-item" href="<?php echo G5_SHOP_URL; ?>/cart.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <?php echo($langStr['basket']); ?></a>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
$mb_id = $_SESSION['ss_mb_id'];
$sql = "SELECT (ct_price * ct_qty) AS calc FROM {$g5['g5_shop_cart_table']} WHERE ct_status = '쇼핑' AND mb_id = '$mb_id'";
$res = sql_query($sql);
$cnt = 0;
$calc = 0;
while ($row = sql_fetch_array($res)) {
	$calc = $calc + $row['calc'];
	$cnt++;
}
$tmp_doller = 1124.2;
$tmp_dollar_price = $calc / $tmp_doller; // 추후 실시간 환율 적용 에정
$dollar_price = sprintf('%0.2f', $tmp_dollar_price);
/*
$tmp = 45000;
$tmp2 = 1124.2;
$tmp3 = $tmp / $tmp2;
?>
<h1><?php echo($tmp3); ?></h1>
<h1><?php echo sprintf('%0.2f', $tmp3); ?></h1>
*/
//print_r($default);
?>
<section class="logo-search">
	<div class="container">
		<div class="row">
			<div class="col-3">
				<form name="frmsearch1" id="frmsearch1" action="<?php echo G5_SHOP_URL; ?>/search.php" onsubmit="return search_submit(this);" class="form-inline">
					<label for="sch_str" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
					<div class="input-group">
						<input type="text" name="q" class="form-control" value="<?php echo stripslashes(get_text(get_search_string($q))); ?>" id="sch_str" required />
					</div>
					<button type="submit" id="sch_submit" class="btn btn-cafemart-dark ml-2"><i class="fa fa-search" aria-hidden="true"></i><span class="sound_only">검색</span></button>

				</form>

				<script>
				function search_submit(f) {
					if (f.q.value.length < 2) {
						alert("검색어는 두글자 이상 입력하십시오.");
						f.q.select();
						f.q.focus();
						return false;
					}
					return true;
				}
				</script>
			</div>
			<div class="col-6 text-center">
				<a href="<?php echo(G5_URL); ?>"><img src="<?php echo G5_IMG_URL ?>/logo/cafe-teacher-main-logo.png" alt="main logo" /></a>
			</div>
			<div class="col-3 text-right">
				<a href="<?php echo(G5_SHOP_URL); ?>/cart.php" class="cart">
					<i class="fa fa-shopping-cart"></i> 
					<span class="small">Item <?php echo($cnt); ?></span> - 
					<span class="price"><?php echo $languageCode == 'kor' ? '&#8361;' : '&dollar;'; ?><?php echo $languageCode == 'kor' ? $calc : $dollar_price; ?></span>
				</a>
			</div>
		</div>
	</div>
</section>
<!-- 상단 시작 { -->
<div id="hd">
	<h1 id="hd_h1"><?php echo $g5['title'] ?></h1>

	<div id="skip_to_container"><a href="#container">본문 바로가기</a></div>

	<?php if(defined('_INDEX_')) { // index에서만 실행
		include G5_BBS_PATH.'/newwin.inc.php'; // 팝업레이어
	 } ?>


	<!-- 쇼핑몰 배너 시작 { -->
	<?php // echo display_banner('왼쪽'); ?>
	<!-- } 쇼핑몰 배너 끝 -->
	<div id="hd_menu">
		<ul>
			<li><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=1">히트상품</a></li>
			<li><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=2">추천상품</a></li>
			<li><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=3">최신상품</a></li>
			<li><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=4">인기상품</a></li>
			<li><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=5">할인상품</a></li>
			<li class="hd_menu_right"><a href="<?php echo G5_BBS_URL; ?>/faq.php">FAQ</a></li>
			<li class="hd_menu_right"><a href="<?php echo G5_BBS_URL; ?>/qalist.php">1:1문의</a></li>
			<li class="hd_menu_right"><a href="<?php echo G5_SHOP_URL; ?>/personalpay.php">개인결제</a></li>
			<li class="hd_menu_right"><a href="<?php echo G5_SHOP_URL; ?>/itemuselist.php">사용후기</a></li>
			<li class="hd_menu_right"><a href="<?php echo G5_SHOP_URL; ?>/couponzone.php">쿠폰존</a></li>

		</ul>
	</div>
</div>
<!-- BIGIN :: Index slide images -->
<style>
.main-slide-wrap {
	position: relative;
    width: 100%; /* 너비 : 100%; */
    background-color: rgba(255,255,255,1);
}
.main-slide-wrap:before {
	content: "";
    display: block;
    padding-top: 20%; /* 5:1 비율 */
}
.main-slide-wrap .main-slide {
	position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
}
.swiper-container { height: 100%; }
.swiper-scrollbar { display: none; }
.main-slide-wrap .swiper-pagination-bullet { width: 20px; height: 5px; border-radius: 0; }
.main-slide-wrap .swiper-pagination-bullet-active { background-color: rgba(128,128,255,.8); }
</style>
<?php if(defined('_INDEX_') && !G5_IS_MOBILE) { ?>
<link rel="stylesheet" href="<?php echo G5_CSS_URL.'/swiper.min.css' ?>">
<script src="<?php echo G5_JS_URL.'/swiper.min.js' ?>"></script>
<div class="main-slide-wrap">
	<div class="main-slide">
		<!-- BIGIN :: Slide -->
		<!-- Slider main container -->
		<div class="swiper-container">
		    <!-- Additional required wrapper -->
		    <div class="swiper-wrapper">
		        <!-- Slides -->
		        <div class="swiper-slide">Slide 1</div>
		        <div class="swiper-slide">Slide 2</div>
		        <div class="swiper-slide">Slide 3</div>
		    </div>
		    <!-- If we need pagination -->
		    <div class="swiper-pagination"></div>

		    <!-- If we need navigation buttons -->
		    <div class="swiper-button-prev"></div>
		    <div class="swiper-button-next"></div>

		    <!-- If we need scrollbar -->
		    <div class="swiper-scrollbar"></div>
		</div>
		<!-- END :: Slide -->
	</div>
</div>
<script>
var swiper = new Swiper('.swiper-container', {
    spaceBetween: 30,
    centeredSlides: true,
    autoplay: {
        delay: 2500,
        disableOnInteraction: false,
    },
    loop: true,
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
});
</script>
<?php } ?>
<!-- END :: Index slide images -->
<div id="side_menu">
	<button type="button" id="btn_sidemenu" class="btn_sidemenu_cl"><i class="fa fa-outdent" aria-hidden="true"></i><span class="sound_only">사이드메뉴버튼</span></button>
	<div class="side_menu_wr">
		<?php echo outlogin('theme/shop_basic'); // 아웃로그인 ?>
		<div class="side_menu_shop">
			<button type="button" class="btn_side_shop">오늘본상품<span class="count"><?php echo get_view_today_items_count(); ?></span></button>
			<?php include(G5_SHOP_SKIN_PATH.'/boxtodayview.skin.php'); // 오늘 본 상품 ?>
			<button type="button" class="btn_side_shop">장바구니<span class="count"><?php echo get_boxcart_datas_count(); ?></span></button>
			<?php include_once(G5_SHOP_SKIN_PATH.'/boxcart.skin.php'); // 장바구니 ?>
			<button type="button" class="btn_side_shop">위시리스트<span class="count"><?php echo get_wishlist_datas_count(); ?></span></button>
			<?php include_once(G5_SHOP_SKIN_PATH.'/boxwish.skin.php'); // 위시리스트 ?>
		</div>
		<?php include_once(G5_SHOP_SKIN_PATH.'/boxcommunity.skin.php'); // 커뮤니티 ?>

	</div>
</div>


<script>
$(function (){

	$(".btn_sidemenu_cl").on("click", function() {
		$(".side_menu_wr").toggle();
		$(".fa-outdent").toggleClass("fa-indent")
	});

	$(".btn_side_shop").on("click", function() {
		$(this).next(".op_area").slideToggle(300).siblings(".op_area").slideUp();
	});
});
</script>


<div id="wrapper">

	<div id="aside">

		<?php include_once(G5_SHOP_SKIN_PATH.'/boxcategory.skin.php'); // 상품분류 ?>
		<?php include_once(G5_THEME_SHOP_PATH.'/category.php'); // 분류 ?>
		<?php if($default['de_type4_list_use']) { ?>
		<!-- 인기상품 시작 { -->
		<section class="sale_prd">
			<h2><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=4">인기상품</a></h2>
			<?php
			$list = new item_list();
			$list->set_type(4);
			$list->set_view('it_id', false);
			$list->set_view('it_name', true);
			$list->set_view('it_basic', false);
			$list->set_view('it_cust_price', false);
			$list->set_view('it_price', true);
			$list->set_view('it_icon', false);
			$list->set_view('sns', false);
			echo $list->run();
			?>
		</section>
		<!-- } 인기상품 끝 -->
		<?php } ?>

		<!-- 커뮤니티 최신글 시작 { -->
		<section id="sidx_lat">
			<h2>커뮤니티 최신글</h2>
			<?php echo latest('theme/shop_basic', 'notice', 5, 30); ?>
		</section>
		<!-- } 커뮤니티 최신글 끝 -->

		<?php echo poll('theme/shop_basic'); // 설문조사 ?>

		<?php echo visit('theme/shop_basic'); // 접속자 ?>
	</div>
<!-- } 상단 끝 -->

	<!-- 콘텐츠 시작 { -->
	<div id="container">
		<?php if ((!$bo_table || $w == 's' ) && !defined('_INDEX_')) { ?><div id="wrapper_title"><?php echo $g5['title'] ?></div><?php } ?>
		<!-- 글자크기 조정 display:none 되어 있음 시작 { -->
		<div id="text_size">
			<button class="no_text_resize" onclick="font_resize('container', 'decrease');">작게</button>
			<button class="no_text_resize" onclick="font_default('container');">기본</button>
			<button class="no_text_resize" onclick="font_resize('container', 'increase');">크게</button>
		</div>
		<!-- } 글자크기 조정 display:none 되어 있음 끝 -->