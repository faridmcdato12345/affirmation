// JS
import LazyLoad from "~vanilla-lazyload";
import './bootstrap';
import * as bootstrap from '~bootstrap';
import './custom';
import Alpine from 'alpinejs'
// CSS
import '../css/app.css';
import '../css/bootstrap.css';
import '../css/style.css';
import '../sass/star_rating.scss';

window.bootstrap = bootstrap
window.LazyLoad = LazyLoad
window.Alpine = Alpine
Alpine.start()