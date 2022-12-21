#!/bin/sh

# Given a version name and source code directory, create the snmp-unraid package
# Example: bash /boot/createpackage.sh 1337-01-01b /boot/pluginSource/


# https://vaneyckt.io/posts/safer_bash_scripts_with_set_euxo_pipefail/
set -euo pipefail

package_name="proxy.editor"

echo "Version defined as [$1]"
echo "Source code directory defined as [$2]"

# Check that makepkg is available.
# Redirect STDOUT to /dev/null so if it is available, it doesn't print
# https://stackoverflow.com/questions/26675681/how-to-check-the-exit-status-using-an-if-statement
if command -v makepkg > /dev/null; then
    # Assemble the output package file name using the directory we started in
    file_name=$(printf "%s/%s-%s.txz" "$(pwd)" "$package_name" "$1")

    # Move to directory containing files and folders going into the package
    cd "$2"

    echo "Setting permission..."
    find . -type d -print0 | xargs -0 chmod 755 
    find . -type f -print0 | xargs -0 chmod 644
    find . -type f -iname "*.sh" -print0 | xargs -0 chmod a+x

    echo "Cleaning up .DS_Store files in source code directory first..."
    find . -name '.DS_Store' -type f -delete

    echo "Creating Slackware package $file_name"
    makepkg -l y -c n  "$file_name"

    echo "MD5 of $file_name is $(md5sum $file_name | awk '{print $1}')"
else
    echo "Binary makepkg not found, is your OS Slackware?"
fi

exit 0
