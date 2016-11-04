var base = require('../basemodule_component_site');
var path = require('path');

var name = path.basename(__filename).replace('.js', '');
var group = path.basename(path.dirname(__filename));

base.addModule(name, group);
