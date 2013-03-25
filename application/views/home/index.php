      <div class="eight columns entry_hover entry">
        <h4>选择你的文件 & 上传到云</h4>
        <form id="upload_file_form" enctype="multipart/form-data" method="post">
          <a class="button"><span>选择文件</span><input name="file" type="file" id="upload_file" title="文件大小小于5M" /></a>
          <span class="error file_upload_error"></span>
        </form>
      </div>
      <div class="eight columns entry_hover entry">
        <h4>输入提取码 & 下载文件</h4>
        <form id="input_code_form">
          <input id="input_code" name="input_code" placeholder="输入提取码" type="text" />
          <span class="code_notice_box"></span>
          <input style="display:none;" type="submit" />
        </form>
      </div>
      <div class="sixteen columns entry" id="file_code">
        <h4>请记住提取码：</h4>
        <h3 id="slug"></h3>
      </div>
      <div class="sixteen columns entry" id="get_file">
        <h4>马上开始下载...</h4>
        <h6>还有 <span>5</span> 秒 <small>如果没有自动开始下载，请点击 <a id="file_url" href="">这里</a></small></h6>
      </div>
      <div class="sixteen columns" id="bottom">
        <p>mygoare &copy; 2013 · <a href="<?php echo base_url(); ?>about" >关于</a> · <a href="" >反馈</a></p>
      </div>
