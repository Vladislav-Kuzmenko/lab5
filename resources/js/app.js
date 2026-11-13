import './bootstrap';
import $ from 'jquery';
import select2 from 'select2';
import 'select2/dist/css/select2.css';

import duallistbox from 'bootstrap4-duallistbox';
import 'bootstrap4-duallistbox/dist/bootstrap-duallistbox.css';

window.$ = window.jQuery = $;

// Ініціалізація Select2
select2(window, $);
$(function () {
    $('#teams_select').select2({
        width: '100%',
        placeholder: 'Оберіть клуби, яких стосується новина',
    });
});

// Ініціалізація DualListBox
duallistbox(window, $);
$(function () {
    $('#duallist').bootstrapDualListbox({
        nonSelectedListLabel: 'Доступні клуби',
        selectedListLabel: 'Обрані клуби',
        preserveSelectionOnMove: 'moved',
        moveOnSelect: false,
        infoText: 'Усього {0}',
        filterPlaceHolder: 'Пошук клубу',
    });
});
