<?php include 'header.php'; ?>

      <div id="page-wrapper">

        <div class="row">
          <div class="col-lg-12">
            <h1>Page</h1>
            <ol class="breadcrumb">
              <li><a href="index.html"><i class="fa fa-dashboard"></i> Dashboard</a></li>
              <li class="active"><i class="fa fa-font"></i> Page</li>
            </ol>

            <div class="alert alert-info alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              Visit <a class="alert-link" target="_blank" href="http://getbootstrap.com/<?=base_url();?>asset/css/#type">Bootstrap's Typography Documentation</a> for more information.
            </div>

            <form class="form-horizontal" role="form">
              <div class="form-group">
                <div class="col-lg-12">
                  <input type="email" class="form-control" id="inputEmail3" placeholder="Title">
                </div>
              </div>
              <div class="form-group">
                <div class="col-lg-12">
                  <textarea cols="80" id="editor1" name="editor1" rows="50">
                  </textarea>
                </div>
              </div>
            </form>

          </div>
         
        </div><!-- /.row -->

      </div><!-- /#page-wrapper -->

    <script type="text/javascript">
      var cktext='editor1';
    </script>    
    <?php include 'footer.php'; ?>
    <?php include 'ckeditor.php'; ?>