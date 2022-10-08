<?= $this->Html->css('account_reg_complete'); ?>
<div class="complete">
    <h2>アカウント登録完了</h2>
    <p>
        アカウントの登録が完了しました。<br/>自動的にプロフィール登録ページに移動します。
    </p>
</div>

<script>
    function autoLink() {
        location.href = "<?php echo $this->Url->build(["controller" => "profilereg", "action" => "index"])?>"; // プロフィール登録画面へのリンクへ移動 仮でtopと入れている。
    }

    setTimeout("autoLink()", 5000); // 5秒後にプロフィール登録画面へ自動的に移動

</script>
