<?php
include("basicCaman.php");
if(isset($_GET['s']))
{
  start_session();
  if(!isset($_SESSION['reactions']))
  {
    $_SESSION['reactions'] = $_GET['s'];
  }
  else
  {
    $reactions;
    $rf = false; // reactions found?
    $list = ce_get_database_list("david_database", "david_caman", "kuR[GuBHE801", "photos");
    foreach($list as $image)
    {
      if($_GET['s'] == $image['filename'])
      {
        $reactions = $image['filename'];
        $rf = true;
        break;
      }
    }
    if($rf)
    {
      $rctns = explode("|", $reactions);
      $isfound = false;
      foreach($rctns as $rctn)
      {
        if($rctn == $_GET['s'])
        {
          $isfound = true;
          break;
        }
      }
      if(!$isfound && isset($_GET['n']))
      {
        $rct_num = intval($_GET['n']);
        while(count($rctns) <= $rct_num)
        {
          $rctns[] = 0;
        }
        $rctns[$rct_num] = intval($rct_num) + 1;
        $reactions = implode("|", $rctns);
        
        ce_update_reactions("david_database", "david_caman", "kuR[GuBHE801", "photos", $_GET['s'], $reactions);

        $_SESSION .= "|" . $_GET['s'];
      }
    }
  }
}

?>
