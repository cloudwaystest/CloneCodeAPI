<?php
    include 'CloudwaysAPI.class.php';
    $api_key = '5Yxxxxxxxxxxxxxxxxxxxxxxx';
    $email = 'me@example.com';
    $cw_api = new CloudwaysAPI($email,$api_key);
    $servers = $cw_api->get_servers();
    $apps = [];
    $success = null;

    if(!empty($_POST)){
        $server = $_POST['server'];
        $appname = $_POST['app'];
        $re = $cw_api->GenerateKey($server,$appname);

        if(isset($re->key)){
            $success = $re->key;
	    $redirectlink = "<b>Upload SSH keys on your Git repository. Then go to <a href='cloneapp.php'>Clone App</a> to fetch branches and start deployment.<b>";
        } else {
            $success = $re->message;
        }

    }

?>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Application</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-10">
        <form class="form-horizontal" method="post" action="">
          <fieldset>
            <legend align="center">SSH Keys for Deployment via Get </legend>
            <div class="form-group">
              <label class="col-md-4 control-label" for="server">Server</label>
              <div class="col-md-4">
                <select id="server" name="server" class="form-control">
                  <option value="">Select Your Server</option>
                  <?php foreach($servers->servers as $server) { echo "
                  <option value='".$server->id."'>".$server->label."</option>"; } ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label" for="application">Application</label>
              <div class="col-md-4">
               <select id="app" name="app" class="form-control disable">
                </select>
              </div>
            </div>


            <div class="form-group">
              <label class="col-md-4 control-label" for=""></label>
              <div class="col-md-4">
                <button id="" name="" class="btn center-block btn-danger">Get SSH Keys</button>
              </div>
            </div>

            <!-- Textarea -->
            <div class="form-group">
              <label class="col-md-4 control-label" for="textarea">Text Area</label>
              <div class="col-md-4">
                 <textarea class="form-control" id="textarea" name="textarea" rows="15" cols="50"><?php echo $success; ?></textarea>
              </div>
           </div>
<div class="text-center"> <?php if($success != null){ echo $redirectlink; }?></div>
</div>
          </fieldset>
        </form>
      </div>
    </div>
  </div>


  <script type="text/javascript">
    $("#server").change(function() {
        val = $(this).val();
        switch (val) {
            <?php foreach($servers -> servers as $server) { ?>
            case <?php echo "\"".$server -> id.
        "\""; ?>:
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
