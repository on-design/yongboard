<?php
include_once('./_common.php');


if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

if (!isset($config['cf_add_script'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_add_script` TEXT NOT NULL AFTER `cf_admin_email_name` ", true);
}

if (!isset($config['cf_mobile_new_skin'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_mobile_new_skin` VARCHAR(255) NOT NULL AFTER `cf_memo_send_point`,
                    ADD `cf_mobile_search_skin` VARCHAR(255) NOT NULL AFTER `cf_mobile_new_skin`,
                    ADD `cf_mobile_connect_skin` VARCHAR(255) NOT NULL AFTER `cf_mobile_search_skin`,
                    ADD `cf_mobile_member_skin` VARCHAR(255) NOT NULL AFTER `cf_mobile_connect_skin` ", true);
}

if (isset($config['cf_gcaptcha_mp3'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    CHANGE `cf_gcaptcha_mp3` `cf_captcha_mp3` VARCHAR(255) NOT NULL DEFAULT '' ", true);
} else if (!isset($config['cf_captcha_mp3'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_captcha_mp3` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_mobile_member_skin` ", true);
}

if(!isset($config['cf_editor'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_editor` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_captcha_mp3` ", true);
}

if(!isset($config['cf_googl_shorturl_apikey'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_googl_shorturl_apikey` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_captcha_mp3` ", true);
}

if(!isset($config['cf_mobile_pages'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_mobile_pages` INT(11) NOT NULL DEFAULT '0' AFTER `cf_write_pages` ", true);
    sql_query(" UPDATE `{$g5['config_table']}` SET cf_mobile_pages = '5' ", true);
}

if(!isset($config['cf_facebook_appid'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_facebook_appid` VARCHAR(255) NOT NULL AFTER `cf_googl_shorturl_apikey`,
                    ADD `cf_facebook_secret` VARCHAR(255) NOT NULL AFTER `cf_facebook_appid`,
                    ADD `cf_twitter_key` VARCHAR(255) NOT NULL AFTER `cf_facebook_secret`,
                    ADD `cf_twitter_secret` VARCHAR(255) NOT NULL AFTER `cf_twitter_key` ", true);
}

// uniqid 테이블이 없을 경우 생성
if(!sql_query(" DESC {$g5['uniqid_table']} ", false)) {
    sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['uniqid_table']}` (
                  `uq_id` bigint(20) unsigned NOT NULL,
                  `uq_ip` varchar(255) NOT NULL,
                  PRIMARY KEY (`uq_id`)
                ) ", false);
}

if(!sql_query(" SELECT uq_ip from {$g5['uniqid_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE {$g5['uniqid_table']} ADD `uq_ip` VARCHAR(255) NOT NULL ");
}

// 임시저장 테이블이 없을 경우 생성
if(!sql_query(" DESC {$g5['autosave_table']} ", false)) {
    sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['autosave_table']}` (
                  `as_id` int(11) NOT NULL AUTO_INCREMENT,
                  `mb_id` varchar(20) NOT NULL,
                  `as_uid` bigint(20) unsigned NOT NULL,
                  `as_subject` varchar(255) NOT NULL,
                  `as_content` text NOT NULL,
                  `as_datetime` datetime NOT NULL,
                  PRIMARY KEY (`as_id`),
                  UNIQUE KEY `as_uid` (`as_uid`),
                  KEY `mb_id` (`mb_id`)
                ) ", false);
}

if(!isset($config['cf_admin_email'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_admin_email` VARCHAR(255) NOT NULL AFTER `cf_admin` ", true);
}

if(!isset($config['cf_admin_email_name'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_admin_email_name` VARCHAR(255) NOT NULL AFTER `cf_admin_email` ", true);
}

if(!isset($config['cf_cert_use'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_cert_use` TINYINT(4) NOT NULL DEFAULT '0' AFTER `cf_editor`,
                    ADD `cf_cert_ipin` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_cert_use`,
                    ADD `cf_cert_hp` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_cert_ipin`,
                    ADD `cf_cert_kcb_cd` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_cert_hp`,
                    ADD `cf_cert_kcp_cd` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_cert_kcb_cd`,
                    ADD `cf_cert_limit` INT(11) NOT NULL DEFAULT '0' AFTER `cf_cert_kcp_cd` ", true);
    sql_query(" ALTER TABLE `{$g5['member_table']}`
                    CHANGE `mb_hp_certify` `mb_certify` VARCHAR(20) NOT NULL DEFAULT '' ", true);
    sql_query(" update {$g5['member_table']} set mb_certify = 'hp' where mb_certify = '1' ");
    sql_query(" update {$g5['member_table']} set mb_certify = '' where mb_certify = '0' ");
    sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['cert_history_table']}` (
                  `cr_id` int(11) NOT NULL auto_increment,
                  `mb_id` varchar(255) NOT NULL DEFAULT '',
                  `cr_company` varchar(255) NOT NULL DEFAULT '',
                  `cr_method` varchar(255) NOT NULL DEFAULT '',
                  `cr_ip` varchar(255) NOT NULL DEFAULT '',
                  `cr_date` date NOT NULL DEFAULT '0000-00-00',
                  `cr_time` time NOT NULL DEFAULT '00:00:00',
                  PRIMARY KEY (`cr_id`),
                  KEY `mb_id` (`mb_id`)
                )", true);
}

if(!isset($config['cf_analytics'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_analytics` TEXT NOT NULL AFTER `cf_intercept_ip` ", true);
}

if(!isset($config['cf_add_meta'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_add_meta` TEXT NOT NULL AFTER `cf_analytics` ", true);
}

if (!isset($config['cf_syndi_token'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_syndi_token` VARCHAR(255) NOT NULL AFTER `cf_add_meta` ", true);
}

if (!isset($config['cf_syndi_except'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_syndi_except` TEXT NOT NULL AFTER `cf_syndi_token` ", true);
}

if(!isset($config['cf_sms_use'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_sms_use` varchar(255) NOT NULL DEFAULT '' AFTER `cf_cert_limit`,
                    ADD `cf_icode_id` varchar(255) NOT NULL DEFAULT '' AFTER `cf_sms_use`,
                    ADD `cf_icode_pw` varchar(255) NOT NULL DEFAULT '' AFTER `cf_icode_id`,
                    ADD `cf_icode_server_ip` varchar(255) NOT NULL DEFAULT '' AFTER `cf_icode_pw`,
                    ADD `cf_icode_server_port` varchar(255) NOT NULL DEFAULT '' AFTER `cf_icode_server_ip` ", true);
}

if(!isset($config['cf_mobile_page_rows'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_mobile_page_rows` int(11) NOT NULL DEFAULT '0' AFTER `cf_page_rows` ", true);
}

if(!isset($config['cf_cert_req'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_cert_req` tinyint(4) NOT NULL DEFAULT '0' AFTER `cf_cert_limit` ", true);
}

if(!isset($config['cf_faq_skin'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_faq_skin` varchar(255) NOT NULL DEFAULT '' AFTER `cf_connect_skin`,
                    ADD `cf_mobile_faq_skin` varchar(255) NOT NULL DEFAULT '' AFTER `cf_mobile_connect_skin` ", true);
}

// LG유플러스 본인확인 필드 추가
if(!isset($config['cf_lg_mid'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_lg_mid` varchar(255) NOT NULL DEFAULT '' AFTER `cf_cert_kcp_cd`,
                    ADD `cf_lg_mert_key` varchar(255) NOT NULL DEFAULT '' AFTER `cf_lg_mid` ", true);
}

if(!isset($config['cf_optimize_date'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_optimize_date` date NOT NULL default '0000-00-00' AFTER `cf_popular_del` ", true);
}

// 카카오톡링크 api 키
if(!isset($config['cf_kakao_js_apikey'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_kakao_js_apikey` varchar(255) NOT NULL DEFAULT '' AFTER `cf_googl_shorturl_apikey` ", true);
}

// SMS 전송유형 필드 추가
if(!isset($config['cf_sms_type'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_sms_type` varchar(10) NOT NULL DEFAULT '' AFTER `cf_sms_use` ", true);
}

// 접속자 정보 필드 추가
if(!sql_query(" select vi_browser from {$g5['visit_table']} limit 1 ")) {
    sql_query(" ALTER TABLE `{$g5['visit_table']}`
                    ADD `vi_browser` varchar(255) NOT NULL DEFAULT '' AFTER `vi_agent`,
                    ADD `vi_os` varchar(255) NOT NULL DEFAULT '' AFTER `vi_browser`,
                    ADD `vi_device` varchar(255) NOT NULL DEFAULT '' AFTER `vi_os` ", true);
}

if(!$config['cf_faq_skin']) $config['cf_faq_skin'] = "basic";
if(!$config['cf_mobile_faq_skin']) $config['cf_mobile_faq_skin'] = "basic";

$g5['title'] = '환경설정';
include_once ('./admin.head.php');


$frm_submit = '<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn01 btn" accesskey="s">
    <a class="btn_default btn" href="'.G5_URL.'/">메인으로</a>
</div>';

if (!$config['cf_icode_server_ip'])   $config['cf_icode_server_ip'] = '211.172.232.124';
if (!$config['cf_icode_server_port']) $config['cf_icode_server_port'] = '7295';

if ($config['cf_sms_use'] && $config['cf_icode_id'] && $config['cf_icode_pw']) {
    $userinfo = get_icode_userinfo($config['cf_icode_id'], $config['cf_icode_pw']);
}
?>

<div id="admTitle">
    <h2>환경설정</h2>
</div>
<div class="anchor">
    <ul>
        <li><a href="#anc_cf_basic">기본정보</a></li>
        <li><a href="#anc_cf_join">회원가입</a></li>
        <li><a href="#anc_cf_cert">본인확인</a></li>
        <li><a href="#anc_cf_sns">SNS</a></li>
        <li><a href="#anc_cf_sms">SMS</a></li>
    </ul>
</div>
<div id="configform">
    <form name="fconfigform" id="fconfigform" method="post" onsubmit="return fconfigform_submit(this);">
    <input type="hidden" name="token" value="" id="token">

    
    <section id="anc_cf_basic">
        <div class="config_wrap">
            <div class="cf_default inp_list">
                <dl>
                    <dt>
                        홈페이지 제목                        
                    </dt>
                    <dd>
                        <input type="text" name="cf_title" value="<?php echo $config['cf_title'] ?>" id="cf_title" required class="required frm_input" size="40">
                    </dd>
                </dl>
                <dl>
                    <dt>상호(회사명)</dt>
                    <dd><input type="text" class="frm_input"></dd>
                </dl>
                <dl>
                    <dt>대표자</dt>
                    <dd><input type="text" class="frm_input"></dd>
                </dl>
                <dl>
                    <dt>연락처</dt>
                    <dd><input type="text" class="frm_input"></dd>
                </dl>
                <dl>
                    <dt>팩스번호</dt>
                    <dd><input type="text" class="frm_input"></dd>
                </dl>
                <dl>
                    <dt>사업장 주소</dt>
                    <dd><input type="text" class="frm_input"></dd>
                </dl>
                <dl></dl>

            </div>
        </div>
        <div class="tbl_wrap">
            <h3 class="adm_sub_tit">기본 정보</h3>
            <div class="adm_wrap">
                <table>
                <caption>기본환경 설정</caption>
                <tbody>
                <tr>
                    <th scope="row"><label for="cf_title">홈페이지 제목<strong class="sound_only">필수</strong></label></th>
                    <td><input type="text" name="cf_title" value="<?php echo $config['cf_title'] ?>" id="cf_title" required class="required frm_input" size="40"></td>
                    <th scope="row"><label for="cf_admin">최고관리자<strong class="sound_only">필수</strong></label></th>
                    <td><?php echo get_member_id_select('cf_admin', 10, $config['cf_admin'], 'required') ?></td>
                </tr>
                <tr>
                    <th scope="row"><label for="">상호(회사명)</label></th>
                    <td><input type="text" class="frm_input"></td>
                    <th scope="row"><label for="">사업자 번호</label></th>
                    <td><input type="text" class="frm_input"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="">대표자</label></th>
                    <td><input type="text" class="frm_input"></td>
                    <th scope="row"><label for="">연락처</label></th>
                    <td><input type="text" class="frm_input"></td>
                </tr>
                    <th scope="row"><label for="">팩스번호</label></th>
                    <td><input type="text" class="frm_input"></td>
                    <th scope="row"><label for="">사업장 주소</label></th>
                    <td><input type="text" class="frm_input"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="cf_admin_email">대표 이메일<strong class="sound_only">필수</strong></label></th>
                    <td colspan="3">
                        <!-- <?php echo help('관리자가 보내고 받는 용도로 사용하는 메일 주소를 입력합니다. (회원가입, 인증메일, 테스트, 회원메일발송 등에서 사용)') ?> -->
                        <input type="text" name="cf_admin_email" value="<?php echo $config['cf_admin_email'] ?>" id="cf_admin_email" required class="required email frm_input" size="40">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="cf_possible_ip">접근가능 IP</label></th>
                    <td>
                        <?php echo help('입력된 IP의 컴퓨터만 접근할 수 있습니다.<br>123.123.+ 도 입력 가능. (엔터로 구분)') ?>
                        <textarea name="cf_possible_ip" id="cf_possible_ip"><?php echo $config['cf_possible_ip'] ?></textarea>
                    </td>
                    <th scope="row"><label for="cf_intercept_ip">접근차단 IP</label></th>
                    <td>
                        <?php echo help('입력된 IP의 컴퓨터는 접근할 수 없음.<br>123.123.+ 도 입력 가능. (엔터로 구분)') ?>
                        <textarea name="cf_intercept_ip" id="cf_intercept_ip"><?php echo $config['cf_intercept_ip'] ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="cf_analytics">방문자분석 스크립트</label></th>
                    <td colspan="3">
                        <?php echo help('방문자분석 스크립트 코드를 입력합니다. 예) 구글 애널리틱스'); ?>
                        <textarea name="cf_analytics" id="cf_analytics"><?php echo $config['cf_analytics']; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="cf_add_meta">추가 메타태그</label></th>
                    <td colspan="3">
                        <?php echo help('추가로 사용하실 meta 태그를 입력합니다.'); ?>
                        <textarea name="cf_add_meta" id="cf_add_meta"><?php echo $config['cf_add_meta']; ?></textarea>
                    </td>
                </tr>
                </tbody>
                </table>
            </div>
        </div>
    </section>
    
    <?php echo preg_replace('#</div>$#i', '<button type="button" class="get_theme_confc" data-type="conf_skin">테마 스킨설정 가져오기</button></div>', $frm_submit); ?>
    
    
    <section id="anc_cf_join">
        <h2 class="h2_frm">회원가입 설정</h2>
        
        <div class="local_desc02 local_desc">
            <p>회원가입 시 사용할 스킨과 입력 받을 정보 등을 설정할 수 있습니다.</p>
        </div>
    
        <div class="tbl_frm01 tbl_wrap">
            <table>
            <caption>회원가입 설정</caption>
            <colgroup>
                <col class="grid_4">
                <col>
                <col class="grid_4">
                <col>
            </colgroup>
            <tbody>
            <tr>
                <th scope="row"><label for="cf_stipulation">회원가입약관</label></th>
                <td colspan="3"><textarea name="cf_stipulation" id="cf_stipulation" rows="10"><?php echo $config['cf_stipulation'] ?></textarea></td>
            </tr>
            <tr>
                <th scope="row"><label for="cf_privacy">개인정보처리방침</label></th>
                <td colspan="3"><textarea id="cf_privacy" name="cf_privacy" rows="10"><?php echo $config['cf_privacy'] ?></textarea></td>
            </tr>
            </tbody>
            </table>
        </div>
    </section>
    
    <?php echo preg_replace('#</div>$#i', '<button type="button" class="get_theme_confc" data-type="conf_member">테마 회원스킨설정 가져오기</button></div>', $frm_submit); ?>
    
    <section id="anc_cf_cert">
        <h2 class="h2_frm">본인확인 설정</h2>
        
        <div class="local_desc02 local_desc">
            <p>
                회원가입 시 본인확인 수단을 설정합니다.<br>
                실명과 휴대폰 번호 그리고 본인확인 당시에 성인인지의 여부를 저장합니다.<br>
                게시판의 경우 본인확인 또는 성인여부를 따져 게시물 조회 및 쓰기 권한을 줄 수 있습니다.
            </p>
        </div>
    
        <div class="tbl_frm01 tbl_wrap">
            <table>
            <caption>본인확인 설정</caption>
            <colgroup>
                <col class="grid_4">
                <col>
            </colgroup>
            <tbody>
            <tr>
                <th scope="row"><label for="cf_cert_use">본인확인</label></th>
                <td>
                    <select name="cf_cert_use" id="cf_cert_use">
                        <?php echo option_selected("0", $config['cf_cert_use'], "사용안함"); ?>
                        <?php echo option_selected("1", $config['cf_cert_use'], "테스트"); ?>
                        <?php echo option_selected("2", $config['cf_cert_use'], "실서비스"); ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row" class="cf_cert_service"><label for="cf_cert_ipin">아이핀 본인확인</label></th>
                <td class="cf_cert_service">
                    <select name="cf_cert_ipin" id="cf_cert_ipin">
                        <?php echo option_selected("",    $config['cf_cert_ipin'], "사용안함"); ?>
                        <?php echo option_selected("kcb", $config['cf_cert_ipin'], "코리아크레딧뷰로(KCB) 아이핀"); ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row" class="cf_cert_service"><label for="cf_cert_hp">휴대폰 본인확인</label></th>
                <td class="cf_cert_service">
                    <select name="cf_cert_hp" id="cf_cert_hp">
                        <?php echo option_selected("",    $config['cf_cert_hp'], "사용안함"); ?>
                        <?php echo option_selected("kcb", $config['cf_cert_hp'], "코리아크레딧뷰로(KCB) 휴대폰 본인확인"); ?>
                        <?php echo option_selected("kcp", $config['cf_cert_hp'], "NHN KCP 휴대폰 본인확인"); ?>
                        <?php echo option_selected("lg",  $config['cf_cert_hp'], "LG유플러스 휴대폰 본인확인"); ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row" class="cf_cert_service"><label for="cf_cert_kcb_cd">코리아크레딧뷰로<br>KCB 회원사ID</label></th>
                <td class="cf_cert_service">
                    <?php echo help('KCB 회원사ID를 입력해 주십시오.<br>서비스에 가입되어 있지 않다면, KCB와 계약체결 후 회원사ID를 발급 받으실 수 있습니다.<br>이용하시려는 서비스에 대한 계약을 아이핀, 휴대폰 본인확인 각각 체결해주셔야 합니다.<br>아이핀 본인확인 테스트의 경우에는 KCB 회원사ID가 필요 없으나,<br>휴대폰 본인확인 테스트의 경우 KCB 에서 따로 발급 받으셔야 합니다.') ?>
                    <input type="text" name="cf_cert_kcb_cd" value="<?php echo $config['cf_cert_kcb_cd'] ?>" id="cf_cert_kcb_cd" class="frm_input" size="20"> <a href="http://sir.kr/main/service/b_ipin.php" target="_blank" class="btn_frmline">KCB 아이핀 서비스 신청페이지</a>
                    <a href="http://sir.kr/main/service/b_cert.php" target="_blank" class="btn_frmline">KCB 휴대폰 본인확인 서비스 신청페이지</a>
                </td>
            </tr>
            <tr>
                <th scope="row" class="cf_cert_service"><label for="cf_cert_kcp_cd">NHN KCP 사이트코드</label></th>
                <td class="cf_cert_service">
                    <?php echo help('SM으로 시작하는 5자리 사이트 코드중 뒤의 3자리만 입력해 주십시오.<br>서비스에 가입되어 있지 않다면, 본인확인 서비스 신청페이지에서 서비스 신청 후 사이트코드를 발급 받으실 수 있습니다.') ?>
                    <span class="sitecode">SM</span>
                    <input type="text" name="cf_cert_kcp_cd" value="<?php echo $config['cf_cert_kcp_cd'] ?>" id="cf_cert_kcp_cd" class="frm_input" size="3"> <a href="http://sir.kr/main/service/p_cert.php" target="_blank" class="btn_frmline">NHN KCP 휴대폰 본인확인 서비스 신청페이지</a>
                </td>
            </tr>
            <tr>
                <th scope="row" class="cf_cert_service"><label for="cf_lg_mid">LG유플러스 상점아이디</label></th>
                <td class="cf_cert_service">
                    <?php echo help('LG유플러스 상점아이디 중 si_를 제외한 나머지 아이디만 입력해 주십시오.<br>서비스에 가입되어 있지 않다면, 본인확인 서비스 신청페이지에서 서비스 신청 후 상점아이디를 발급 받으실 수 있습니다.<br><strong>LG유플러스 휴대폰본인확인은 ActiveX 설치가 필요하므로 Internet Explorer 에서만 사용할 수 있습니다.</strong>') ?>
                    <span class="sitecode">si_</span>
                    <input type="text" name="cf_lg_mid" value="<?php echo $config['cf_lg_mid'] ?>" id="cf_lg_mid" class="frm_input" size="20"> <a href="http://sir.kr/main/service/lg_cert.php" target="_blank" class="btn_frmline">LG유플러스 본인확인 서비스 신청페이지</a>
                </td>
            </tr>
            <tr>
                <th scope="row" class="cf_cert_service"><label for="cf_lg_mert_key">LG유플러스 MERT KEY</label></th>
                <td class="cf_cert_service">
                    <?php echo help('LG유플러스 상점MertKey는 상점관리자 -> 계약정보 -> 상점정보관리에서 확인하실 수 있습니다.') ?>
                    <input type="text" name="cf_lg_mert_key" value="<?php echo $config['cf_lg_mert_key'] ?>" id="cf_lg_mert_key" class="frm_input" size="40">
                </td>
            </tr>
            <tr>
                <th scope="row" class="cf_cert_service"><label for="cf_cert_limit">본인확인 이용제한</label></th>
                <td class="cf_cert_service">
                    <?php echo help('하루동안 아이핀과 휴대폰 본인확인 인증 이용회수를 제한할 수 있습니다.<br>회수제한은 실서비스에서 아이핀과 휴대폰 본인확인 인증에 개별 적용됩니다.<br>0 으로 설정하시면 회수제한이 적용되지 않습니다.'); ?>
                    <input type="text" name="cf_cert_limit" value="<?php echo $config['cf_cert_limit']; ?>" id="cf_cert_limit" class="frm_input" size="3"> 회
                </td>
            </tr>
            <tr>
                <th scope="row" class="cf_cert_service"><label for="cf_cert_req">본인확인 필수</label></th>
                <td class="cf_cert_service">
                    <?php echo help('회원가입 때 본인확인을 필수로 할지 설정합니다. 필수로 설정하시면 본인확인을 하지 않은 경우 회원가입이 안됩니다.'); ?>
                    <input type="checkbox" name="cf_cert_req" value="1" id="cf_cert_req"<?php echo get_checked($config['cf_cert_req'], 1); ?>> 예
                </td>
            </tr>
            </tbody>
            </table>
        </div>
    </section>
    
    
    <?php echo $frm_submit; ?>
    
    <section id="anc_cf_sns">
        <h2 class="h2_frm">소셜네트워크서비스(SNS : Social Network Service)</h2>
        
    
        <div class="tbl_frm01 tbl_wrap">
            <table>
            <caption>소셜네트워크서비스 설정</caption>
            <colgroup>
                <col class="grid_4">
                <col>
                <col class="grid_4">
                <col>
            </colgroup>
            <tbody>
            <tr>
                <th scope="row"><label for="cf_facebook_appid">페이스북 앱 ID</label></th>
                <td>
                    <input type="text" name="cf_facebook_appid" value="<?php echo $config['cf_facebook_appid'] ?>" id="cf_facebook_appid" class="frm_input"> <a href="https://developers.facebook.com/apps" target="_blank" class="btn_frmline">앱 등록하기</a>
                </td>
                <th scope="row"><label for="cf_facebook_secret">페이스북 앱 Secret</label></th>
                <td>
                    <input type="text" name="cf_facebook_secret" value="<?php echo $config['cf_facebook_secret'] ?>" id="cf_facebook_secret" class="frm_input" size="35">
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="cf_twitter_key">트위터 컨슈머 Key</label></th>
                <td>
                    <input type="text" name="cf_twitter_key" value="<?php echo $config['cf_twitter_key'] ?>" id="cf_twitter_key" class="frm_input"> <a href="https://dev.twitter.com/apps" target="_blank" class="btn_frmline">앱 등록하기</a>
                </td>
                <th scope="row"><label for="cf_twitter_secret">트위터 컨슈머 Secret</label></th>
                <td>
                    <input type="text" name="cf_twitter_secret" value="<?php echo $config['cf_twitter_secret'] ?>" id="cf_twitter_secret" class="frm_input" size="35">
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="cf_googl_shorturl_apikey">구글 짧은주소 API Key</label></th>
                <td>
                    <input type="text" name="cf_googl_shorturl_apikey" value="<?php echo $config['cf_googl_shorturl_apikey'] ?>" id="cf_googl_shorturl_apikey" class="frm_input"> <a href="http://code.google.com/apis/console/" target="_blank" class="btn_frmline">API Key 등록하기</a>
                </td>
                <th scope="row"><label for="cf_kakao_js_apikey">카카오 Javascript API Key</label></th>
                <td>
                    <input type="text" name="cf_kakao_js_apikey" value="<?php echo $config['cf_kakao_js_apikey'] ?>" id="cf_kakao_js_apikey" class="frm_input"> <a href="http://developers.kakao.com/" target="_blank" class="btn_frmline">앱 등록하기</a>
                </td>
            </tr>
            </tbody>
            </table>
        </div>
    </section>
    
    <?php echo $frm_submit; ?>
    
    
    <section id="anc_cf_sms">
        <h2 class="h2_frm">SMS</h2>
        
    
        <div class="tbl_frm01 tbl_wrap">
            <table>
            <caption>SMS 설정</caption>
            <colgroup>
                <col class="grid_4">
                <col>
            </colgroup>
            <tbody>
            <tr>
                <th scope="row"><label for="cf_sms_use">SMS 사용</label></th>
                <td>
                    <select id="cf_sms_use" name="cf_sms_use">
                        <option value="" <?php echo get_selected($config['cf_sms_use'], ''); ?>>사용안함</option>
                        <option value="icode" <?php echo get_selected($config['cf_sms_use'], 'icode'); ?>>아이코드</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="cf_sms_type">SMS 전송유형</label></th>
                <td>
                    <?php echo help("전송유형을 SMS로 선택하시면 최대 80바이트까지 전송하실 수 있으며<br>LMS로 선택하시면 90바이트 이하는 SMS로, 그 이상은 1500바이트까지 LMS로 전송됩니다.<br>요금은 건당 SMS는 16원, LMS는 48원입니다."); ?>
                    <select id="cf_sms_type" name="cf_sms_type">
                        <option value="" <?php echo get_selected($config['cf_sms_type'], ''); ?>>SMS</option>
                        <option value="LMS" <?php echo get_selected($config['cf_sms_type'], 'LMS'); ?>>LMS</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="cf_icode_id">아이코드 회원아이디</label></th>
                <td>
                    <?php echo help("아이코드에서 사용하시는 회원아이디를 입력합니다."); ?>
                    <input type="text" name="cf_icode_id" value="<?php echo $config['cf_icode_id']; ?>" id="cf_icode_id" class="frm_input" size="20">
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="cf_icode_pw">아이코드 비밀번호</label></th>
                <td>
                    <?php echo help("아이코드에서 사용하시는 비밀번호를 입력합니다."); ?>
                    <input type="password" name="cf_icode_pw" value="<?php echo $config['cf_icode_pw']; ?>" id="cf_icode_pw" class="frm_input">
                </td>
            </tr>
            <tr>
                <th scope="row">요금제</th>
                <td>
                    <input type="hidden" name="cf_icode_server_ip" value="<?php echo $config['cf_icode_server_ip']; ?>">
                    <?php
                        if ($userinfo['payment'] == 'A') {
                           echo '충전제';
                            echo '<input type="hidden" name="cf_icode_server_port" value="7295">';
                        } else if ($userinfo['payment'] == 'C') {
                            echo '정액제';
                            echo '<input type="hidden" name="cf_icode_server_port" value="7296">';
                        } else {
                            echo '가입해주세요.';
                            echo '<input type="hidden" name="cf_icode_server_port" value="7295">';
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <th scope="row">아이코드 SMS 신청<br>회원가입</th>
                <td>
                    <a href="http://icodekorea.com/res/join_company_fix_a.php?sellid=sir2" target="_blank" class="btn_frmline">아이코드 회원가입</a>
                </td>
            </tr>
             <?php if ($userinfo['payment'] == 'A') { ?>
            <tr>
                <th scope="row">충전 잔액</th>
                <td colspan="3">
                    <?php echo number_format($userinfo['coin']); ?> 원.
                    <a href="http://www.icodekorea.com/smsbiz/credit_card_amt.php?icode_id=<?php echo $config['cf_icode_id']; ?>&amp;icode_passwd=<?php echo $config['cf_icode_pw']; ?>" target="_blank" class="btn_frmline" onclick="window.open(this.href,'icode_payment', 'scrollbars=1,resizable=1'); return false;">충전하기</a>
                </td>
            </tr>
            <?php } ?>
            </tbody>
            </table>
        </div>
    </section>
    
    <?php echo $frm_submit; ?>
    
    
    </form>
</div>
<script>
$(function(){
    <?php
    if(!$config['cf_cert_use'])
        echo '$(".cf_cert_service").addClass("cf_cert_hide");';
    ?>
    $("#cf_cert_use").change(function(){
        switch($(this).val()) {
            case "0":
                $(".cf_cert_service").addClass("cf_cert_hide");
                break;
            default:
                $(".cf_cert_service").removeClass("cf_cert_hide");
                break;
        }
    });

    $(".get_theme_confc").on("click", function() {
        var type = $(this).data("type");
        var msg = "기본환경 스킨 설정";
        if(type == "conf_member")
            msg = "기본환경 회원스킨 설정";

        if(!confirm("현재 테마의 "+msg+"을 적용하시겠습니까?"))
            return false;

        $.ajax({
            type: "POST",
            url: "./theme_config_load.php",
            cache: false,
            async: false,
            data: { type: type },
            dataType: "json",
            success: function(data) {
                if(data.error) {
                    alert(data.error);
                    return false;
                }

                var field = Array('cf_member_skin', 'cf_mobile_member_skin', 'cf_new_skin', 'cf_mobile_new_skin', 'cf_search_skin', 'cf_mobile_search_skin', 'cf_connect_skin', 'cf_mobile_connect_skin', 'cf_faq_skin', 'cf_mobile_faq_skin');
                var count = field.length;
                var key;

                for(i=0; i<count; i++) {
                    key = field[i];

                    if(data[key] != undefined && data[key] != "")
                        $("select[name="+key+"]").val(data[key]);
                }
            }
        });
    });
});

function fconfigform_submit(f)
{
    f.action = "./config_form_update.php";
    return true;
}
</script>

<?php
// 본인확인 모듈 실행권한 체크
if($config['cf_cert_use']) {
    // kcb일 때
    if($config['cf_cert_ipin'] == 'kcb' || $config['cf_cert_hp'] == 'kcb') {
        // 실행모듈
        if(strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
            if(PHP_INT_MAX == 2147483647) // 32-bit
                $exe = G5_OKNAME_PATH.'/bin/okname';
            else
                $exe = G5_OKNAME_PATH.'/bin/okname_x64';
        } else {
            if(PHP_INT_MAX == 2147483647) // 32-bit
                $exe = G5_OKNAME_PATH.'/bin/okname.exe';
            else
                $exe = G5_OKNAME_PATH.'/bin/oknamex64.exe';
        }

        echo module_exec_check($exe, 'okname');
    }

    // kcp일 때
    if($config['cf_cert_hp'] == 'kcp') {
        if(PHP_INT_MAX == 2147483647) // 32-bit
            $exe = G5_KCPCERT_PATH . '/bin/ct_cli';
        else
            $exe = G5_KCPCERT_PATH . '/bin/ct_cli_x64';

        echo module_exec_check($exe, 'ct_cli');
    }

    // LG의 경우 log 디렉토리 체크
    if($config['cf_cert_hp'] == 'lg') {
        $log_path = G5_LGXPAY_PATH.'/lgdacom/log';

        if(!is_dir($log_path)) {
            echo '<script>'.PHP_EOL;
            echo 'alert("'.str_replace(G5_PATH.'/', '', G5_LGXPAY_PATH).'/lgdacom 폴더 안에 log 폴더를 생성하신 후 쓰기권한을 부여해 주십시오.\n> mkdir log\n> chmod 707 log");'.PHP_EOL;
            echo '</script>'.PHP_EOL;
        } else {
            if(!is_writable($log_path)) {
                echo '<script>'.PHP_EOL;
                echo 'alert("'.str_replace(G5_PATH.'/', '',$log_path).' 폴더에 쓰기권한을 부여해 주십시오.\n> chmod 707 log");'.PHP_EOL;
                echo '</script>'.PHP_EOL;
            }
        }
    }
}

include_once(G5_PATH.'/tail.php');
?>