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

# delete lines contained # Added by ProxyEditor
# sed -i "/# Added by ProxyEditor/d" /boot/config/go
exec("sed -i \"/# Added by ProxyEditor/d\" /boot/config/go");

$emhttpdefault = "\/usr\/local\/sbin\/emhttp &";
if ($_POST['sys_active_config'] == "-1") {
    exec("sed -i \"/$emhttpdefault/c$emhttpdefault\" /boot/config/go");
 } else {
    # /boot/config/go: emhttp
    $sysid = $_POST['sys_active_config'];
    $url = $cfg["sys_config_"."$sysid"."_url"];
    $emhttpreplace = "http_proxy="."$url"." https_proxy="."$url "."$emhttpdefault";
    exec("sed -i \"/$emhttpdefault/c$emhttpreplace\" /boot/config/go");
    
    # /boot/config/go: set http(s)_proxy in /etc/profile
    $intext = "echo " . "\\\"" . "export http_proxy=" . "\\\\" . "\\\"" . "$url" . "\\\\" . "\\\"" . "\\\" >> /etc/profile";
    exec("echo \"" . "$intext" . " # Added by ProxyEditor\" >> /boot/config/go");
    $intext = "echo " . "\\\"" . "export https_proxy=" . "\\\\" . "\\\"" . "$url" . "\\\\" . "\\\"" . "\\\" >> /etc/profile";
    exec("echo \"" . "$intext" . " # Added by ProxyEditor\" >> /boot/config/go");

    # /boot/config/go: set wget wait time and proxy settings in /root/.wgetrc
    $intext = "echo " . "\\\"" . "wait=10" . "\\\" >> /root/.wgetrc";
    exec("echo \"" . "$intext" . " # Added by ProxyEditor\" >> /boot/config/go");
    $intext = "echo " . "\\\"" . "use_proxy=yes" . "\\\" >> /root/.wgetrc";
    exec("echo \"" . "$intext" . " # Added by ProxyEditor\" >> /boot/config/go");
    $intext = "echo " . "\\\"" . "http_proxy=" . "$url" . "\\\" >> /root/.wgetrc";
    exec("echo \"" . "$intext" . " # Added by ProxyEditor\" >> /boot/config/go");
    $intext = "echo " . "\\\"" . "https_proxy=" . "$url" . "\\\" >> /root/.wgetrc";
    exec("echo \"" . "$intext" . " # Added by ProxyEditor\" >> /boot/config/go");
}
?>
