<?= $this->Html->css('password_forget_confirm'); ?>
<div class="bg"></div>
<div class="wrapper">
    <h2>新規パスワード設定</h2>
    <?= $this->Form->create(null, ["type" => "post", "enctype" => "multipart/form-data", "name" => "form1", "id" => "profile-form", "url" => ["action" => "confirm2"]]) ?>
    <div class="inputs">
        <input type="password" name="pass">
        <input type="hidden" value="<?= $id->email ?>" name="mail">
    </div>
    <div class="btn_area">
        <button class="login_btn" type="submit">パスワードを変更する</button>
    </div>
    </form>
    <p id="check" class="err_msg"></p>
</div>
</div>

<script>
</script>
