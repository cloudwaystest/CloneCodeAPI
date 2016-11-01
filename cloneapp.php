<?php
    include 'CloudwaysAPI.class.php';
    $api_key = '5Ydxxxxxxxxxxxxxxxxxxxxxxxxxxx';
    $email = 'me@example.com';
    $cw_api = new CloudwaysAPI($email,$api_key);
    $servers = $cw_api->get_servers();
    $apps = [];
    $success = null;
    $options = null;

if(isset($_POST['submit'])){

        $server = $_POST['git_server'];
        $appname = $_POST['git_app'];
        $giturl = $_POST['git_url'];
        $re = $cw_api->GetBranches($server,$appname,$giturl);

        foreach($re->branches as $branch){
        $options.="<option value='".$branch."'>".$branch."</option>";
        }
if($re ->operation_id){
echo "clone successful";
}
}

if(isset($_POST['clone_project'])){

        $server = $_POST['server'];
        $appname = $_POST['app'];
        $giturl = $_POST['github_url'];
        $git_branch = $_POST['git_branch'];
        $deploy_path = $_POST['deploy_path'];
        $re = $cw_api->GetClone($server,$appname,$giturl,$git_branch,$deploy_path);

        if($re->operation_id){

          $message = "Git deployment has been successful at <b>public_html/$deploy_path</b>.";
        }

}






    // if(!empty($_POST)){
    //     $server = $_POST['server'];
    //     $appname = $_POST['app'];
    //     $re = $cw_api->GenerateKey($server,$appname);

    //     if(isset($re->key)){
    //         $success = $re->key;
    //     } else {
    //         $success = $re->message;
    //     }

    // }
?>





<html>

<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Application</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<!--<script type="text/javascript">
           $(document).ready(function(){
        $("#myModal").modal('show');
    });
        </script>-->


</head>
<body>


<div class="container-fluid">

    <div class="row">

      <div class="col-md-10">


        <form class="form-horizontal" method="post" action="">

          <fieldset>

            <!-- Form Name -->

            <legend align="center">Clone Application via Git</legend>

            <!-- Select Basic -->

            <div class="form-group">
<div class="form-group">
              <label class="col-md-4 control-label" for=""></label>
              <div class="col-md-4 center-block">
 <button  class="btn center-block btn-danger" data-toggle="modal" href="#myModal" >Fetch Branches</button>
</div>
</div>
              <label class="col-md-4 control-label" for="server">Server</label>
              <div class="col-md-4">
                <select id="server" name="server" class="form-control" required>
                  <option value="">Select Your Server</option>
                  <?php foreach($servers->servers as $server) { echo "
                  <option value='".$server->id."'>".$server->label."</option>"; } ?>
                </select>
              </div>
            </div>

          <div class="form-group">
              <label class="col-md-4 control-label" for="application">Application</label>
              <div class="col-md-4">
                <select id="app" name="app" class="form-control disable" required>
                </select>
              </div>
            </div>



            <!-- Select Basic -->

            <div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Enter Git SSH URL</label>
  <div class="col-md-4">
  <input id="github_url" name="github_url" type="text" placeholder="Enter Git SSH URL" class="form-control input-md" required>
  </div>
</div>

 <div class="form-group">
    <label class="col-md-4 control-label" for="application">Git Branches</label>
    <div class="col-md-4">
    <select id="git_branch" name="git_branch" class="form-control disable" required>
    <?php echo $options; ?>
   </select>
   </div>
   </div>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Deployment path: public_html/</label>
  <div class="col-md-4">
  <input id="deploy_path" name="deploy_path" type="text" placeholder="Leave blank if path is public_html" class="form-control input-md">
  </div>
</div>

            <!-- Button -->

            <div class="form-group">
              <label class="col-md-4 control-label" for=""></label>
              <div class="col-md-4">
                <button id="clone_project" name="clone_project" class="btn center-block btn-primary">Clone Project</button>

              </div>
		</div>
	    <div class="text-center"> <?php if($re != null) echo "$message" ?>
	   </div>
            <div class="form-group">
            <label class="col-md-4 control-label" for=""></label>
              <div class="col-md-4">
                <?php echo $success  ?>
             </div>
            </div>
          </fieldset>
        </form>
      </div>
    </div>
  </div>






























<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Enter Git SSH URL</h4>
      </div>
      <div class="modal-body">
       <form class="form-horizontal" method="post">
<fieldset>

<!-- Form Name -->

<!-- Text input-->
 <div class="form-group">
   <label class="col-md-4 control-label" for="server">Server</label>
       <div class="col-md-4">
            <select id="git_server" name="git_server" class="form-control" required>
                 <option value="">Select Your Server</option>
                 <?php foreach($servers->servers as $server) { echo "
                   <option value='".$server->id."'>".$server->label."</option>"; } ?>
            </select>
      </div>
</div>

 <div class="form-group">
    <label class="col-md-4 control-label" for="application">Application</label>
    <div class="col-md-4">
    <select id="git_app" name="git_app" class="form-control disable" required>
   </select>
   </div>
   </div>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Git SSH URL</label>
  <div class="col-md-4">
  <input id="git_url" name="git_url" type="text" placeholder="Enter Git SSH URL" class="form-control input-md" required>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton">Get Git</label>
  <div class="col-md-4">
    <button id="submit" name="submit" class="btn btn-primary">Fetch Branches</button>
  </div>
</div>

</fieldset>
</form>
      </div>
    </div>
  </div>
</div>







<script type="text/javascript">
  $("#git_server").change(function () {
    val = $(this).val();
    switch (val) {
      <?php foreach($servers -> servers as $server) { ?>
        case <?php echo "\"".$server -> id.
        "\""; ?> :
          $('#git_app')
          .find('option')
          .remove()
          .end();
          <?php
          $i = "<option value=''>Select Your Application</option>";
          foreach($server -> apps as $app) {
              $i .= "<option value='".$app -> id.
              "'>".$app -> label.
              " (".$app -> application.
              ")</option>";
              $i++;
            } ?>
            apps = "<?php echo $i;?>";
          $('#git_app').html(apps);
          break;
          <?php
        } ?>
        default:
        $('#git_app')
      .find('option')
      .remove()
      .end();
      break;
    }
  });
  </script>

  <script type="text/javascript">
  $("#server").change(function () {
    val = $(this).val();
    switch (val) {
      <?php foreach($servers -> servers as $server) { ?>
        case <?php echo "\"".$server -> id.
        "\""; ?> :
          $('#app')
          .find('option')
          .remove()
          .end();
          <?php
          $i = "<option value=''>Select Your Application</option>";
          foreach($server -> apps as $app) {
              $i .= "<option value='".$app -> id.
              "'>".$app -> label.
              " (".$app -> application.
              ")</option>";
              $i++;
            } ?>
            apps = "<?php echo $i;?>";
          $('#app').html(apps);
          break;
          <?php
        } ?>
        default:
        $('#app')
      .find('option')
      .remove()
      .end();
      break;
    }
  });
  </script>
</body>
</html>
