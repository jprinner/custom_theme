<?php $height = ($h = get_field('height')) ? $h : '625'; ?>

<div class="speed-test-block">
  <div class="row">
    <div class="col col-12">
      <div class="iframe-wrapper">
        <iframe loading="lazy" width="100%" height="<?php echo $height; ?>" frameborder="0" style="border-radius: 20px;" src="https://tms-tool.speedtestcustom.com"></iframe>
      </div>
    </div>
  </div>
</div>