<?php
// Path to your working directory
$workingDir = '/home/trimworldwide/pb.trimworldwide.com';

// Full path to node and npm binaries
$nodePath = '/home/trimworldwide/.nvm/versions/node/v18.20.4/bin/node';
$npmPath = '/home/trimworldwide/.nvm/versions/node/v18.20.4/bin/npm';

// Export PATH for the script to find node and npm
$exportPath = 'export PATH=$PATH:/home/trimworldwide/.nvm/versions/node/v18.20.4/bin';

// Set permissions for node and npm binaries
$setBinaryPermissions = shell_exec("chmod +x $nodePath $npmPath 2>&1");

// Set permissions for the working directory
$setDirPermissions = shell_exec("chmod -R 775 $workingDir 2>&1");

// Define the process name for PM2
$processName = 'thetrim.js';

// PM2 commands
$pm2StopDeleteCommand = "pm2 stop $processName || true && pm2 delete $processName || true";
$pm2SaveCommand = "pm2 save";
$pm2CreateCommand = "$npmPath install && pm2 start $processName && pm2 save";

// Combine commands to execute
$command = "$exportPath && cd $workingDir && $pm2StopDeleteCommand && $pm2SaveCommand && $pm2CreateCommand 2>&1";

// Execute the final command
$output = shell_exec($command);

// Display outputs
echo "Binary Permissions Output:<br />" . nl2br($setBinaryPermissions) . "<br />";
echo "Directory Permissions Output:<br />" . nl2br($setDirPermissions) . "<br />";
echo "PM2 and NPM Install Output:<br />" . nl2br($output) . "<br />";