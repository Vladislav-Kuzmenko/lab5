import './bootstrap';
import $ from 'jquery';
import select2 from 'select2';
import 'select2/dist/css/select2.css';

import duallistbox from 'bootstrap4-duallistbox';
import 'bootstrap4-duallistbox/dist/bootstrap-duallistbox.css';

import Alpine from 'alpinejs';

window.$ = window.jQuery = $;
window.Alpine = Alpine;

// Ініціалізація Select2
select2(window, $);
$(function () {
    if ($('#teams_select').length) {
        $('#teams_select').select2({
            width: '100%',
            placeholder: 'Оберіть клуби, яких стосується новина',
        });
    }
});

// Ініціалізація DualListBox
duallistbox(window, $);
$(function () {
    if ($('#duallist').length) {
        $('#duallist').bootstrapDualListbox({
            nonSelectedListLabel: 'Доступні клуби',
            selectedListLabel: 'Обрані клуби',
            preserveSelectionOnMove: 'moved',
            moveOnSelect: false,
            infoText: 'Усього {0}',
            filterPlaceHolder: 'Пошук клубу',
        });
    }
});

// Запуск Alpine.js для Breeze
Alpine.start();
