// app setup

// load express web server
var express = require('express');

// load template enging 
var exphbs  = require('express-handlebars');

// load livereload package and configure
var livereload = require('livereload');

// start livereload server
var lrServer = livereload.createServer({'exts':"handlebars"});

// create array of directories to watch for file changes
var lrWatchDirs=[__dirname + "/public", __dirname + "/views/"];

// load database package and set async mode
const low = require('lowdb')
const fileAsync = require('lowdb/lib/storages/file-async')

// initialize and configure express server
var app = express();
app.use(express.static('public'));
app.engine('handlebars', exphbs({defaultLayout: 'main'}));
app.set('view engine', 'handlebars');

// tell live reload server folders to watch
lrServer.watch(lrWatchDirs);

// end app setup

// route setup
app.get('/', function(req, res){
  res.redirect('/all');
});

app.get('/all', function(req, res){
  res.render('allpictures', {
    menuitem : {
      all:true
    }
  });
});

app.get('/familiarfaces', function(req, res){
  res.render('knownfaces', {
    menuitem : {
      familiarfaces:true
    }
  });
});

app.get('/newfaces', function(req, res){
  res.render('newfaces', {
    menuitem : {
      newfaces:true
    }
  });
});

app.get('/timelapse', function(req, res){
  res.render('timelapse', {
    menuitem : {
      timelapse:true
    }
  });
});

app.get('/stats', function(req, res){
  res.render('stats', {
    menuitem : {
      stats:true
    }
  });
});

// end route setup

// start taking requests
var server = app.listen(8000, function () {
  var host = server.address().address;
  var port = server.address().port;
  console.log('listening at http://%s:%s', host, port);
});
