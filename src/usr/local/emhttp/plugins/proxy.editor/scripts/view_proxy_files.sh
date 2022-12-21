#!/bin/bash
if [ -f "/boot/config/plugins/community.applications/proxy.cfg" ]; then
    echo "===cat /boot/config/plugins/community.applications/proxy.cfg==="
    # if the file is DOS format (CRLF), the unraid web will fail to show the text.
    echo -e "`sed 's/\r$//' /boot/config/plugins/community.applications/proxy.cfg`"
    echo "==============================END=============================="
else 
    echo "CA proxy.cfg 文件(/boot/config/plugins/community.applications/proxy.cfg)不存在, CA当前没有使用代理"
fi

echo "======================cat /boot/config/go======================"
echo -e "`sed 's/\r$//' /boot/config/go`"
echo "==============================END=============================="
