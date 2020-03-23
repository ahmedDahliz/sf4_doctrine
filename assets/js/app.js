
const $ = require('jquery');
require('bootstrap');
$(document).ready(function() { $('[data-toggle="popover"]').popover(); });
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.scss';