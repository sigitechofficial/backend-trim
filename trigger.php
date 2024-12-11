<?php
// Paths
$workingDir = '/home/trimworldwide/pb.trimworldwide.com';
$nodePath = '/home/trimworldwide/.nvm/versions/node/v18.20.4/bin/node';
$npmPath = '/home/trimworldwide/.nvm/versions/node/v18.20.4/bin/npm';
$exportPath = 'export PATH=$PATH:/home/trimworldwide/.nvm/versions/node/v18.20.4/bin';

// Logging function
function log_output($step, $output) {
    file_put_contents('/home/trimworldwide/logs/trigger.log', "[$step]:\n$output\n\n", FILE_APPEND);
}

// Set permissions
$binaryPermissions = shell_exec("chmod +x $nodePath $npmPath 2>&1");
log_output('Set Binary Permissions', $binaryPermissions);

$dirPermissions = shell_exec("chmod -R 775 $workingDir 2>&1");
log_output('Set Directory Permissions', $dirPermissions);

// PM2 Management
$processName = 'thetrim.js';
$pm2Commands = [
    "cd $workingDir",
    "pm2 stop $processName || true && pm2 delete $processName || true",
    "pm2 save",
    "$npmPath install",
    "pm2 start $processName",
    "pm2 save"
];

$finalCommand = $exportPath . ' && ' . implode(' && ', $pm2Commands);
$pm2Output = shell_exec("$finalCommand 2>&1");
log_output('PM2 and NPM Install', $pm2Output);

// Output Summary
echo "Script Execution Complete. Check logs for details.";
?>
