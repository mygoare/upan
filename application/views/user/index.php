<div class="sixteen columns entry not_center">
  <h4>个人中心 -- <small>我的地盘我做主</small></h4>
  <div class="eight columns alpha">
  <!--<p><a id="view-uploaded-file" href="javascript:void(0)">查看上传过的文件</a></p>-->
  <?php if (empty($file_uploaded)) { ?>
    <p>您还未上传任何文件</p>
  <?php } else { ?>
    <table style="width:100%;">
      <thead>
        <tr>
          <th>文件名</th>
          <th style="min-width:45px;">提取码</th>
          <th>上传时间</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($file_uploaded as $fileInfo) { ?>
        <tr>
        <td><a href="<?php echo base_url().'home/download_file?id='.$fileInfo['id'].'&file_name='.$fileInfo['file_name'] ?>"><?php echo $fileInfo['file_name'] ?></a></td>
        <td><?php echo $fileInfo['slug'] ?></td>
        <td><?php echo $fileInfo['upload_time'] ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  <?php } ?>
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
  <!--<hr />-->
</div>
