<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchKey = '{{ $search_key ?? 'table' }}';
        const table = $(`#${searchKey}`);
        if (table) {
            table.DataTable({
                "language": {
                    "decimal": "",
                    "emptyTable": "Данные в таблице отсутствуют",
                    "info": "Показана страница _PAGE_ из _PAGES_",
                    "infoEmpty": "{{ $info_empty ?? '' }}",
                    "infoFiltered": "(отфильтровано по _MAX_ общим записям)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Показано _MENU_ записей на страницу",
                    "loadingRecords": "Загрузка...",
                    "processing": "",
                    "search": "Поиск:",
                    "zeroRecords": "Ничего не найдено",
                    "paginate": {
                        "first": "Первый",
                        "last": "Последний",
                        "next": "Следующий",
                        "previous": "Предыдущий"
                    },
                    "aria": {
                        "sortAscending":  ": активировать для сортировки столбцов по возрастанию",
                        "sortDescending": ": активировать для сортировки столбцов по убыванию"
                    },
                    'buttons': {
                        'copy': 'Копировать',
                        'print': 'Печать',
                        'colvis': 'Видимость колонок',
                    },
                },
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": {!! $buttons ?? '["copy", "csv", "excel", "pdf", "print", "colvis"]' !!},
                "order": [{!! $ordering ?? "[1, 'asc']" !!}],
            }).buttons().container().appendTo(`#${searchKey}_wrapper .col-md-6:eq(0)`);
        }
    });
</script>
