#!/bin/bash
if [ -f "/boot/config/plugins/community.applications/proxy.cfg" ]; then
    echo "===cat /boot/config/plugins/community.applications/proxy.cfg==="
    # if the file is DOS format (CRLF), the unraid web will fail to show the text.
    echo -e "`sed 's/\r$//' /boot/config/plugins/community.applications/proxy.cfg`"
    echo "==============================END=============================="
else 
    echo "CA proxy.cfg 文件(/boot/config/plugins/community.applications/proxy.cfg)不存在, CA当前没有使用代理"
fi

echo ""
echo "======================cat /boot/config/go======================"
echo -e "`sed 's/\r$//' /boot/config/go`"
echo "==============================END=============================="

echo ""
echo "=======================cat /etc/profile========================"
echo -e "`sed 's/\r$//' /etc/profile`"
echo "==============================END=============================="

echo ""
if [ -f "/root/.wgetrc" ]; then
    echo "=======================cat /root/.wgetrc======================="
    echo -e "`sed 's/\r$//' /root/.wgetrc`"
    echo "==============================END=============================="
else 
    echo "wget 配置文件(/root/.wgetrc)不存在, wget 当前没有使用代理"
fi
