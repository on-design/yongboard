<?php
$sub_menu = '300600';
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "w");

// 상단, 하단 파일경로 필드 추가
if(!sql_query(" select co_include_head from {$g5['content_table']} limit 1 ", false)) {
    $sql = " ALTER TABLE `{$g5['content_table']}`  ADD `co_include_head` VARCHAR( 255 ) NOT NULL ,
                                                    ADD `co_include_tail` VARCHAR( 255 ) NOT NULL ";
    sql_query($sql, false);
}

// html purifier 사용여부 필드
if(!sql_query(" select co_tag_filter_use from {$g5['content_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['content_table']}`
                    ADD `co_tag_filter_use` tinyint(4) NOT NULL DEFAULT '0' AFTER `co_content` ", true);
    sql_query(" update {$g5['content_table']} set co_tag_filter_use = '1' ");
}

// 모바일 내용 추가
if(!sql_query(" select co_mobile_content from {$g5['content_table']} limit 1", false)) {
    sql_query(" ALTER TABLE `{$g5['content_table']}`
                    ADD `co_mobile_content` longtext NOT NULL AFTER `co_content` ", true);
}

// 스킨 설정 추가
if(!sql_query(" select co_skin from {$g5['content_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['content_table']}`
                    ADD `co_skin` varchar(255) NOT NULL DEFAULT '' AFTER `co_mobile_content`,
                    ADD `co_mobile_skin` varchar(255) NOT NULL DEFAULT '' AFTER `co_skin` ", true);
    sql_query(" update {$g5['content_table']} set co_skin = 'basic', co_mobile_skin = 'basic' ");
}

$html_title = "내용";
$g5['title'] = $html_title.' 관리';

if ($w == "u")
{
    $html_title .= " 수정";
    $readonly = " readonly";

    $sql = " select * from {$g5['content_table']} where co_id = '$co_id' ";
    $co = sql_fetch($sql);
    if (!$co['co_id'])
        alert('등록된 자료가 없습니다.');
}
else
{
    $html_title .= ' 입력';
    $co['co_html'] = 2;
    $co['co_skin'] = 'basic';
    $co['co_mobile_skin'] = 'basic';
}

include_once ('./admin.head.php');
?>


<div id="admTitle">
    <h2>내용관리 - <?php echo htmlspecialchars2($co['co_subject']); ?></h2>
</div>
<form name="frmcontentform" action="./contentformupdate.php" onsubmit="return frmcontentform_check(this);" method="post" enctype="MULTIPART/FORM-DATA" >
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="co_html" value="1">
<input type="hidden" name="token" value="">

<div class="tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <colgroup>
        <col class="grid_4">
        <col>
    </colgroup>
    <tbody>
    <tr>
        <th scope="row"><label for="co_id">ID</label></th>
        <td>
            <?php echo help('20자 이내의 영문자, 숫자, _ 만 가능합니다.'); ?>
            <input type="text" value="<?php echo $co['co_id']; ?>" name="co_id" id ="co_id" required <?php echo $readonly; ?> class="required <?php echo $readonly; ?> frm_input" size="20" maxlength="20">
            <?php if ($w == 'u') { ?><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=<?php echo $co_id; ?>" class="btn_frmline">내용확인</a><?php } ?>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="co_subject">제목</label></th>
        <td><input type="text" name="co_subject" value="<?php echo htmlspecialchars2($co['co_subject']); ?>" id="co_subject" required class="frm_input required" size="90"></td>
    </tr>
    <tr>
        <th scope="row">내용</th>
        <td><?php echo editor_html('co_content', get_text($co['co_content'], 0)); ?></td>
    </tr>
    <tr>
        <th scope="row">모바일 내용</th>
        <td><?php echo editor_html('co_mobile_content', get_text($co['co_mobile_content'], 0)); ?></td>
    </tr>
    </tbody>
    </table>
</div>

<div class="btn_confirm">
    <input type="submit" value="확인" class="btn_submit btn01" accesskey="s">
    <a href="./contentlist.php" class="btn_cancel btn01">목록</a>
</div>

</form>

<script>
function frmcontentform_check(f)
{
    errmsg = "";
    errfld = "";

    <?php echo get_editor_js('co_content'); ?>
    <?php echo chk_editor_js('co_content'); ?>
    <?php echo get_editor_js('co_mobile_content'); ?>

    check_field(f.co_id, "ID를 입력하세요.");
    check_field(f.co_subject, "제목을 입력하세요.");
    check_field(f.co_content, "내용을 입력하세요.");

    if (errmsg != "") {
        alert(errmsg);
        errfld.focus();
        return false;
    }
    return true;
}
</script>

<?php
include_once ('./tail.php');
?>
