var exec = require('child_process').exec;

var login = process.argv[2];
var pass = process.argv[3];
var server=process.argv[4];
var disks = process.argv.slice(5).join(' ');

var cmd = 'rdesktop -f -u '+login+' -p '+pass+' -r sound:local '+disks+' '+server;

exec(cmd, function(error, stdout, stderr) {
  console.log(stdout);
});
console.log(disks);