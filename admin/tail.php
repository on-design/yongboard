<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(defined('G5_THEME_PATH')) {
    require_once(G5_THEME_PATH.'/tail.php');
    return;
}

if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH.'/tail.php');
    return;
}
?>

    </div>
</div>

<!-- } 콘텐츠 끝 -->


<!-- 하단 시작 { -->
<!-- <div id="footer">
    <div id="ft_catch"><img src="<?php echo G5_IMG_URL; ?>/ft.png" alt="<?php echo G5_VERSION ?>"></div>
    <div id="ft_company">
    </div>
    <div id="ft_copy">
        <div>
            <a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=company">회사소개</a>
            <a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=privacy">개인정보처리방침</a>
            <a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=provision">서비스이용약관</a>
            Copyright &copy; <b>소유하신 도메인.</b> All rights reserved.<br>
            <a href="#hd" id="ft_totop">상단으로</a>
        </div>
    </div>
</div> -->

<?php
if(G5_DEVICE_BUTTON_DISPLAY && !G5_IS_MOBILE) { ?>
<!-- <a href="<?php echo get_device_change_url(); ?>" id="device_change">모바일 버전으로 보기</a> -->
<?php
}

if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>

<!-- } 하단 끝 -->

<script>
$(function() {
    // 폰트 리사이즈 쿠키있으면 실행
    font_resize("container", get_cookie("ck_font_resize_rmv_class"), get_cookie("ck_font_resize_add_class"));
});
</script>

<?php
include_once(G5_PATH."/tail.sub.php");
?>