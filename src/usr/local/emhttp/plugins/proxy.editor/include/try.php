<?PHP
/* Copyright 2022, Lu Chang
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License version 2,
 * as published by the Free Software Foundation.
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 */
?>
<?
$cfg = parse_ini_file('/boot/config/plugins/proxy.editor/proxy.editor.cfg');
$save = true;
if ($_POST['ca_active_config'] == "-1") {
   exec("rm -f /boot/config/plugins/community.applications/proxy.cfg");
} else {
    $caid = $_POST['ca_active_config'];
    $port = $cfg["ca_config_"."$caid"."_port"];
    $addr = $cfg["ca_config_"."$caid"."_addr"];
    exec("echo -e \"tunnel=1\nport=$port\nproxy=$addr\" > /boot/config/plugins/community.applications/proxy.cfg");
}

$defaulttext = "\/usr\/local\/sbin\/emhttp &";
if ($_POST['emhttp_active_config'] == "-1") {
    exec("sed -i \"/$defaulttext/c$defaulttext\" /boot/config/go");
 } else {
     $emhttpid = $_POST['emhttp_active_config'];
     $url = $cfg["emhttp_config_"."$emhttpid"."_url"];
     $replacement = "http_proxy="."$url"." https_proxy="."$url "."$defaulttext";
     exec("sed -i \"/$defaulttext/c$replacement\" /boot/config/go");
 }
?>
