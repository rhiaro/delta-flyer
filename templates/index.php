<!doctype html>
<html>
  <head>
    <title>Delta Flyer</title>
    <link rel="stylesheet" type="text/css" href="../../views/normalize.min.css" />
    <link rel="stylesheet" type="text/css" href="../../views/core.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
   integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
   crossorigin=""/>
    <style type="text/css">
      main {
        width: 50%; margin-left: auto; margin-right: auto;
      }
      pre {
        max-height: 300px;
        overflow: scroll;
      }
      nav a {
        text-decoration: none;
        color: #2d2d2d;
        font-weight: bold;
      }
      nav, nav ul {
        width: 100%;
        padding: 0; margin: 0;
        display: flex;
      }
      nav ul li {
        float: left;
        margin: 0.4em;
        flex-grow: 1;
        background-color: #b7d2ad;
      }
      nav ul li:hover {
        background-color: #ddffd0;
      }
      nav ul li a {
        display: inline-block;
        padding: 1em 0 1em 0;
        width: 100%; height: 100%;
      }
      form {
      }
      form p {
        display: flex;
        width: 100%;
      }
      form label {
        width: 20%;
        display: inline-block;
      }
      form input[type="text"], textarea {
        flex-grow: 1;
      }
      form input[type="submit"] {
        flex-grow: 1;
        padding: 0.4em;
      }
      form span label {
        width: auto;
      }
      #reload {
        display: inline-block;
        width: 1em; height: 1em;
        border-radius: 100%;
        background-color: violet;
      }
      #reload:hover {
        cursor: pointer;
      }
      #startMap, #endMap {
        height: 300px; width: 100%;
      }
    </style>
  </head>
  <body>
    <main>
      <h1>Delta Flyer</h1>

      <? include("form_menu.php"); ?>
      
      <?if(isset($errors)):?>
        <div class="fail">
          <?foreach($errors as $key=>$error):?>
            <p><strong><?=$key?>: </strong><?=$error?></p>
          <?endforeach?>
        </div>
      <?endif?>
      
      <?if(isset($result)):?>
        <div>
          <p>The response from your endpoint:</p>
          <code><?=$endpoint?></code>
          <?if($result->status_code != "201"):?>
            <p class="fail">Nothing created, error code <strong><?=$result->status_code?></strong></p>
          <?else:?>
            <p class="win">Post created.. <strong><?=$result->headers['location']?></strong></p>
          <?endif?>
          <pre>
            <? var_dump($result); ?>
          </pre>
        </div>
      <?endif?>
      
      <form method="post" role="form" id="astrogator" class="align-center">
        
        <?if(isset($_GET["mode"]) && $_GET["mode"] == "route"):?>
          <? include("form_route.php"); ?>
        <?else:?>
          <? include("form_checkin.php"); ?>
        <?endif?>
        
        <hr/>
        <!-- temp -->
        <select name="endpoint_uri">
          <option value="https://rhiaro.co.uk/outgoing/">rhiaro.co.uk</option>
          <option value="http://localhost/outgoing/">localhost</option>
        </select>
        <input type="password" name="endpoint_key" />
        <!--/ temp -->
        <hr/>
      </form>
      
      <div class="color3-bg inner">
        <?if(isset($_SESSION['me'])):?>
          <p class="wee">You are logged in as <strong><?=$_SESSION['me']?></strong> <a href="?logout=1">Logout</a></p>
        <?else:?>
          <form action="https://indieauth.com/auth" method="get" class="inner clearfix">
            <label for="indie_auth_url">Domain:</label>
            <input id="indie_auth_url" type="text" name="me" placeholder="yourdomain.com" />
            <input type="submit" value="signin" />
            <input type="hidden" name="client_id" value="https://rhiaro.co.uk" />
            <input type="hidden" name="redirect_uri" value="<?=$base?>" />
            <input type="hidden" name="state" value="<?=$base?>" />
            <input type="hidden" name="scope" value="post" />
          </form>
        <?endif?>
        
      </div>
    </main>
    <footer class="w1of2 center">
      <p><a href="https://github.com/rhiaro/burrow">Code</a> | <a href="https://github.com/rhiaro/burrow/issues">Issues</a>
      <?if(isset($_SESSION['access_token'])):?>
        | <a href="https://apps.rhiaro.co.uk/burrow?token=<?=$_SESSION['access_token']?>">Quicklink</a>
      <?endif?>
      </p>
    </footer>
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
    <script src="https://stamen-maps.a.ssl.fastly.net/js/tile.stamen.js"></script>
    <script>
      var coordsform = `<? include("form_coords.php")?>`;
    </script>
    <script src="js/delta-flyer.js"></script>
    <script src="js/reload-button.js"></script>
  </body>
</html>