<?php

$link_array = array('page'    => 'device',
                    'device'  => $device['device_id'],
                    'tab'     => 'loadbalancer');

## Cisco ACE
$type_text['loadbalancer_rservers'] = "Rservers";
$type_text['loadbalancer_vservers'] = "Serverfarms";

## Citrix Netscaler
$type_text['netscaler_vsvr'] = "VServers";

print_optionbar_start();

$pagetitle[] = "Load Balancer";

echo("<span style='font-weight: bold;'>Load Balancer</span> &#187; ");

unset($sep);
foreach ($loadbalancer_tabs as $type)
{

  if (!$vars['proto']) { $vars['proto'] = $type; }

  echo($sep);

  if ($vars['proto'] == $type)
  {
    echo('<span class="pagemenu-selected">');
  }

  echo(generate_link($type_text[$type] ." (".$device_loadbalancer_count[$type].")",$link_array,array('proto'=>$type)));
  if ($vars['proto'] == $type) { echo("</span>"); }
  $sep = " | ";
}

print_optionbar_end();

if (is_file("pages/device/loadbalancer/".mres($vars['proto']).".inc.php"))
{
   include("pages/device/loadbalancer/".mres($vars['proto']).".inc.php");
} else {
  foreach ($loadbalancer_tabs as $type)
  {
    if ($type != "overview")
    {
      if (is_file("pages/device/loadbalancer/overview/".mres($type).".inc.php")) {

        $g_i++;
        if (!is_integer($g_i/2)) { $row_colour = $list_colour_a; } else { $row_colour = $list_colour_b; }

        echo('<div style="background-color: '.$row_colour.';">');
        echo('<div style="padding:4px 0px 0px 8px;"><span class=graphhead>'.$type_text[$type].'</span>');
        include("pages/device/loadbalancer/overview/".mres($type).".inc.php");
        echo('</div>');
        echo('</div>');
      } else {
        $graph_title = $type_text[$type];
        $graph_type = "device_".$type;
        include("includes/print-device-graph.php");
      }
    }
  }
}

?>
