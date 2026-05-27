import './bootstrap';
import '../css/app.css';

import Alpine from 'alpinejs';

import TomSelect from 'tom-select';
import 'tom-select/dist/css/tom-select.css';

window.Alpine = Alpine;
window.TomSelect = TomSelect;

Alpine.start();

new TomSelect('#fieldOfficeSelect', {
    create: false,
    sortField: {
        field: 'text',
        direction: 'asc'
    }
});
