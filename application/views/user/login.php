<div class="sixteen columns entry not_center">
  <h4>用户 -- <small>创建用户</small></h4>
  <div class="eight columns alpha">
  <form id="user-login" method="post" action="<?php echo base_url() ?>user/login_in">
      <label for="username">用户名</label><input name="username" type="text" placeholder="用户名" />
      <span class="notice-box user-notice-box"></span>
      <label for="pwd">密码</label><input name="pwd" type="password" placeholder="密码" />
      <span class="notice-box pwd-notice-box"></span>
      <!--<label for="email">邮箱</label><input type="text" placeholder="邮箱" />-->
      <!--<label for="mobile">手机</label><input type="text" placeholder="手机" />-->
      <label for="re_code">
        <input type="checkbox" name="re_code" id="re_code" />
        <span>记住登录 <span class="error">(请勿在公共电脑上勾选此项)</span></span>
      </label>
      <input type="submit" value="创建用户" />
    </form>
  </div>
  <div class="eight columns omega">
    <ol>
      <li>
        <p>可以享有单次最高 10M 的上传限额</p>
      </li>
      <li>
        <p>永久记住您上传的所有文件</p>
      </li>
      <li>
        <p>专享8位提取码</p>
      </li>
    </ol>
    </ol>
  </div>
</div>