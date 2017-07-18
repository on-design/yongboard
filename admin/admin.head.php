<?php
if (!defined('_GNUBOARD_')) exit;
$begin_time = get_microtime();
include_once(G5_ADM_PATH.'/head.sub.php');
?>

<div id="header">
    <div id="gnb">
        <div class="brand_logo navi_on">
            <h1>YONG BOARD</h1>
        </div>
        <div class="nav_wrapper">
            <button onclick="aside(); return false;"><i class="xi-align-left"></i></button>
            <ul>
                <li><a href="<?php echo G5_ADMIN_URL ?>/member_form.php?w=u&amp;mb_id=<?php echo $member['mb_id'] ?>">관리자정보</a></li>
                <li><a href="<?php echo G5_ADMIN_URL ?>/config_form.php">기본환경</a></li>
                <li><a href="<?php echo G5_ADMIN_URL ?>/service.php">부가서비스</a></li>
                <li><a href="<?php echo G5_URL ?>/">홈페이지</a></li>
                <li id="tnb_logout"><a href="<?php echo G5_BBS_URL ?>/logout.php">로그아웃</a></li>
            </ul>
        </div>
    </div>
    <div id="aside" class="navi_on">
        <ul>
            <li><a href="<?php echo G5_ADM_URL?>"><i class="xi-home"></i><span>관리자 홈</span></a></li>
            <li><a href="<?php echo G5_ADM_URL?>/config_form.php"><i class="xi-cog"></i><span>환경설정</span></a></li>
            <li><a href="<?php echo G5_ADM_URL?>/member_list.php"><i class="xi-user"></i><span>회원관리</span></a></li>
            <li><a href=""><i class="xi-image-o"></i><span>디자인관리</span></a></li>
            <li><a href="<?php echo G5_ADM_URL?>/board_list.php"><i class="xi-list"></i><span>게시판관리</span></a></li>
            <li><a href="<?php echo G5_ADM_URL?>/sms_admin/config.php"><i class="xi-message-o"></i><span>SMS 관리</span></a></li>
            <li><a href=""><i class="xi-chart-bar"></i><span>통계</span></a></li>
        </ul>
    </div>
</div>
<div id="wrapper">
    <div class="adm_container">