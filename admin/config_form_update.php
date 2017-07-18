<?php
$sub_menu = "100100";
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], 'w');

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

$cf_admin = 'admin';
$mb = get_member($cf_admin);
if (!$mb['mb_id'])
    alert('최고관리자 회원아이디가 존재하지 않습니다.');

check_admin_token();

// 본인확인을 사용할 경우 아이핀, 휴대폰인증 중 하나는 선택되어야 함
if($_POST['cf_cert_use'] && !$_POST['cf_cert_ipin'] && !$_POST['cf_cert_hp'])
    alert('본인확인을 위해 아이핀 또는 휴대폰 본인학인 서비스를 하나이상 선택해 주십시오');

if(!$_POST['cf_cert_use']) {
    $_POST['cf_cert_ipin'] = '';
    $_POST['cf_cert_hp'] = '';
}


$sql = " update {$g5['config_table']}
            set cf_title = '{$_POST['cf_title']}',
                cf_admin = '{$cf_admin}',
                cf_admin_email = '{$_POST['cf_admin_email']}',
                cf_possible_ip = '".trim($_POST['cf_possible_ip'])."',
                cf_intercept_ip = '".trim($_POST['cf_intercept_ip'])."',
                cf_analytics = '{$_POST['cf_analytics']}',
                cf_add_meta = '{$_POST['cf_add_meta']}',
                cf_stipulation = '{$_POST['cf_stipulation']}',
                cf_privacy = '{$_POST['cf_privacy']}',
                cf_cert_use = '{$_POST['cf_cert_use']}',
                cf_cert_ipin = '{$_POST['cf_cert_ipin']}',
                cf_cert_hp = '{$_POST['cf_cert_hp']}',
                cf_cert_kcb_cd = '{$_POST['cf_cert_kcb_cd']}',
                cf_cert_kcp_cd = '{$_POST['cf_cert_kcp_cd']}',
                cf_lg_mid = '{$_POST['cf_lg_mid']}',
                cf_lg_mert_key = '{$_POST['cf_lg_mert_key']}',
                cf_cert_limit = '{$_POST['cf_cert_limit']}',
                cf_cert_req = '{$_POST['cf_cert_req']}',
                cf_sms_use = '{$_POST['cf_sms_use']}',
                cf_sms_type = '{$_POST['cf_sms_type']}',
                cf_icode_id = '{$_POST['cf_icode_id']}',
                cf_icode_pw = '{$_POST['cf_icode_pw']}',
                cf_icode_server_ip = '{$_POST['cf_icode_server_ip']}',
                cf_icode_server_port = '{$_POST['cf_icode_server_port']}',
                cf_googl_shorturl_apikey = '{$_POST['cf_googl_shorturl_apikey']}',
                cf_kakao_js_apikey = '{$_POST['cf_kakao_js_apikey']}',
                cf_facebook_appid = '{$_POST['cf_facebook_appid']}',
                cf_facebook_secret = '{$_POST['cf_facebook_secret']}',
                cf_twitter_key = '{$_POST['cf_twitter_key']}',
                cf_twitter_secret = '{$_POST['cf_twitter_secret']}' ";
sql_query($sql);

//sql_query(" OPTIMIZE TABLE `$g5[config_table]` ");

goto_url('./config_form.php', false);
?>