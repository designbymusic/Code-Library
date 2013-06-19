var mongoose = require('mongoose');
var Schema = mongoose.Schema;
module.exports.mongoose = mongoose;
module.exports.Schema = Schema;
// Connect to cloud database
var username = "dash"
var password = "armada";
var address = '@ds057867.mongolab.com:57867/nodechapter1'; connect();
// Connect to mongo
function connect() {
  var url = 'mongodb://' + username + ':' + password + address;
  mongoose.connect(url);
}
function disconnect() {mongoose.disconnect()}